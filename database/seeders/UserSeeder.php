<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Crear el rol "admin" si no existe
        //$role = Role::firstOrCreate(['name' => 'admin']);

        // Crear el usuario
        $user = User::firstOrCreate(
            ['email' => 'admin@admin.com'], // Condición para buscar el usuario
            [
                'name' => 'Administrador',
                'password' => bcrypt('12345678'), // Asegúrate de usar bcrypt para encriptar la contraseña
            ]
        );

        // Asignar el rol al usuario
       //$user->assignRole($role);
    }
}
