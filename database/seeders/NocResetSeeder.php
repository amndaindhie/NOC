<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NocResetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Truncate all NOC tables
        DB::table('noc_installation_requests')->truncate();
        DB::table('noc_maintenance_requests')->truncate();
        DB::table('noc_complaints')->truncate();
        DB::table('noc_terminations')->truncate();
        DB::table('noc_tracking_status')->truncate();
        
        // Reset auto-increment
        DB::statement('ALTER TABLE noc_installation_requests AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE noc_maintenance_requests AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE noc_complaints AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE noc_terminations AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE noc_tracking_status AUTO_INCREMENT = 1');
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        $this->command->info('All NOC tables have been reset and IDs will start from 1.');
    }
}
