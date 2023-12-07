<?php

namespace App\Services;


class DuitkuService
{
    protected $merchantCode, $apiKey, $url;


    public function __construct()
    {
        $this->merchantCode = env('DUITKU_MERCHANT_ID');
        $this->apiKey = env("DUITKU_API_KEY");
        $this->url = env('DUITKU_URL');
    }

    function getPaymentMethod($paymentAmount)
    {

        // Set merchant key anda
        $apiKey = env("DUITKU_API_KEY");
        // catatan: environtment untuk sandbox dan passport berbeda

        $datetime = date('Y-m-d H:i:s');
        $signature = hash('sha256', $this->merchantCode . $paymentAmount . $datetime . $apiKey);

        $params = array(
            'merchantcode' => $this->merchantCode,
            'amount' => $paymentAmount,
            'datetime' => $datetime,
            'signature' => $signature
        );

        $params_string = json_encode($params);

        $url = $this->url . '/paymentmethod/getpaymentmethod';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($params_string)
            )
        );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        //execute post
        $request = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode == 200) {
            $results = json_decode($request, true);
            return $results;
        } else {
            $request = json_decode($request);
            $error_message = "Server Error " . $httpCode . " " . $request->Message;
            echo $error_message;
        }
    }

    public function inquiry($order)
    {
        $paymentAmount = (int)$order->grand_total;
        $paymentMethod = request()->payment_method; // VC = Credit Card
        $merchantOrderId = $order->id; // dari merchant, unik
        $productDetails = 'Tes pembayaran menggunakan Duitku';

        $address = [
            'firstName' => $order->user->name,
        ];

        $customerDetail = [
            'firstName' => $order->user->name,
            'email' => $order->user->email,
            'phoneNumber' => $order->user->phone,
            'billingAddress' => $address,
            'shippingAddress' => $address,
        ];

        $items = [];
        $feeShipping = 0;
        $totall = 0;
        foreach ($order->orderDetails as $key => $item) {
            $items[] = [
                'name' => $item->product->name,
                'price' => (int) $item->price,
                'quantity' => $item->quantity,
            ];

            $feeShipping += (int)$item->shipping_cost;

            $totall += $item->shipping_cost + ((int) $item->price * $item->quantity);
        }

        $shipping = [
            'name' => 'Shipping',
            'price' => (int) $feeShipping,
            'quantity' => 1,
        ];

        array_push($items, $shipping);

        $callbackUrl = 'http://example.com/callback'; // url untuk callback
        $returnUrl = 'http://example.com/return'; // url untuk redirect
        $expiryPeriod = 30; // atur waktu kadaluarsa dalam hitungan menit
        $signature = md5($this->merchantCode . $merchantOrderId . $paymentAmount . $this->apiKey);

        $params = array(
            'merchantCode' => $this->merchantCode,
            'paymentAmount' => $paymentAmount,
            'paymentMethod' => $paymentMethod,
            'merchantOrderId' => $merchantOrderId,
            'productDetails' => $productDetails,
            'customerVaName' => $order->user->name,
            'email' => $order->user->email,
            'phoneNumber' => $order->user->phoneNumber,
            //'accountLink' => $accountLink,
            //'creditCardDetail' => $creditCardDetail,
            'itemDetails' => $items,
            'customerDetail' => $customerDetail,
            'callbackUrl' => $callbackUrl,
            'returnUrl' => $returnUrl,
            'signature' => $signature,
            'expiryPeriod' => $expiryPeriod,
        );


        // return $params;
        $params_string = json_encode($params);
        //echo $params_string;
        $url = $this->url . '/v2/inquiry'; // Sandbox
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($params_string)
            )
        );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        //execute post
        $request = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode == 200) {
            $result = json_decode($request, true);

            return [
                'paymentUrl' => $result['paymentUrl'],
                'merchantCode' => $result['merchantCode'],
                'reference' => $result['reference'],
                'vaNumber' => $result['vaNumber'],
                'amount' => $result['amount'],
                'statusCode' => $result['statusCode'],
                'statusMessage' => $result['statusMessage'],
            ];
        } else {
            $request = json_decode($request);
            $error_message = "Server Error " . $httpCode . " " . $request->Message;
            echo $error_message;
        }
    }
}
