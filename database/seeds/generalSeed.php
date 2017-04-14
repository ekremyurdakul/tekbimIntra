<?php

use Illuminate\Database\Seeder;

class generalSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Module::create(['name'=>'Personel',
                             'link'=>'/employee']);
        \App\Module::create(['name'=>'Teknik Servis',
            'link'=>'/']);
        \App\Module::create(['name'=>'HPE Data Servisleri',
            'link'=>'/hpe']);
        \App\Module::create(['name'=>'Stok',
            'link'=>'/stock']);
        \App\Module::create(['name'=>'Piyasa',
            'link'=>'/market']);
    }
}
