<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $rolAdmin = Role::create(["name" => "admin"]);
       $rolOperations = Role::create(["name" => "operations"]);

       Permission::create(["name" => "getFlight"])->syncRoles([$rolAdmin]);
       Permission::create(["name" => "createFlight"])->syncRoles([$rolAdmin]);
       Permission::create(["name" => "updateFlight"])->syncRoles([$rolAdmin]);
       Permission::create(["name" => "deleteFlight"])->syncRoles([$rolAdmin]);
    }
}
