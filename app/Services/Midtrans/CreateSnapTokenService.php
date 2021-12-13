<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $order;

    public function __construct($order)
    {
        parent::__construct();

        $this->order = $order;
    }

    public function getSnapToken()
    {

        // dd(unserialize($this->order->order_items));

        $items_arr = [];

        foreach(unserialize($this->order->order_items) as $index => $c) {

            array_push($items_arr, [
                'id' => $index,
                'price' =>$c['total_price'],
                'quantity' => 1,
                'name' => 'Custom Hampers'
            ]);
        }

        $params = [
            'transaction_details' => [
                // 'order_id' => $this->order->number,
                'order_id' => $this->order->uuid,
                'gross_amount' => $this->order->total_price,
            ],
            'item_details' => $items_arr,
            'customer_details' => [
                'first_name' => $this->order->name,
                'email' => $this->order->email,
                'phone' => $this->order->phone,
            ]
        ];

        // dd($params);

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}
