<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Buat permission panel penjual
        $accessPanelPenjual = Permission::firstOrCreate(['name' => 'access_panel_penjual']);
        $accessPanelAdmin   = Permission::firstOrCreate(['name' => 'access_panel_admin']);

        // Buat role penjual
        $penjual = Role::firstOrCreate(['name' => 'penjual']);
        $penjual->givePermissionTo($accessPanelPenjual);

        // Buat role admin
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo($accessPanelAdmin);

        // Tambahkan permission tambahan sesuai kebutuhan (misal access_resource_*)
        // atau generate otomatis:
        // \BezhanSalleh\FilamentShield\Support\Utils::generateForAll();
    }
}
