<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class TenantNotificationService
{
    /**
     * Get tenant email by tenant number
     *
     * @param string $tenantNumber
     * @return string|null
     */
    public function getTenantEmail($tenantNumber)
    {
        try {
            // Find user by tenant number (assuming tenant number is stored in a field)
            // You may need to adjust this based on your database structure
            $tenant = User::where('name', 'like', "%{$tenantNumber}%")
                         ->orWhere('email', 'like', "%{$tenantNumber}%")
                         ->first();

            if ($tenant && $tenant->email) {
                return $tenant->email;
            }

            // If no user found, try to construct a default email
            // This is a fallback - you should adjust this based on your email naming convention
            $defaultEmail = "tenant{$tenantNumber}@example.com";
            
            Log::warning("Tenant email not found for number: {$tenantNumber}, using default: {$defaultEmail}");
            return $defaultEmail;

        } catch (\Exception $e) {
            Log::error("Error getting tenant email for {$tenantNumber}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get tenant emails for multiple tenant numbers
     *
     * @param array $tenantNumbers
     * @return array
     */
    public function getTenantEmails($tenantNumbers)
    {
        $emails = [];
        
        foreach ($tenantNumbers as $tenantNumber) {
            if ($email = $this->getTenantEmail($tenantNumber)) {
                $emails[] = $email;
            }
        }

        return array_unique($emails);
    }

    /**
     * Check if a tenant exists and is active
     *
     * @param string $tenantNumber
     * @return bool
     */
    public function isTenantActive($tenantNumber)
    {
        try {
            $tenant = User::where('name', 'like', "%{$tenantNumber}%")
                         ->orWhere('email', 'like', "%{$tenantNumber}%")
                         ->where('is_tenant', true)
                         ->first();

            return $tenant !== null;
        } catch (\Exception $e) {
            Log::error("Error checking tenant status for {$tenantNumber}: " . $e->getMessage());
            return false;
        }
    }
}
