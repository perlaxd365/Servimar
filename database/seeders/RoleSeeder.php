<?php

namespace Database\Seeders;

use GuzzleHttp\Promise\Create;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
       $role1= Role::create(['name'=>'Admin']);
       $role2= Role::create(['name'=>'Operario']);

       // PERMISOS DE USUARIO
       Permission::create(['name'=>'admin.users.index'])->syncRoles($role1);
       Permission::create(['name'=>'admin.users.create'])->syncRoles($role1);
       Permission::create(['name'=>'admin.users.update'])->syncRoles($role1);
       Permission::create(['name'=>'admin.users.delete'])->syncRoles($role1);


       
       // PERMISOS PARA CLIENTE
       Permission::create(['name'=>'admin.clientes.index'])->syncRoles($role1,$role2);
        
    }
}
