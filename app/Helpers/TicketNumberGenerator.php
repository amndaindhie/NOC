<?php

namespace App\Helpers;

use App\Models\NocInstallationRequest;
use App\Models\NocMaintenanceRequest;
use App\Models\NocComplaint;
use App\Models\NocTermination;

class TicketNumberGenerator
{
    public static function generate($prefix = 'TKT')
    {
        $randomString = self::generateRandomAlphanumeric(10);
        $year = date('y');
        $ticketNumber = $prefix . '-' . $randomString . $year;

        // Pastikan nomor tiket unik di semua tabel
        $isUnique = false;
        $maxAttempts = 100;
        $attempts = 0;

        while (!$isUnique && $attempts < $maxAttempts) {
            $exists = NocInstallationRequest::where('nomor_tiket', $ticketNumber)->exists() ||
                     NocMaintenanceRequest::where('nomor_tracking', $ticketNumber)->exists() ||
                     NocComplaint::where('nomor_tiket', $ticketNumber)->exists() ||
                     NocTermination::where('nomor_tiket', $ticketNumber)->exists();

            if (!$exists) {
                $isUnique = true;
            } else {
                $randomString = self::generateRandomAlphanumeric(10);
                $ticketNumber = $prefix . '-' . $randomString . $year;
                $attempts++;
            }
        }

        return $ticketNumber;
    }

    public static function generateForType($type)
    {
        $prefixes = [
            'instalasi' => 'INS',
            'maintenance' => 'MTN',
            'keluhan' => 'KEL',
            'terminasi' => 'TRM'
        ];

        $prefix = $prefixes[$type] ?? 'TKT';
        $randomString = self::generateRandomAlphanumeric(10);
        $year = date('y');
        $ticketNumber = $prefix . '-' . $randomString . $year;

        // Pastikan nomor tiket unik di semua tabel
        $isUnique = false;
        $maxAttempts = 100;
        $attempts = 0;

        while (!$isUnique && $attempts < $maxAttempts) {
            $exists = NocInstallationRequest::where('nomor_tiket', $ticketNumber)->exists() ||
                     NocMaintenanceRequest::where('nomor_tracking', $ticketNumber)->exists() ||
                     NocComplaint::where('nomor_tiket', $ticketNumber)->exists() ||
                     NocTermination::where('nomor_tiket', $ticketNumber)->exists();

            if (!$exists) {
                $isUnique = true;
            } else {
                $randomString = self::generateRandomAlphanumeric(10);
                $ticketNumber = $prefix . '-' . $randomString . $year;
                $attempts++;
            }
        }

        return $ticketNumber;
    }

    private static function generateRandomAlphanumeric($length)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}
