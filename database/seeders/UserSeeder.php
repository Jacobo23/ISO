<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(['name' => 'Daniel.Lopez','email' => 'dlopez@grupoaduanalecex.com','password' => '$2y$10$Pf05.rmwei/neBzcCn/.SueO5MZ3FJzqXtf/ZJmxlTx20Ni3rPv2q','perfil' => 'JEFE','tipo' => 'Administrador','activo' => 1]);
        DB::table('users')->insert(['name' => 'Juan.Jacobo','email' => 'jc_jacobo@outlook.com','password' => '$2y$10$Pf05.rmwei/neBzcCn/.SueO5MZ3FJzqXtf/ZJmxlTx20Ni3rPv2q','perfil' => 'Empleado general','tipo' => 'Administrador','activo' => 1]);
        DB::table('users')->insert(['name' => 'David.Lopez','email' => 'david@grupoaduanalecex.com','password' => '$2y$10$Pf05.rmwei/neBzcCn/.SueO5MZ3FJzqXtf/ZJmxlTx20Ni3rPv2q','perfil' => 'Supervisor','tipo' => 'Administrador','activo' => 0]);
        DB::table('users')->insert(['name' => 'Emily.Mendivil','email' => 'emily@grupoaduanalecex.com','password' => '$2y$10$Pf05.rmwei/neBzcCn/.SueO5MZ3FJzqXtf/ZJmxlTx20Ni3rPv2q','perfil' => 'Supervisor','tipo' => 'Responsable','activo' => 1]);
        DB::table('users')->insert(['name' => 'Alondra.Soto','email' => 'alondra_soto@grupoaduanalecex.com','password' => '$2y$10$Pf05.rmwei/neBzcCn/.SueO5MZ3FJzqXtf/ZJmxlTx20Ni3rPv2q','perfil' => 'Empleado general','tipo' => 'Regular','activo' => 1]);
        DB::table('users')->insert(['name' => 'Manuel.Guitierrez','email' => 'manuel@grupoaduanalecex.com','password' => '$2y$10$Pf05.rmwei/neBzcCn/.SueO5MZ3FJzqXtf/ZJmxlTx20Ni3rPv2q','perfil' => 'Empleado general','tipo' => 'Regular','activo' => 1]);
    }
}
