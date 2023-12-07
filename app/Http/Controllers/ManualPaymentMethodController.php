<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\DuitkuService;
use Illuminate\Http\Request;

class ManualPaymentMethodController extends Controller
{
    protected $duitku;

    public function __construct()
    {
        $this->duitku = new DuitkuService;
    }

    function show_payment_modal(Request $request)
    {
        $order = Order::find($request->order_id);

        if ($order->payment_type == 'duitku') {
            $data = $this->duitku->getPaymentMethod((int)$order->grand_total);
            if ($data['responseMessage'] == "SUCCESS") {
                $cart = false;
                return view('frontend.payment.duitku', compact('data', 'cart'));
            } else {
            }
        }
    }

    function duitkuInquiry(Request $request)
    {
        $order = Order::with([
            'orderDetails',
            'user:name,email,phone,id'
        ])->find($request->order_id);

        return $this->duitku->inquiry($order);
    }
}
