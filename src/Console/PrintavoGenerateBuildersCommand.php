<?php

namespace Brandonjjon\Printavo\Console;

use Brandonjjon\Printavo\Console\Concerns\ParsesSchema;
use Brandonjjon\Printavo\PrintavoClient;
use Brandonjjon\Printavo\Schema\MutationBuilderGenerator;
use Brandonjjon\Printavo\Schema\ParsedSchema;
use Brandonjjon\Printavo\Schema\QueryBuilderGenerator;
use Brandonjjon\Printavo\Schema\TypeMapper;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class PrintavoGenerateBuildersCommand extends Command
{
    use ParsesSchema;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'printavo:generate:builders
                            {--schema= : Path to schema.json (default: packages/printavo/schema.json)}
                            {--fresh : Fetch fresh schema from API}
                            {--dry-run : Show what would be generated without writing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate query and mutation builder classes from Printavo GraphQL schema';

    /**
     * Output directory for generated query builders.
     */
    protected string $queryBuildersDir;

    /**
     * Output directory for generated mutation builders.
     */
    protected string $mutationBuildersDir;

    /**
     * Execute the console command.
     */
    public function handle(PrintavoClient $client): int
    {
        $this->queryBuildersDir = dirname(__DIR__).'/Resources/Generated';
        $this->mutationBuildersDir = dirname(__DIR__).'/Mutations/Generated';

        $this->info('Printavo Builder Generator');
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
            $queryBuilderGenerator = new QueryBuilderGenerator($typeMapper);
            $mutationBuilderGenerator = new MutationBuilderGenerator($typeMapper);

            // Generate query builders
            $queryBuilderCount = $this->generateQueryBuilders($schema, $queryBuilderGenerator);

            // Generate mutation builders
            $mutationBuilderCount = $this->generateMutationBuilders($schema, $mutationBuilderGenerator);

            // Run Pint on generated files (unless dry-run)
            if (! $this->option('dry-run') && ($queryBuilderCount > 0 || $mutationBuilderCount > 0)) {
                $this->runPint();
            }

            // Summary
            $this->newLine();
            $this->components->info('Generation complete!');
            $this->newLine();
            $this->line('  <comment>Generated:</comment>');
            $this->line("    Query Builders:    <info>{$queryBuilderCount}</info>");
            $this->line("    Mutation Builders: <info>{$mutationBuilderCount}</info>");

            if ($this->option('dry-run')) {
                $this->newLine();
                $this->warn('  Dry run - no files were written');
            }

            return self::SUCCESS;
        } catch (\Throwable $e) {
            return $this->handleApiException($e, 'generate builders');
        }
    }

    /**
     * Ensure output directories exist.
     */
    protected function ensureDirectoriesExist(): void
    {
        $dirs = [$this->queryBuildersDir, $this->mutationBuildersDir];

        foreach ($dirs as $dir) {
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
        }
    }

    /**
     * Generate query builders for all eligible Query fields.
     */
    protected function generateQueryBuilders(ParsedSchema $schema, QueryBuilderGenerator $generator): int
    {
        $this->line('<comment>Query Builders:</comment>');
        $count = 0;

        $queryType = $schema->getQueryType();
        if ($queryType === null) {
            $this->warn('  No Query type found in schema');

            return 0;
        }

        $fields = $queryType->fields;
        $eligibleFields = array_filter($fields, fn ($field) => $generator->shouldGenerate($field, $schema));
        $total = count($eligibleFields);

        foreach ($eligibleFields as $field) {
            $code = $generator->generate($field, $schema);
            $className = $generator->getClassName($field);
            $filename = "{$className}.php";
            $filePath = "{$this->queryBuildersDir}/{$filename}";

            $count++;

            if ($this->option('dry-run')) {
                $this->line("  [{$count}/{$total}] Would generate: <info>{$filename}</info>");
            } else {
                file_put_contents($filePath, $code);
                $this->line("  [{$count}/{$total}] Generated: <info>{$filename}</info>");
            }
        }

        if ($count === 0) {
            $this->line('  <comment>No query builders to generate</comment>');
        }

        $this->newLine();

        return $count;
    }

    /**
     * Generate mutation builders for all eligible resources.
     */
    protected function generateMutationBuilders(ParsedSchema $schema, MutationBuilderGenerator $generator): int
    {
        $this->line('<comment>Mutation Builders:</comment>');
        $count = 0;

        $resources = $generator->getResourcesWithMutations($schema);
        $eligibleResources = array_filter($resources, fn ($resource) => $generator->shouldGenerate($resource, $schema));
        $total = count($eligibleResources);

        foreach ($eligibleResources as $resource) {
            $code = $generator->generate($resource, $schema);
            $className = $generator->getClassName($resource);
            $filename = "{$className}.php";
            $filePath = "{$this->mutationBuildersDir}/{$filename}";

            $count++;

            if ($this->option('dry-run')) {
                $this->line("  [{$count}/{$total}] Would generate: <info>{$filename}</info>");
            } else {
                file_put_contents($filePath, $code);
                $this->line("  [{$count}/{$total}] Generated: <info>{$filename}</info>");
            }
        }

        if ($count === 0) {
            $this->line('  <comment>No mutation builders to generate</comment>');
        }

        $this->newLine();

        return $count;
    }

    /**
     * Run Laravel Pint on generated files.
     */
    protected function runPint(): void
    {
        $this->line('<comment>Running Pint formatter...</comment>');

        $pintPath = base_path('vendor/bin/pint');
        $dirs = [$this->queryBuildersDir, $this->mutationBuildersDir];

        foreach ($dirs as $dir) {
            if (is_dir($dir)) {
                (new Process([$pintPath, $dir]))->run();
            }
        }

        $this->line('  <info>Formatting complete</info>');
        $this->newLine();
    }
}
