<?php

namespace App\PaymentServices;

// use Illuminate\Http\Request;
class NewPayPal{
    protected $transaction_id;

    public function __construct($transaction_id)
    {
        $this->transaction_id = $transaction_id;
    }
    public function pay()
    {

     return [ 
        'amount'=>200,
        'transaction'=>$this->transaction_id
     ];

    }


}