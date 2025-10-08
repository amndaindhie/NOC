<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BackupController extends Controller
{
    public function index()
    {
        $backups = Backup::latest()->get();
        return view('admin.backups.index', compact('backups'));
    }

    public function store(Request $request)
    {
        try {
            $databaseName = config('database.connections.mysql.database');
            $backupFileName = $databaseName . '_' . date('Y-m-d_H-i-s') . '.sql';
            $relativeBackupPath = 'backups/' . $backupFileName;

            // Create backups directory if it doesn't exist
            if (!Storage::exists('backups')) {
                Storage::makeDirectory('backups');
            }

            $fullBackupPath = storage_path('app/' . $relativeBackupPath);

            // Get mysqldump path from config or env, fallback to default
            $mysqldumpPath = config('backup.mysqldump_path', env('MYSQLDUMP_PATH', 'mysqldump'));

            // Change to storage/app directory to use shorter relative paths
            $originalDir = getcwd();
            chdir(storage_path('app'));

            // Build command with mysqldump flags to remove headers/comments and disable extended inserts
            $command = sprintf(
                '%s --skip-comments --skip-triggers --compact --skip-extended-insert --user=%s --password=%s --host=%s %s > %s',
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
                Log::error('Backup failed with return code: ' . $returnVar . '. Output: ' . implode("\n", $output));
                return back()->with('error', 'Backup gagal. Pastikan mysqldump tersedia dan konfigurasi database benar.');
            }

            $fileSize = filesize($fullBackupPath);

            Backup::create([
                'file_name' => $backupFileName,
                'file_size' => $this->formatFileSize($fileSize),
            ]);

            Log::info('Backup created successfully: ' . $backupFileName);
            return back()->with('success', 'Backup berhasil dibuat pada ' . now()->format('d M Y, H:i:s'));
        } catch (\Exception $e) {
            Log::error('Backup error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat membuat backup: ' . $e->getMessage());
        }
    }

    public function download($id)
    {
        try {
            $backup = Backup::findOrFail($id);
            $filePath = 'backups/' . $backup->file_name;

            if (!Storage::exists($filePath)) {
                return back()->with('error', 'File backup tidak ditemukan.');
            }

            return Storage::download($filePath);
        } catch (\Exception $e) {
            Log::error('Download backup error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengunduh backup.');
        }
    }

    public function restore($id)
    {
        $backup = Backup::findOrFail($id);
        $filePath = storage_path('app/backups/' . $backup->file_name);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File backup tidak ditemukan.');
        }

        try {
            // Get mysql path from config or env, fallback to default
            $mysqlPath = config('backup.mysql_path', env('MYSQL_PATH', 'mysql'));

            $databaseName = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');

            // Build restore command
            $command = sprintf(
                '%s --user=%s --password=%s --host=%s %s < %s',
                escapeshellarg($mysqlPath),
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($host),
                escapeshellarg($databaseName),
                escapeshellarg($filePath)
            );

            exec($command . ' 2>&1', $output, $returnVar);

            if ($returnVar !== 0) {
                Log::error('Restore failed with return code: ' . $returnVar . '. Output: ' . implode("\n", $output));
                return back()->with('error', 'Restore gagal. Pastikan mysql tersedia dan konfigurasi database benar.');
            }

            Log::info('Database restored successfully from: ' . $backup->file_name);
            return back()->with('success', 'Database berhasil direstore dari ' . $backup->file_name);
        } catch (\Exception $e) {
            Log::error('Restore error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat merestore database: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $backup = Backup::findOrFail($id);
            $filePath = 'backups/' . $backup->file_name;

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            $backup->delete();

            return back()->with('success', 'Backup berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Delete backup error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus backup.');
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
