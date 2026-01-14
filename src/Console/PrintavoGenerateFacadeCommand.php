<?php

namespace Brandonjjon\Printavo\Console;

use Brandonjjon\Printavo\Schema\FacadeGenerator;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class PrintavoGenerateFacadeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'printavo:generate:facade
                            {--dry-run : Show what would be generated without writing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Printavo manager class and Facade PHPDoc from generated builders';

    /**
     * The base path to the package.
     */
    protected string $packagePath;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->packagePath = dirname(__DIR__);

        $this->info('Printavo Facade Generator');
        $this->newLine();

        try {
            // Scan for query builders
            $queryBuilders = $this->scanQueryBuilders();
            $this->line('  Found <info>'.count($queryBuilders).'</info> query builders');

            // Scan for mutation builders
            $mutationBuilders = $this->scanMutationBuilders();
            $this->line('  Found <info>'.count($mutationBuilders).'</info> mutation builders');

            $this->newLine();

            // Generate using FacadeGenerator
            $generator = new FacadeGenerator;

            // Generate manager class
            $managerCode = $generator->generateManager($queryBuilders, $mutationBuilders);
            $managerPath = $this->packagePath.'/Printavo.php';

            // Generate facade PHPDoc
            $facadePhpDoc = $generator->generateFacadePHPDoc($queryBuilders, $mutationBuilders);

            if ($this->option('dry-run')) {
                $this->showDryRun($managerCode, $facadePhpDoc);
            } else {
                // Backup and write manager
                $this->writeManager($managerPath, $managerCode);

                // Update facade PHPDoc
                $facadePath = $this->packagePath.'/Facades/Printavo.php';
                $this->updateFacade($facadePath, $facadePhpDoc);

                // Run Pint on modified files
                $this->runPint($managerPath, $facadePath);
            }

            // Summary
            $this->newLine();
            $this->components->info('Generation complete!');
            $this->newLine();
            $this->line('  <comment>Summary:</comment>');
            $this->line('    Query builder methods:    <info>'.count($queryBuilders).'</info>');
            $this->line('    Mutation builder methods: <info>'.count($mutationBuilders).'</info>');
            $this->line('    Total methods:            <info>'.(count($queryBuilders) + count($mutationBuilders)).'</info>');

            if ($this->option('dry-run')) {
                $this->newLine();
                $this->warn('  Dry run - no files were written');
            }

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->components->error('Failed to generate facade: '.$e->getMessage());

            return self::FAILURE;
        }
    }

    /**
     * Scan for generated query builder classes.
     *
     * @return array<string>
     */
    protected function scanQueryBuilders(): array
    {
        return $this->scanGeneratedClasses(
            directory: $this->packagePath.'/Resources/Generated',
            pattern: '*Builder.php',
            namespace: 'Brandonjjon\\Printavo\\Resources\\Generated',
        );
    }

    /**
     * Scan for generated mutation builder classes.
     *
     * @return array<string>
     */
    protected function scanMutationBuilders(): array
    {
        return $this->scanGeneratedClasses(
            directory: $this->packagePath.'/Mutations/Generated',
            pattern: '*Mutations.php',
            namespace: 'Brandonjjon\\Printavo\\Mutations\\Generated',
        );
    }

    /**
     * Scan a directory for generated classes matching a pattern.
     *
     * @return array<string>
     */
    protected function scanGeneratedClasses(string $directory, string $pattern, string $namespace): array
    {
        if (! is_dir($directory)) {
            return [];
        }

        $files = glob("{$directory}/{$pattern}");
        $classes = array_map(
            fn (string $file) => "{$namespace}\\".basename($file, '.php'),
            $files
        );

        sort($classes);

        return $classes;
    }

    /**
     * Show dry run output.
     */
    protected function showDryRun(string $managerCode, string $facadePhpDoc): void
    {
        $this->line('<comment>Would generate Printavo.php:</comment>');
        $this->newLine();
        $this->line($managerCode);
        $this->newLine();

        $this->line('<comment>Would update Facades/Printavo.php PHPDoc:</comment>');
        $this->newLine();
        $this->line($facadePhpDoc);
    }

    /**
     * Write the manager class file.
     */
    protected function writeManager(string $path, string $code): void
    {
        // Backup existing if it exists
        if (file_exists($path)) {
            $backupPath = $path.'.bak';
            copy($path, $backupPath);
            $this->line('  Backed up existing Printavo.php to <info>Printavo.php.bak</info>');
        }

        file_put_contents($path, $code);
        $this->line('  Generated <info>Printavo.php</info>');
    }

    /**
     * Update the Facade PHPDoc block.
     */
    protected function updateFacade(string $path, string $phpDoc): void
    {
        if (! file_exists($path)) {
            $this->warn("  Facade file not found at {$path}");

            return;
        }

        $content = file_get_contents($path);

        // Find and replace the PHPDoc block before "class Printavo extends Facade"
        // Pattern: /** ... */ class Printavo
        $pattern = '/\/\*\*[\s\S]*?\*\/\s*class Printavo extends Facade/';
        $replacement = $phpDoc."\nclass Printavo extends Facade";

        $newContent = preg_replace($pattern, $replacement, $content);

        if ($newContent === $content) {
            $this->warn('  Could not find PHPDoc block to replace in Facade');

            return;
        }

        file_put_contents($path, $newContent);
        $this->line('  Updated <info>Facades/Printavo.php</info> PHPDoc');
    }

    /**
     * Run Laravel Pint on the modified files.
     */
    protected function runPint(string $managerPath, string $facadePath): void
    {
        $this->newLine();
        $this->line('<comment>Running Pint formatter...</comment>');

        $pintPath = base_path('vendor/bin/pint');
        $paths = [$managerPath, $facadePath];

        foreach ($paths as $path) {
            (new Process([$pintPath, $path]))->run();
        }

        $this->line('  <info>Formatting complete</info>');
    }
}
