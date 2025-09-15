<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions by category
        $this->createUserPermissions();
        $this->createQuotePermissions();
        $this->createBookingPermissions();
        $this->createCustomerPermissions();
        $this->createSystemPermissions();
        $this->createEmailPermissions();
        $this->createTaskPermissions();

        // Create roles and assign permissions
        $this->createAdminRole();
        $this->createUserRole();

        $this->command->info('Roles and permissions created successfully!');
    }

    /**
     * Create user management permissions
     */
    private function createUserPermissions(): void
    {
        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
            'manage users',
            'assign roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }

    /**
     * Create quote management permissions
     */
    private function createQuotePermissions(): void
    {
        $permissions = [
            'view quotes',
            'create quotes',
            'edit quotes',
            'delete quotes',
            'approve quotes',
            'view all quotes',
            'view own quotes',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }

    /**
     * Create booking management permissions
     */
    private function createBookingPermissions(): void
    {
        $permissions = [
            'view bookings',
            'create bookings',
            'edit bookings',
            'delete bookings',
            'view all bookings',
            'view own bookings',
            'manage booking status',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }

    /**
     * Create provider management permissions
     */
    private function createProviderPermissions(): void
    {
        // Removed - not needed for admin/user only roles
    }

    /**
     * Create customer management permissions
     */
    private function createCustomerPermissions(): void
    {
        $permissions = [
            'view own customer data',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }

    /**
     * Create financial management permissions
     */
    private function createFinancialPermissions(): void
    {
        // Removed - not needed for admin/user only roles
    }

    /**
     * Create system management permissions
     */
    private function createSystemPermissions(): void
    {
        $permissions = [
            'view settings',
            'edit settings',
            'manage system',
            'view logs',
            'view activity',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }

    /**
     * Create email management permissions
     */
    private function createEmailPermissions(): void
    {
        $permissions = [
            'view email logs',
            'manage email logs',
            'send emails',
            'view email templates',
            'edit email templates',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }

    /**
     * Create task management permissions
     */
    private function createTaskPermissions(): void
    {
        $permissions = [
            'view tasks',
            'create tasks',
            'edit tasks',
            'delete tasks',
            'assign tasks',
            'complete tasks',
            'view all tasks',
            'view own tasks',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }

    /**
     * Create Admin role with all permissions
     */
    private function createAdminRole(): void
    {
        $role = Role::firstOrCreate(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
    }

    /**
     * Create Manager role with operational permissions
     */
    private function createManagerRole(): void
    {
        // Removed - not needed for admin/user only roles
    }

    /**
     * Create Accounts role with financial permissions
     */
    private function createAccountsRole(): void
    {
        // Removed - not needed for admin/user only roles
    }

    /**
     * Create Staff role with day-to-day operational permissions
     */
    private function createStaffRole(): void
    {
        // Removed - not needed for admin/user only roles
    }

    /**
     * Create Provider role with limited access
     */
    private function createProviderRole(): void
    {
        // Removed - not needed for admin/user only roles
    }

    /**
     * Create Customer role with limited access
     */
    private function createCustomerRole(): void
    {
        // Removed - not needed for admin/user only roles
    }

    /**
     * Create User role with standard permissions
     */
    private function createUserRole(): void
    {
        $role = Role::firstOrCreate(['name' => 'user']);
        
        $permissions = [
            // User permissions
            'view users', 'edit users',
            
            // Quote permissions
            'view quotes', 'create quotes', 'view own quotes',
            
            // Booking permissions
            'view bookings', 'create bookings', 'view own bookings',
            
            // Task permissions
            'view tasks', 'create tasks', 'edit tasks', 'complete tasks', 'view own tasks',
            
            // Email permissions
            'view email logs', 'send emails',
            
            // System permissions
            'view activity',
            
            // Customer permissions
            'view own customer data', // Adding the missing permission
        ];
        
        $role->givePermissionTo($permissions);
    }
}
