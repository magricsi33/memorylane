<?php namespace Codergram\Ecommpay\Classes;

//require('vendor/autoload.php');
//require __DIR__.'../../../../vendor/autoload.php';

use Exception;

class EcommpayDriver
{
    // 107332
    // 331c82a9f015bc7eaa1c2b67bd2393bbce5c8b3bff1774fd301336d060b1af0b8bb72ee14c1eecc117ec0d77d21bc896ae06585c86e07e5a98dc1d785e44f25c

    protected $gate;

    protected $payment;

    protected $url;

	public function __construct()
	{
		$this->gate = new \ecommpay\Gate('331c82a9f015bc7eaa1c2b67bd2393bbce5c8b3bff1774fd301336d060b1af0b8bb72ee14c1eecc117ec0d77d21bc896ae06585c86e07e5a98dc1d785e44f25c');
	}

    public static function getGates()
	{
		return ["Ecommpay" => "Ecommpay"];
	}

	public function startPayment($order)
	{
        $gate = new \ecommpay\Gate('331c82a9f015bc7eaa1c2b67bd2393bbce5c8b3bff1774fd301336d060b1af0b8bb72ee14c1eecc117ec0d77d21bc896ae06585c86e07e5a98dc1d785e44f25c');

        $payment = new \ecommpay\Payment('107332', $order->id);
        $payment->setPaymentAmount($order->getAbsolutePrice() * 100)->setPaymentCurrency('HUF');
        $payment->setPaymentDescription($order->order_number);

        $payment->setMerchantSuccessUrl(\Url::to('koszonjuk/'.$order->id.'?state=success'));
        $payment->setMerchantFailUrl(\Url::to('koszonjuk/'.$order->id.'?state=fail'));

        $payment->setLanguageCode('hu');
        
        $url = $gate->getPurchasePaymentPageUrl($payment);

        return $url;

	}

    public function getPayUrl($order)
    {        
        $payment = $this->startPayment($order);

        return $payment;
    }
	
}
