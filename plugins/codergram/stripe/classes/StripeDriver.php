<?php namespace Codergram\Stripe\Classes;

use Codergram\Stripe\Models\Settings;

//require('vendor/autoload.php');
//require __DIR__.'../../../../vendor/autoload.php';

use Exception;

class StripeDriver
{
    // pk_test_51MYaGVITGGvomerHCncBwFsKiLnjhCT0mYSu68NbvTmEzsysfpj69Lg9eQ1LOqnFc06zYIlFE8P3UMOf11XMtR5a00LmwF9vmh
    // sk_test_51MYaGVITGGvomerHGjkbWZ26BOpOAB0fHcNH7XTsywQvOnOvm2H3JicZOQMO9rmih3Ya3lCfGSgyqg020r2t18qk00lT6bqhO4

    protected $stripe;

	public function __construct()
	{
        $this->settings = Settings::instance();
		$this->stripe = new \Stripe\StripeClient($this->settings->private_key);
	}

    public static function getGates()
	{
		return ["Stripe" => "Stripe"];
	}

	public function startPayment($order)
	{

        $stripe = new \Stripe\StripeClient($this->settings->private_key);

        $payment = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => "HUF",
                    'product_data' => [
                        'name' => $order->order_number
                    ],
                    'unit_amount' => (int) $order->getAbsolutePrice() * 100,
                ],
                'quantity' => 1,
            ]],
            'cancel_url' => \Url::to('/stripe/processpayment/'.$order->id.'?state=cancel'),
            'success_url' => \Url::to('/stripe/processpayment/'.$order->id.'?state=success'),
          ]);
    

        return $payment->url;

	}

    public function getPayUrl($order)
    {        
        $paymentUrl = $this->startPayment($order);

        return $paymentUrl;
    }
	
}
