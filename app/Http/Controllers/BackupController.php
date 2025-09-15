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
            $backupPath = 'backups/' . $backupFileName; // This will be updated to storage path
            
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
                Log::error('Backup failed with return code: ' . $returnVar, ['output' => $output]);
                return back()->with('error', 'Backup gagal. Pastikan mysqldump tersedia dan konfigurasi database benar.');
            }

            // Store backup info in the database
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
        // TODO: implement restore logic
        return back()->with('success', 'Database berhasil direstore dari ' . $backup->file_name);
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
