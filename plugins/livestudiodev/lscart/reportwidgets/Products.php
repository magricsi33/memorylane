<?php namespace LivestudioDev\Lscart\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use RainLab\User\Models\User;
use LivestudioDev\Lscart\Models\Product;
use LivestudioDev\Lscart\Models\Category;
use LivestudioDev\Lscart\Models\Order;
use LivestudioDev\Lscart\Models\OrderItem;
use LivestudioDev\Lscart\Models\Settings;

class Products extends ReportWidgetBase
{
    public function render()
    {		
		$this->addCss("/plugins/livestudiodev/lscart/assets/css/productWidget.css","1.0.0");
		$this->addCss("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css", "5.12.1");
		$this->vars["products"] = Product::all();
		$this->vars["users"] = User::all();
		$this->vars["categories"] = Category::all();
		$this->vars["orderitems"] = OrderItem::all();
		$this->vars["orders"] = Order::all();

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