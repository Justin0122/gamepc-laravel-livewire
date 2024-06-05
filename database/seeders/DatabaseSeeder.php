<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Brand;
use App\Models\FormFactor;
use App\Models\Generation;
use App\Models\MemoryType;
use App\Models\MyPc;
use App\Models\Parts\Case_cooler;
use App\Models\Parts\Cpu;
use App\Models\Parts\Cpu_cooler;
use App\Models\Parts\Gpu;
use App\Models\Parts\Motherboard;
use App\Models\Parts\Pc_case;
use App\Models\Parts\Psu;
use App\Models\Parts\Ram;
use App\Models\Parts\Storage;
use App\Models\Socket;
use App\Models\Team;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Laravel\Jetstream\Events\TeamMemberAdded;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Database\Seeders\InsertData;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        InsertData::brands();
        InsertData::sockets();
        InsertData::generations();
        InsertData::memoryTypes();
        InsertData::formFactors();


        Cpu::factory(300)->create();
        Gpu::factory(30)->create();
        Motherboard::factory(30)->create();
        Case_Cooler::factory(30)->create();
        Pc_case::factory(30)->create();
        Psu::factory(30)->create();
        Storage::factory(30)->create();
        Cpu_cooler::factory(30)->create();
        Ram::factory(30)->create();

//        MyPc::factory(30)->create();
//        Transaction::factory(30)->create();



        Case_Cooler::factory(30)->create();

        Permission::create(['name' => 'edit products']);
        Permission::create(['name' => 'add products']);
        Permission::create(['name' => 'delete products']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'edit permissions']);
        Permission::create(['name' => 'see orders']);
        Permission::create(['name' => 'edit orders']);
        Permission::create(['name' => 'see customers']);
        Permission::create(['name' => 'see products']);
        Permission::create(['name' => 'see own orders']);
        Permission::create(['name' => 'build pc']);

        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo('edit products');
        $manager->givePermissionTo('see orders');
        $manager->givePermissionTo('edit orders');
        $manager->givePermissionTo('see customers');
        $manager->givePermissionTo('see products');
        $manager->givePermissionTo('edit permissions');
        $manager->givePermissionTo('edit roles');

        $inventoryManager = Role::create(['name' => 'inventory']);
        $inventoryManager->givePermissionTo('edit products');
        $inventoryManager->givePermissionTo('see orders');
        $inventoryManager->givePermissionTo('see products');
        $inventoryManager->givePermissionTo('delete products');
        $inventoryManager->givePermissionTo('add products');

        $salesManager = Role::create(['name' => 'sales']);
        $salesManager->givePermissionTo('see orders');
        $salesManager->givePermissionTo('see customers');

        $customer = Role::create(['name' => 'customer']);
        $customer->givePermissionTo('see products');
        $customer->givePermissionTo('see own orders');
        $customer->givePermissionTo('build pc');

        $team = ['manager', 'inventory', 'sales', 'customer'];
        foreach($team as $admin){
            $user = User::create([
                    'name' => $admin,
                    'last_name' => 'Employee',
                    'username' => $admin,
                    'email' => str_replace(" ", "", $admin) . '@localhost',
                    'password' => bcrypt('password'),
                    'city' => 'Amsterdam',
                    'street' => 'straat',
                    'house_number' => '1',
                    'postcode' => '1234AB',
                ]
            );
            $user->assignRole($admin);
        }

        $customerRole = Role::where('name', 'customer')->first();

        User::factory(10)->create()->each(function ($user) use ($customerRole) {
            $user->assignRole($customerRole);
        });
    }
}
