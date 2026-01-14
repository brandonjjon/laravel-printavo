<?php

namespace Brandonjjon\Printavo\Console;

use Brandonjjon\Printavo\Console\Concerns\ParsesSchema;
use Brandonjjon\Printavo\PrintavoClient;
use Brandonjjon\Printavo\Schema\DTOGenerator;
use Brandonjjon\Printavo\Schema\EnumGenerator;
use Brandonjjon\Printavo\Schema\FacadeGenerator;
use Brandonjjon\Printavo\Schema\FieldConstantsGenerator;
use Brandonjjon\Printavo\Schema\MutationBuilderGenerator;
use Brandonjjon\Printavo\Schema\ParsedSchema;
use Brandonjjon\Printavo\Schema\QueryBuilderGenerator;
use Brandonjjon\Printavo\Schema\SchemaDiff;
use Brandonjjon\Printavo\Schema\SchemaDiffer;
use Brandonjjon\Printavo\Schema\TypeMapper;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class PrintavoGenerateCommand extends Command
{
    use ParsesSchema;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'printavo:generate
                            {--dry-run : Preview changes without writing files}
                            {--force : Skip diff confirmation and always regenerate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Printavo schema and regenerate all code (DTOs, Builders, Facade)';

    /**
     * Path to the schema.json file.
     */
    protected string $schemaPath;

    /**
     * Base path to the package.
     */
    protected string $packagePath;

    /**
     * Directory paths for generated code.
     */
    protected string $dtoDir;

    protected string $enumDir;

    protected string $fieldsDir;

    protected string $queryBuildersDir;

    protected string $mutationBuildersDir;

    /**
     * Execute the console command.
     */
    public function handle(PrintavoClient $client): int
    {
        $this->initializePaths();

        $this->components->info('Printavo Code Generator');
        $this->newLine();

        try {
            $schema = $this->loadAndCompareSchema($client);
            $counts = $this->runAllGenerators($schema);
            $this->displaySummary($counts);

            return self::SUCCESS;
        } catch (\Throwable $e) {
            return $this->handleApiException($e, 'generate code');
        }
    }

    /**
     * Initialize all directory paths.
     */
    protected function initializePaths(): void
    {
        $this->packagePath = dirname(__DIR__);
        $this->schemaPath = base_path('packages/printavo/schema.json');
        $this->dtoDir = $this->packagePath.'/Data/Generated';
        $this->enumDir = $this->dtoDir.'/Enums';
        $this->fieldsDir = $this->dtoDir.'/Fields';
        $this->queryBuildersDir = $this->packagePath.'/Resources/Generated';
        $this->mutationBuildersDir = $this->packagePath.'/Mutations/Generated';
    }

    /**
     * Load existing schema, fetch fresh one, compare, and save.
     */
    protected function loadAndCompareSchema(PrintavoClient $client): ParsedSchema
    {
        $oldSchema = $this->loadExistingSchema();
        if ($oldSchema !== null) {
            $this->line('  Loaded existing schema from <info>schema.json</info>');
        } else {
            $this->line('  No existing schema found (first generation)');
        }

        $this->newLine();
        $this->line('<comment>Fetching fresh schema from Printavo API...</comment>');
        $newSchema = $this->fetchFreshSchema($client);
        $this->line('  Schema fetched: <info>'.count($newSchema->types).'</info> types');

        if ($oldSchema !== null && ! $this->option('force')) {
            $this->newLine();
            $diff = $this->showDiff($oldSchema, $newSchema);

            if ($diff->isEmpty()) {
                $this->newLine();
                $this->components->info('Schema unchanged from previous version');

                if (! $this->option('dry-run')) {
                    $this->line('  Regenerating code to ensure consistency...');
                }
            }
        }

        if (! $this->option('dry-run')) {
            $this->saveSchema($newSchema);
            $this->line('  Schema saved to <info>schema.json</info>');
            $this->ensureDirectoriesExist();
        }

        return $newSchema;
    }

    /**
     * Run all code generators and return counts.
     *
     * @return array{dtos: int, fields: int, enums: int, queryBuilders: int, mutationBuilders: int, facade: int}
     */
    protected function runAllGenerators(ParsedSchema $schema): array
    {
        $this->newLine();
        $this->line('<comment>Generating code...</comment>');
        $this->newLine();

        $enumTypeNames = array_keys($schema->getEnumTypes());
        $typesWithId = $schema->getTypesWithIdField();
        $typeMapper = new TypeMapper($enumTypeNames, $typesWithId);

        $dtoGenerator = new DTOGenerator($typeMapper);
        $enumGenerator = new EnumGenerator;
        $fieldConstantsGenerator = new FieldConstantsGenerator($typeMapper);
        $queryBuilderGenerator = new QueryBuilderGenerator($typeMapper);
        $mutationBuilderGenerator = new MutationBuilderGenerator($typeMapper);
        $facadeGenerator = new FacadeGenerator;

        $counts = [
            'dtos' => $this->generateDtos($schema, $dtoGenerator),
            'fields' => $this->generateFieldConstants($schema, $dtoGenerator, $fieldConstantsGenerator),
            'enums' => $this->generateEnums($schema, $enumGenerator),
            'queryBuilders' => $this->generateQueryBuilders($schema, $queryBuilderGenerator),
            'mutationBuilders' => $this->generateMutationBuilders($schema, $mutationBuilderGenerator),
            'facade' => $this->generateFacade($facadeGenerator),
        ];

        if (! $this->option('dry-run')) {
            $this->runPint();
        }

        return $counts;
    }

    /**
     * Display generation summary.
     *
     * @param  array{dtos: int, fields: int, enums: int, queryBuilders: int, mutationBuilders: int, facade: int}  $counts
     */
    protected function displaySummary(array $counts): void
    {
        $this->newLine();
        $this->components->info('Generation complete!');
        $this->newLine();
        $this->line('  <comment>Generated:</comment>');
        $this->line("    DTOs:              <info>{$counts['dtos']}</info>");
        $this->line("    Field Constants:   <info>{$counts['fields']}</info>");
        $this->line("    Enums:             <info>{$counts['enums']}</info>");
        $this->line("    Query Builders:    <info>{$counts['queryBuilders']}</info>");
        $this->line("    Mutation Builders: <info>{$counts['mutationBuilders']}</info>");
        $this->line("    Facade methods:    <info>{$counts['facade']}</info>");

        $total = $counts['dtos'] + $counts['fields'] + $counts['enums'] + $counts['queryBuilders'] + $counts['mutationBuilders'];
        $this->newLine();
        $this->line("    <comment>Total files:</comment>        <info>{$total}</info>");

        if ($this->option('dry-run')) {
            $this->newLine();
            $this->warn('  Dry run - no files were written');
        }
    }

    /**
     * Load existing schema from schema.json if it exists.
     */
    protected function loadExistingSchema(): ?ParsedSchema
    {
        if (! file_exists($this->schemaPath)) {
            return null;
        }

        $json = file_get_contents($this->schemaPath);
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->warn('  Existing schema.json is invalid, treating as first generation');

            return null;
        }

        return $this->parseSerializedSchema($data);
    }

    /**
     * Save the schema to schema.json.
     */
    protected function saveSchema(ParsedSchema $schema): void
    {
        $json = json_encode($schema->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents($this->schemaPath, $json);
    }

    /**
     * Show schema diff report.
     */
    protected function showDiff(ParsedSchema $old, ParsedSchema $new): SchemaDiff
    {
        $differ = new SchemaDiffer;
        $diff = $differ->diff($old, $new);

        if ($diff->isEmpty()) {
            return $diff;
        }

        $this->line('<comment>Schema Changes Detected:</comment>');
        $this->newLine();

        $addedCount = count($diff->typesAdded);
        $removedCount = count($diff->typesRemoved);
        $modifiedCount = count($diff->typesModified);

        if ($addedCount > 0) {
            $types = implode(', ', array_slice($diff->typesAdded, 0, 5));
            $extra = $addedCount > 5 ? '...' : '';
            $this->line("  Types added:    <info>{$addedCount}</info> ({$types}{$extra})");
        }

        if ($removedCount > 0) {
            $types = implode(', ', array_slice($diff->typesRemoved, 0, 5));
            $extra = $removedCount > 5 ? '...' : '';
            $this->line("  Types removed:  <error>{$removedCount}</error> ({$types}{$extra})");
        }

        if ($modifiedCount > 0) {
            $this->line("  Types modified: <comment>{$modifiedCount}</comment>");
            $this->newLine();

            $this->line('  <comment>Modified types:</comment>');

            foreach ($diff->typesModified as $typeName => $changes) {
                $this->line("    <info>{$typeName}:</info>");

                foreach ($changes->fieldsAdded as $field) {
                    $this->line("      <info>+</info> {$field}");
                }

                foreach ($changes->fieldsRemoved as $field) {
                    $this->line("      <error>-</error> {$field}");
                }

                foreach ($changes->fieldsTypeChanged as $field => $change) {
                    $this->line("      <comment>~</comment> {$field}: {$change['old']} → {$change['new']}");
                }

                foreach ($changes->enumValuesAdded as $value) {
                    $this->line("      <info>+</info> (enum) {$value}");
                }

                foreach ($changes->enumValuesRemoved as $value) {
                    $this->line("      <error>-</error> (enum) {$value}");
                }
            }
        }

        return $diff;
    }

    /**
     * Ensure output directories exist.
     */
    protected function ensureDirectoriesExist(): void
    {
        $dirs = [
            $this->dtoDir,
            $this->enumDir,
            $this->fieldsDir,
            $this->queryBuildersDir,
            $this->mutationBuildersDir,
        ];

        foreach ($dirs as $dir) {
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
        }
    }

    /**
     * Generate DTOs for all eligible types.
     */
    protected function generateDtos(ParsedSchema $schema, DTOGenerator $generator): int
    {
        $count = 0;

        $types = array_merge(
            $schema->getObjectTypes(),
            $schema->getInputTypes(),
        );

        foreach ($types as $type) {
            if (! $generator->shouldGenerate($type)) {
                continue;
            }

            $code = $generator->generate($type);
            $className = $generator->toSafeClassName($type->name);
            $filename = "{$className}.php";
            $filePath = "{$this->dtoDir}/{$filename}";

            if (! $this->option('dry-run')) {
                file_put_contents($filePath, $code);
            }

            $count++;
        }

        $this->line("  DTOs: <info>{$count}</info> files");

        return $count;
    }

    /**
     * Generate field constants for all eligible types.
     */
    protected function generateFieldConstants(
        ParsedSchema $schema,
        DTOGenerator $dtoGenerator,
        FieldConstantsGenerator $generator,
    ): int {
        $count = 0;

        $types = array_merge(
            $schema->getObjectTypes(),
            $schema->getInputTypes(),
        );

        foreach ($types as $type) {
            if (! $generator->shouldGenerate($type)) {
                continue;
            }

            $safeClassName = $dtoGenerator->toSafeClassName($type->name);
            $code = $generator->generate($type, $safeClassName);
            $filename = "{$safeClassName}Fields.php";
            $filePath = "{$this->fieldsDir}/{$filename}";

            if (! $this->option('dry-run')) {
                file_put_contents($filePath, $code);
            }

            $count++;
        }

        $this->line("  Field constants: <info>{$count}</info> files");

        return $count;
    }

    /**
     * Generate enums for all eligible types.
     */
    protected function generateEnums(ParsedSchema $schema, EnumGenerator $generator): int
    {
        $count = 0;

        foreach ($schema->getEnumTypes() as $type) {
            if (! $generator->shouldGenerate($type)) {
                continue;
            }

            $code = $generator->generate($type);
            $filename = "{$type->name}.php";
            $filePath = "{$this->enumDir}/{$filename}";

            if (! $this->option('dry-run')) {
                file_put_contents($filePath, $code);
            }

            $count++;
        }

        $this->line("  Enums: <info>{$count}</info> files");

        return $count;
    }

    /**
     * Generate query builders for all eligible Query fields.
     */
    protected function generateQueryBuilders(ParsedSchema $schema, QueryBuilderGenerator $generator): int
    {
        $count = 0;

        $queryType = $schema->getQueryType();
        if ($queryType === null) {
            $this->line('  Query builders: <comment>0</comment> files (no Query type found)');

            return 0;
        }

        $fields = $queryType->fields;
        $eligibleFields = array_filter($fields, fn ($field) => $generator->shouldGenerate($field, $schema));

        foreach ($eligibleFields as $field) {
            $code = $generator->generate($field, $schema);
            $className = $generator->getClassName($field);
            $filename = "{$className}.php";
            $filePath = "{$this->queryBuildersDir}/{$filename}";

            if (! $this->option('dry-run')) {
                file_put_contents($filePath, $code);
            }

            $count++;
        }

        $this->line("  Query builders: <info>{$count}</info> files");

        return $count;
    }

    /**
     * Generate mutation builders for all eligible resources.
     */
    protected function generateMutationBuilders(ParsedSchema $schema, MutationBuilderGenerator $generator): int
    {
        $count = 0;

        $resources = $generator->getResourcesWithMutations($schema);
        $eligibleResources = array_filter($resources, fn ($resource) => $generator->shouldGenerate($resource, $schema));

        foreach ($eligibleResources as $resource) {
            $code = $generator->generate($resource, $schema);
            $className = $generator->getClassName($resource);
            $filename = "{$className}.php";
            $filePath = "{$this->mutationBuildersDir}/{$filename}";

            if (! $this->option('dry-run')) {
                file_put_contents($filePath, $code);
            }

            $count++;
        }

        $this->line("  Mutation builders: <info>{$count}</info> files");

        return $count;
    }

    /**
     * Generate Facade and Manager.
     */
    protected function generateFacade(FacadeGenerator $generator): int
    {
        // Scan for query builders
        $queryBuilders = [];
        if (is_dir($this->queryBuildersDir)) {
            $files = glob($this->queryBuildersDir.'/*Builder.php');
            foreach ($files as $file) {
                $className = basename($file, '.php');
                $queryBuilders[] = "Brandonjjon\\Printavo\\Resources\\Generated\\{$className}";
            }
        }

        // Scan for mutation builders
        $mutationBuilders = [];
        if (is_dir($this->mutationBuildersDir)) {
            $files = glob($this->mutationBuildersDir.'/*Mutations.php');
            foreach ($files as $file) {
                $className = basename($file, '.php');
                $mutationBuilders[] = "Brandonjjon\\Printavo\\Mutations\\Generated\\{$className}";
            }
        }

        // Generate manager class
        $managerCode = $generator->generateManager($queryBuilders, $mutationBuilders);
        $managerPath = $this->packagePath.'/Printavo.php';

        // Generate facade PHPDoc
        $facadePhpDoc = $generator->generateFacadePHPDoc($queryBuilders, $mutationBuilders);
        $facadePath = $this->packagePath.'/Facades/Printavo.php';

        if (! $this->option('dry-run')) {
            // Write manager
            file_put_contents($managerPath, $managerCode);

            // Update facade PHPDoc
            if (file_exists($facadePath)) {
                $content = file_get_contents($facadePath);
                $pattern = '/\/\*\*[\s\S]*?\*\/\s*class Printavo extends Facade/';
                $replacement = $facadePhpDoc."\nclass Printavo extends Facade";
                $newContent = preg_replace($pattern, $replacement, $content);

                if ($newContent !== $content) {
                    file_put_contents($facadePath, $newContent);
                }
            }
        }

        $totalMethods = count($queryBuilders) + count($mutationBuilders);
        $this->line("  Facade: <info>{$totalMethods}</info> methods (Printavo.php + Facade PHPDoc)");

        return $totalMethods;
    }

    /**
     * Run Laravel Pint on all generated directories.
     */
    protected function runPint(): void
    {
        $this->newLine();
        $this->line('<comment>Running Pint formatter...</comment>');

        $pintPath = base_path('vendor/bin/pint');

        $dirs = [
            $this->dtoDir,
            $this->queryBuildersDir,
            $this->mutationBuildersDir,
            $this->packagePath.'/Printavo.php',
            $this->packagePath.'/Facades/Printavo.php',
        ];

        foreach ($dirs as $path) {
            if (file_exists($path)) {
                $process = new Process([$pintPath, $path]);
                $process->run();
            }
        }

        $this->line('  <info>Formatting complete</info>');
    }
}
