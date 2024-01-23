<?php namespace LivestudioDev\Lscartbarion\Classes;

use LivestudioDev\Lscartbarion\Models\Settings;
require_once 'library/BarionClient.php';

class BarionDriver
{
    protected $barion;
    protected $settings;

	public function __construct()
	{
        $this->settings = Settings::instance();
        $posKey = $this->settings->pos_key;
        $apiVersion = 2;
        $environment = $this->settings->environment == 1 ? \BarionEnvironment::Prod : \BarionEnvironment::Test;

        $this->barion = new \BarionClient($posKey,$apiVersion,$environment);        
    }

    public static function getGates()
	{
		return ["Barion" => "Barion"];
	}

    public function convertOrderToTransaction($order)
    {
        $trans = new \PaymentTransactionModel();
        $trans->POSTransactionId = "TRANS-".$order->order_number;
        $trans->Payee = $this->settings->payee;
        $trans->Total = $order->getAbsolutePrice();
        $trans->Currency = \Currency::HUF;
        $trans->Comment = "Rendelés azonosító: ".$order->order_number;
        
        foreach($order->items as $item){
            $bitem = new \ItemModel();
            $bitem->Name = $item->product->name;
            $bitem->Description = $item->product->name;
            $bitem->Quantity = $item->quantity;
            $bitem->Unit = $item->product->unit ? $item->product->unit->name : "db";
            $bitem->UnitPrice = intval($item->product->price_brutto);
            $bitem->ItemTotal = $item->itemPrice;
            $bitem->SKU = "ITEM-".$item->product->id;
            $trans->AddItem($bitem);
        }

        if($order->getShippingCost() > 0){
            $shipping = $order->shipping;

            $sitem = new \ItemModel();
            $sitem->Name = $shipping->name;
            $sitem->Description = "Szállítási költség";
            $sitem->Quantity = 1;
            $sitem->Unit = "db";
            $sitem->UnitPrice = intval($order->getShippingCost());
            $sitem->ItemTotal = intval($order->getShippingCost());
            $sitem->SKU = "ITEM-".$item->product->id;
            $trans->AddItem($sitem);
        }
        
        return $trans;
    }

    public function getPaymentRequest($trans,$order)
    {
        $ppr = new \PreparePaymentRequestModel();
        $ppr->GuestCheckout = true;
        $ppr->PaymentType = \PaymentType::Immediate;
        $ppr->FundingSources = array(\FundingSourceType::All);
        $ppr->PaymentRequestId = $order->order_number;
        $ppr->PayerHint = $order->email;
        $ppr->Locale = \UILocale::HU;
        $ppr->OrderNumber = $order->order_number;
        $ppr->Currency = \Currency::HUF;
        $ppr->RedirectUrl = \URL::to("barion/afterpayment/{$order->order_number}");
        $ppr->CallbackUrl = \URL::to("barion/processpayment");
        $ppr->AddTransaction($trans);

        return $ppr;
    }

    public function preparePayment($ppr)
    {
        $response = $this->barion->PreparePayment($ppr);
        
        return $response;
    }

    public function getPaymentState($id)
    {
        return $this->barion->GetPaymentState($id);
    }

    public function getPayUrl($order)
    {        
        $trans = $this->convertOrderToTransaction($order);
        $ppr = $this->getPaymentRequest($trans,$order);
        return $this->preparePayment($ppr)->PaymentRedirectUrl;
    }
}