<?php

use App\Order;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = [
            [
                'id'=>'1',
                'product_id'=>'1',
                'user_id'=>'1',
                'quantity'=>'2',
                'address'=>'User@mail.com',
                'is_delivered'=>false,
                'currency'=>'USD'

            ],
            [
                'id'=>'2',
                'product_id'=>'2',
                'user_id'=>'1',
                'quantity'=>'4',
                'address'=>'User@mail.com',
                'is_delivered'=>true,
                'currency'=>'USD'

            ],
            [
                'id'=>'3',
                'product_id'=>'3',
                'user_id'=>'2',
                'quantity'=>'5',
                'address'=>'User@mail.com',
                'is_delivered'=>false,
                'currency'=>'USD'

            ],
            [
                'id'=>'4',
                'product_id'=>'4',
                'user_id'=>'2',
                'quantity'=>'22',
                'address'=>'User@mail.com',
                'is_delivered'=>true,
                'currency'=>'USD'

            ],
            ];

        foreach ($orders as $order) {
            Order::create($order);
        }
    }
}
