<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\PaymentGateway;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Supervisor']);
        Role::firstOrCreate(['name' => 'Agent']);
        Role::firstOrCreate(['name' => 'Player']);
        PaymentGateway::firstOrCreate(['name' => 'Apple Pay']);
        PaymentGateway::firstOrCreate(['name' => 'Chime']);
        PaymentGateway::firstOrCreate(['name' => 'Stripe']);
        PaymentGateway::firstOrCreate(['name' => 'Cashapp']);
        PaymentGateway::firstOrCreate(['name' => 'Zelle']);
        PaymentGateway::firstOrCreate(['name' => 'PayPal']);
        PaymentGateway::firstOrCreate(['name' => 'Venmo']);
    }
}
