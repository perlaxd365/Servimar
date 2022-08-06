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

       
       // PERMISOS PARA PRODUCTOS
       Permission::create(['name'=>'admin.products.index'])->syncRoles($role1);
       Permission::create(['name'=>'admin.products.create'])->syncRoles($role1);
       Permission::create(['name'=>'admin.products.update'])->syncRoles($role1);
       Permission::create(['name'=>'admin.products.delete'])->syncRoles($role1);


       
       // PERMISOS PARA CLIENTE
       Permission::create(['name'=>'admin.clientes.index'])->syncRoles($role1,$role2);
       Permission::create(['name'=>'admin.clientes.create'])->syncRoles($role1,$role2);
       Permission::create(['name'=>'admin.clientes.update'])->syncRoles($role1,$role2);
       Permission::create(['name'=>'admin.clientes.delete'])->syncRoles($role1,$role2);

       
       // PERMISOS PARA VENTAS
       Permission::create(['name'=>'admin.ventas.index'])->syncRoles($role1,$role2);
       Permission::create(['name'=>'admin.ventas.create'])->syncRoles($role1,$role2);
       Permission::create(['name'=>'admin.ventas.update'])->syncRoles($role1,$role2);
       Permission::create(['name'=>'admin.ventas.delete'])->syncRoles($role1,$role2);
       
       // PERMISOS PARA CREDITOS
       Permission::create(['name'=>'admin.creditos.index'])->syncRoles($role1);
       Permission::create(['name'=>'admin.creditos.create'])->syncRoles($role1);
       Permission::create(['name'=>'admin.creditos.update'])->syncRoles($role1);
       Permission::create(['name'=>'admin.creditos.delete'])->syncRoles($role1);
        
    }
}
