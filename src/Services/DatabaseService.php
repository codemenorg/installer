<?php

namespace Codemen\Installer\Services;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class DatabaseService
{
    /**
     * Run the migration and call the seeder.
     *
     * @return array
     */
    public function migrate()
    {
        $outputLog = new BufferedOutput;

        try {
            Artisan::call('migrate', ['--force' => true], $outputLog);
        } catch (Exception $e) {
            return $this->response($e->getMessage(), 'error', $outputLog);
        }

        return $this->response(__('Database migration has been completed successfully.'), 'success', $outputLog);
    }

    /**
     * Return a formatted error messages.
     *
     * @param string $message
     * @param string $status
     * @param BufferedOutput $outputLog
     * @return array
     */
    private function response($message, $status, BufferedOutput $outputLog)
    {
        return [
            'status' => $status,
            'message' => $message,
            'dbOutputLog' => $outputLog->fetch(),
        ];
    }

    /**
     * Run the migration and call the seeder.
     *
     * @return array
     */
    public function rollback()
    {
        $outputLog = new BufferedOutput;

        try {
            Artisan::call('migrate:rollback', ['--force' => true], $outputLog);
        } catch (Exception $e) {
            return $this->response($e->getMessage(), 'error', $outputLog);
        }

        return $this->response(__('Database migration rollback has been completed successfully.'), 'success', $outputLog);
    }

    /**
     * Seed the database.
     * @return array
     */
    public function seed()
    {
        try {
            $outputLog = new BufferedOutput;
            Artisan::call('db:seed', ['--force' => true], $outputLog);
        } catch (Exception $e) {
            return $this->response($e->getMessage(), 'error', $outputLog);
        }

        return $this->response(__('Database seeding has been completed successfully.'), 'success', $outputLog);
    }

    /**
     * Seed the database.
     * @return array
     */
    public function testSeed()
    {
        try {
            $outputLog = new BufferedOutput;
            Artisan::call('db:seed', ['--class' => 'TestSeeder', '--force' => true], $outputLog);
        } catch (Exception $e) {
            return $this->response($e->getMessage(), 'error', $outputLog);
        }

        return $this->response(__('Database has been seeded successfully.'), 'success', $outputLog);
    }


}
