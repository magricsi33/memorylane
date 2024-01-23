<?php namespace LivestudioDev\Lscart\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use RainLab\User\Models\User;
use LivestudioDev\Lscart\Models\Product;
use LivestudioDev\Lscart\Models\Category;
use LivestudioDev\Lscart\Models\Order;
use LivestudioDev\Lscart\Models\OrderItem;
use LivestudioDev\Lscart\Models\Settings;
use Carbon\Carbon;

class Sales extends ReportWidgetBase
{
    public function render()
    {		
		// $this->addCss("/plugins/livestudiodev/lscart/assets/css/productWidget.css","1.0.0");
		$this->addCss("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css", "5.12.1");
		
		$dailyorders = Order::whereDate('created_at',Carbon::today()->format("Y-m-d"))->get();
		$count1 = count($dailyorders);
		$accum1 = 0;
		foreach ($dailyorders as $order) {
			$accum1 += $order->getAbsolutePrice();
		}
		$today = new \stdClass();
		$today->count = $count1;
		$today->accum = $accum1;
		$this->vars["today"] = $today;

		$monthlyorders = Order::whereBetween('created_at',[Carbon::today()->startOfMonth()->format("Y-m-d"),Carbon::today()->endOfMonth()->format("Y-m-d")])->get();
		$count2 = count($monthlyorders);
		$accum2 = 0;
		foreach ($monthlyorders as $order) {
			$accum2 += $order->getAbsolutePrice();
		}
		$month = new \stdClass();
		$month->count = $count2;
		$month->accum = $accum2;
		$this->vars["month"] = $month;

		$this->vars["default"] = Settings::instance();
		
        return $this->makePartial('widget');
	}

	public function defineProperties()
	{
		// return [
		// 	'title' => [
		// 		'title'             => 'Widget title',
		// 		'default'           => 'Top Pages',
		// 		'type'              => 'string',
		// 		'validationPattern' => '^.+$',
		// 		'validationMessage' => 'The Widget Title is required.'
		// 	],
		// ];
		return [];
	}
}