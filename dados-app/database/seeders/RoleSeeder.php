<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $admin = Role::create(['name'=>'admin']);
       $player = Role::create(['name'=>'player']);

       Permission::create(['name'=>'user.login'])->syncRoles([$admin,$player]);
       Permission::create(['name'=>'user.register'])->syncRoles([$admin,$player]);
       Permission::create(['name'=>'user.logout'])->syncRoles([$admin,$player]);

       Permission::create(['name'=>'user.update'])->assignRole($player);
       Permission::create(['name'=>'game.throwDice'])->assignRole($player);
       Permission::create(['name'=>'game.destroy'])->assignRole($player);
       Permission::create(['name'=>'game.index'])->assignRole($player);

       Permission::create(['name'=>'ranking.index'])->assignRole($admin);
       Permission::create(['name'=>'ranking.averageSuccessRate'])->assignRole($admin);
       Permission::create(['name'=>'ranking.worseSuccessRate'])->assignRole($admin);
       Permission::create(['name'=>'ranking.bestSuccessRate'])->assignRole($admin);










    }
}
