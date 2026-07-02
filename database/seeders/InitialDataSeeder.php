<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlPath = base_path('aciaa3820_db.sql');
        
        if (!File::exists($sqlPath)) {
            $this->command->warn("SQL file aciaa3820_db.sql not found at {$sqlPath}.");
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $sqlContent = File::get($sqlPath);
        $lines = explode("\n", $sqlContent);
        
        $currentQuery = '';
        $isInserting = false;
        $tableName = '';

        foreach ($lines as $line) {
            if (str_starts_with($line, 'INSERT INTO')) {
                preg_match('/INSERT INTO `([^`]+)`/', $line, $matches);
                if (count($matches) < 2) {
                    continue;
                }
                
                $tableName = $matches[1];
                
                // Skip specific tables that don't need initial seeding
                $skipTables = [
                    'migrations', 'failed_jobs', 'jobs', 'job_batches', 
                    'sessions', 'activity_logs', 'cache', 'cache_locks',
                    'personal_access_tokens', 'password_reset_tokens'
                ];
                
                if (in_array($tableName, $skipTables)) {
                    $isInserting = false;
                    continue;
                }

                // Check if the table is empty before inserting
                try {
                    $count = DB::table($tableName)->count();
                    if ($count > 0) {
                        $this->command->info("Table `{$tableName}` is not empty. Skipping insert to avoid overwrite.");
                        $isInserting = false;
                        continue;
                    }
                } catch (\Exception $e) {
                    // Table might not exist yet if migrations haven't run completely
                    $this->command->warn("Table `{$tableName}` does not exist or error checking count.");
                    $isInserting = false;
                    continue;
                }

                $isInserting = true;
                $currentQuery = $line;
            } elseif ($isInserting) {
                $currentQuery .= "\n" . $line;
                // Check if the line ends with a semicolon (end of insert statement)
                if (str_ends_with(trim($line), ';')) {
                    try {
                        DB::unprepared($currentQuery);
                        $this->command->info("Successfully seeded table: {$tableName}");
                    } catch (\Exception $e) {
                        $this->command->error("Failed to seed table {$tableName}: " . $e->getMessage());
                    }
                    $isInserting = false;
                    $currentQuery = '';
                }
            }
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
