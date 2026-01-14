<?php

namespace Brandonjjon\Printavo\Console;

use Brandonjjon\Printavo\Exceptions\AuthenticationException;
use Brandonjjon\Printavo\Exceptions\PrintavoException;
use Brandonjjon\Printavo\PrintavoClient;
use Brandonjjon\Printavo\Schema\IntrospectionQuery;
use Brandonjjon\Printavo\Schema\SchemaParser;
use Illuminate\Console\Command;

class PrintavoSchemaFetchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'printavo:schema:fetch
                            {--output= : Path to save schema JSON (default: packages/printavo/schema.json)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Printavo GraphQL schema via introspection';

    /**
     * Execute the console command.
     */
    public function handle(PrintavoClient $client): int
    {
        $this->info('Fetching schema from Printavo API...');
        $this->newLine();

        try {
            // Fetch raw introspection data
            $introspection = new IntrospectionQuery($client);
            $rawData = $introspection->fetch();

            // Parse into structured schema
            $parser = new SchemaParser;
            $schema = $parser->parse($rawData);

            // Display summary
            $objectTypes = count($schema->getObjectTypes());
            $inputTypes = count($schema->getInputTypes());
            $enumTypes = count($schema->getEnumTypes());

            $queryType = $schema->getQueryType();
            $mutationType = $schema->getMutationType();

            $queryCount = $queryType ? count($queryType->fields) : 0;
            $mutationCount = $mutationType ? count($mutationType->fields) : 0;

            $this->components->info('Schema fetched successfully!');
            $this->newLine();

            $this->line('  <comment>Types:</comment>');
            $this->line("    Object types: <info>{$objectTypes}</info>");
            $this->line("    Input types:  <info>{$inputTypes}</info>");
            $this->line("    Enum types:   <info>{$enumTypes}</info>");
            $this->newLine();
            $this->line('  <comment>Operations:</comment>');
            $this->line("    Queries:      <info>{$queryCount}</info>");
            $this->line("    Mutations:    <info>{$mutationCount}</info>");
            $this->newLine();

            // Determine output path
            $outputPath = $this->option('output') ?? base_path('packages/printavo/schema.json');

            // Ensure directory exists
            $directory = dirname($outputPath);
            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            // Save schema as JSON
            $json = json_encode($schema->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            file_put_contents($outputPath, $json);

            $this->components->info("Schema saved to {$outputPath}");

            return self::SUCCESS;
        } catch (AuthenticationException $e) {
            $this->components->error('Authentication failed');
            $this->newLine();
            $this->warn('Check your PRINTAVO_EMAIL and PRINTAVO_TOKEN in .env');

            return self::FAILURE;
        } catch (PrintavoException $e) {
            $this->components->error('Printavo API error: '.$e->getMessage());

            return self::FAILURE;
        } catch (\Exception $e) {
            $this->components->error('Failed to fetch schema: '.$e->getMessage());

            return self::FAILURE;
        }
    }
}
