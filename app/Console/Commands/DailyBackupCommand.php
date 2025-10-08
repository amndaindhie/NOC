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

            // Create backups directory if it doesn't exist
            if (!Storage::exists('backups')) {
                Storage::makeDirectory('backups');
            }

            // Use relative path from storage/app to avoid command line length issues
            $relativeBackupPath = 'backups/' . $backupFileName;
            $fullBackupPath = storage_path('app/' . $relativeBackupPath);

            // Get mysqldump path from config or env, fallback to default
            $mysqldumpPath = config('backup.mysqldump_path', env('MYSQLDUMP_PATH', 'mysqldump'));

            // Change to storage/app directory to use shorter relative paths
            $originalDir = getcwd();
            chdir(storage_path('app'));

            // Build command with mysqldump flags to remove headers/comments
            $command = sprintf(
                '%s --skip-comments --no-create-info --compact --user=%s --password=%s --host=%s %s > %s',
                escapeshellarg($mysqldumpPath),
                escapeshellarg(config('database.connections.mysql.username')),
                escapeshellarg(config('database.connections.mysql.password')),
                escapeshellarg(config('database.connections.mysql.host')),
                escapeshellarg($databaseName),
                escapeshellarg($relativeBackupPath)
            );

            Log::info('Executing backup command: ' . $command);

            exec($command . ' 2>&1', $output, $returnVar);

            // Change back to original directory
            chdir($originalDir);

            if ($returnVar !== 0) {
                $errorOutput = implode("\n", $output);
                Log::error('Daily backup failed with return code: ' . $returnVar . '. Output: ' . $errorOutput);
                $this->error('Backup gagal. Pastikan mysqldump tersedia dan konfigurasi database benar.');
                $this->error('Error output: ' . $errorOutput);
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
