<?php

namespace Brandonjjon\Printavo\Console;

use Brandonjjon\Printavo\Console\Concerns\ParsesSchema;
use Brandonjjon\Printavo\PrintavoClient;
use Brandonjjon\Printavo\Schema\DTOGenerator;
use Brandonjjon\Printavo\Schema\EnumGenerator;
use Brandonjjon\Printavo\Schema\FieldConstantsGenerator;
use Brandonjjon\Printavo\Schema\ParsedSchema;
use Brandonjjon\Printavo\Schema\TypeMapper;
use Illuminate\Console\Command;

class PrintavoGenerateDtosCommand extends Command
{
    use ParsesSchema;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'printavo:generate:dtos
                            {--schema= : Path to schema.json (default: packages/printavo/schema.json)}
                            {--fresh : Fetch fresh schema from API}
                            {--dry-run : Show what would be generated without writing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate DTO and enum classes from Printavo GraphQL schema';

    /**
     * Output directory for generated DTOs.
     */
    protected string $outputDir;

    /**
     * Output directory for generated enums.
     */
    protected string $enumOutputDir;

    /**
     * Output directory for generated field constants.
     */
    protected string $fieldsOutputDir;

    /**
     * Execute the console command.
     */
    public function handle(PrintavoClient $client): int
    {
        $this->outputDir = dirname(__DIR__).'/Data/Generated';
        $this->enumOutputDir = $this->outputDir.'/Enums';
        $this->fieldsOutputDir = $this->outputDir.'/Fields';

        $this->info('Printavo DTO Generator');
        $this->newLine();

        try {
            // Load or fetch schema
            $schema = $this->loadSchemaWithOutput($client);

            // Ensure output directories exist
            if (! $this->option('dry-run')) {
                $this->ensureDirectoriesExist();
            }

            // Initialize generators
            $enumTypeNames = array_keys($schema->getEnumTypes());
            $typesWithId = $schema->getTypesWithIdField();
            $typeMapper = new TypeMapper($enumTypeNames, $typesWithId);
            $dtoGenerator = new DTOGenerator($typeMapper);
            $enumGenerator = new EnumGenerator;
            $fieldConstantsGenerator = new FieldConstantsGenerator($typeMapper);

            // Generate DTOs
            $dtoCount = $this->generateDtos($schema, $dtoGenerator);

            // Generate field constants
            $fieldCount = $this->generateFieldConstants($schema, $dtoGenerator, $fieldConstantsGenerator);

            // Generate enums
            $enumCount = $this->generateEnums($schema, $enumGenerator);

            // Summary
            $this->newLine();
            $this->components->info('Generation complete!');
            $this->newLine();
            $this->line('  <comment>Generated:</comment>');
            $this->line("    DTOs:   <info>{$dtoCount}</info>");
            $this->line("    Fields: <info>{$fieldCount}</info>");
            $this->line("    Enums:  <info>{$enumCount}</info>");

            if ($this->option('dry-run')) {
                $this->newLine();
                $this->warn('  Dry run - no files were written');
            }

            return self::SUCCESS;
        } catch (\Throwable $e) {
            return $this->handleApiException($e, 'generate DTOs');
        }
    }

    /**
     * Ensure output directories exist.
     */
    protected function ensureDirectoriesExist(): void
    {
        $dirs = [$this->outputDir, $this->enumOutputDir, $this->fieldsOutputDir];

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

        // Combine object types and input types
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
            $filePath = "{$this->outputDir}/{$filename}";

            if ($this->option('dry-run')) {
                $this->line("  Would generate: <info>{$filename}</info>");
            } else {
                file_put_contents($filePath, $code);
                $this->line("  Generated: <info>{$filename}</info>");
            }

            $count++;
        }

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

        // Combine object types and input types
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
            $filePath = "{$this->fieldsOutputDir}/{$filename}";

            if ($this->option('dry-run')) {
                $this->line("  Would generate: <info>Fields/{$filename}</info>");
            } else {
                file_put_contents($filePath, $code);
                $this->line("  Generated: <info>Fields/{$filename}</info>");
            }

            $count++;
        }

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
            $filePath = "{$this->enumOutputDir}/{$filename}";

            if ($this->option('dry-run')) {
                $this->line("  Would generate: <info>Enums/{$filename}</info>");
            } else {
                file_put_contents($filePath, $code);
                $this->line("  Generated: <info>Enums/{$filename}</info>");
            }

            $count++;
        }

        return $count;
    }
}
