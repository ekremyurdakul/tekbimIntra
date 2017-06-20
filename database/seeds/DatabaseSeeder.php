<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Module::create(['name'=>'Personel',
            'link'=>'employee']);
        \App\Module::create(['name'=>'Teknik Servis',
            'link'=>'service']);
        \App\Module::create(['name'=>'HPE Data Servisleri',
            'link'=>'hpe']);
        \App\Module::create(['name'=>'Stok',
            'link'=>'stock']);
        \App\Module::create(['name'=>'Piyasa',
            'link'=>'market']);

        \App\AuthorisationType::create(['name' => 'FullControl']);
        \App\AuthorisationType::create(['name' => 'ReadOnly']);

        \App\Customer::create(['name'=>'Arena Bilgisayar Ltd.',
            'email'=>'info@arenabilgisayar.com.tr']);

        \App\ServiceStatus::create(['name'=>'Bekleme']);
        \App\ServiceStatus::create(['name'=>'Tamir']);
        \App\ServiceStatus::create(['name'=>'TC']);
        \App\ServiceStatus::create(['name'=>'Bitti']);
        \App\ServiceStatus::create(['name'=>'Teslim Edildi']);

        \App\User::create([
            'name' => 'Ekrem',
            'surname' => 'Yurdakul',
            'email' => 'ekrem@yurdakul.net',
            'password' => bcrypt('123123'),
        ]);

        \App\Authorisation::create([
            'user_id' => 1,
            'module_id'=>1,
            'authorisation_type_id'=>1,
         ]);
        \App\Authorisation::create([
            'user_id' => 1,
            'module_id'=>2,
            'authorisation_type_id'=>1,
        ]);
        \App\Authorisation::create([
            'user_id' => 1,
            'module_id'=>3,
            'authorisation_type_id'=>1,
        ]);
        \App\Authorisation::create([
            'user_id' => 1,
            'module_id'=>4,
            'authorisation_type_id'=>1,
        ]);

        \App\Authorisation::create([
            'user_id' => 1,
            'module_id'=>5,
            'authorisation_type_id'=>1,
        ]);
        \App\OperationType::create([
            'name' => 'Format',
            'serialneed'=>false,
        ]);
        \App\OperationType::create([
            'name' => 'Sistem Kurtarma',
            'serialneed'=>false,
        ]);
        \App\OperationType::create([
            'name' => 'Yedek Alma',
            'serialneed'=>false,
        ]);
        \App\OperationType::create([
            'name' => 'Parça Değişimi',
            'serialneed'=>true,
        ]);
        \App\OperationType::create([
            'name' => 'Arıza Tespit',
            'serialneed'=>false,
        ]);
        \App\OperationType::create([
            'name' => 'Temizlik',
            'serialneed'=>false,
        ]);
        \App\OperationType::create([
            'name' => 'Veri Kurtarma',
            'serialneed'=>false,
        ]);
        \App\OperationType::create([
            'name' => 'Garanti Değişimi',
            'serialneed'=>true,
        ]);
        \App\OperationType::create([
            'name' => 'Diğer',
            'serialneed'=>true,
        ]);
    }
}
