<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $paymentMethods = [
            ['name' => 'Cash', 'type' => 'cash'],
            ['name' => 'BCA', 'type' => 'bank', 'account_number' => '1234567890', 'account_name' => 'Restaurant ABC'],
            ['name' => 'Mandiri', 'type' => 'bank', 'account_number' => '0987654321', 'account_name' => 'Restaurant ABC'],
            ['name' => 'QRIS', 'type' => 'digital'],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create($method);
        }
    }
}
