<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'app/SQL/permissions.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Permisos table seeded!');
    }
}
