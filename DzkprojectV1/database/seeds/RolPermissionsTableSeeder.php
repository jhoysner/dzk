<?php

use Illuminate\Database\Seeder;

class RolPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = 'app/SQL/rolespermissions.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Roles Permisos table seeded!');
    }
}
