<?php

namespace Brandonjjon\Printavo\Console;

use Brandonjjon\Printavo\Exceptions\AuthenticationException;
use Brandonjjon\Printavo\Exceptions\PrintavoException;
use Brandonjjon\Printavo\Exceptions\RateLimitException;
use Brandonjjon\Printavo\PrintavoClient;
use Illuminate\Console\Command;

class PrintavoTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'printavo:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test connection to Printavo API';

    /**
     * Execute the console command.
     */
    public function handle(PrintavoClient $client): int
    {
        $this->info('Testing Printavo connection...');
        $this->newLine();

        try {
            // Execute a simple query to test the connection
            $result = $client->fresh()->query('query { account { id companyName } }');

            $accountName = $result['account']['companyName'] ?? 'Unknown';
            $rateLimiter = $client->getRateLimiter();

            $this->components->info('Connected successfully!');
            $this->line("  Account: <comment>{$accountName}</comment>");
            $this->line("  Rate limit: <comment>{$rateLimiter->remaining()}/{$rateLimiter->getMaxRequests()}</comment> requests available");

            return self::SUCCESS;
        } catch (AuthenticationException $e) {
            $this->components->error('Authentication failed');
            $this->newLine();
            $this->warn('Check your PRINTAVO_EMAIL and PRINTAVO_TOKEN in .env');

            return self::FAILURE;
        } catch (RateLimitException $e) {
            $this->components->warn("Rate limited - try again in {$e->retryAfter} seconds");

            return self::FAILURE;
        } catch (PrintavoException $e) {
            $this->components->error($e->getMessage());
            $this->newLine();
            $this->warn('Check that your PRINTAVO_ENDPOINT is correct');

            return self::FAILURE;
        } catch (\Exception $e) {
            $this->components->error('Connection failed: '.$e->getMessage());
            $this->newLine();
            $this->warn('Check your network connection and PRINTAVO_ENDPOINT');

            return self::FAILURE;
        }
    }
}
