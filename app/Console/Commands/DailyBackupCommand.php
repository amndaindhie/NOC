<?php

namespace App\Console\Commands;

use App\Models\Backup;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DailyBackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create daily database backup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $databaseName = config('database.connections.mysql.database');
            $backupFileName = $databaseName . '_' . date('Y-m-d_H-i-s') . '.sql';
            $backupPath = 'backups/' . $backupFileName;
            
            // Create backups directory if it doesn't exist
            if (!Storage::exists('backups')) {
                Storage::makeDirectory('backups');
            }

            // Update the backup path to storage
            $backupPath = 'backups/' . $backupFileName;
            $fullBackupPath = storage_path('app/' . $backupPath);
            
            // Execute mysqldump command with proper path
            $command = sprintf(
                '"C:\xampp\mysql\bin\mysqldump.exe" --user=%s --password=%s --host=%s %s > "%s"',
                config('database.connections.mysql.username'),
                config('database.connections.mysql.password'),
                config('database.connections.mysql.host'),
                $databaseName,
                $fullBackupPath
            );
            
            // Use exec instead of shell_exec for better Windows compatibility
            // Capture both stdout and stderr
            exec($command . ' 2>&1', $output, $returnVar);
            
            if ($returnVar !== 0) {
                Log::error('Daily backup failed with return code: ' . $returnVar, ['output' => $output]);
                $this->error('Backup gagal. Pastikan mysqldump tersedia dan konfigurasi database benar.');
                $this->error('Error output: ' . $output);
                return 1;
            }

            // Store backup info in the database
            $fileSize = filesize($fullBackupPath);
            
            Backup::create([
                'file_name' => $backupFileName,
                'file_size' => $this->formatFileSize($fileSize),
            ]);

            Log::info('Daily backup created successfully: ' . $backupFileName);
            $this->info('Backup harian berhasil dibuat: ' . $backupFileName);
            
            return 0;
            
        } catch (\Exception $e) {
            Log::error('Daily backup error: ' . $e->getMessage());
            $this->error('Terjadi kesalahan saat membuat backup harian: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Format file size to human readable format
     */
    private function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
