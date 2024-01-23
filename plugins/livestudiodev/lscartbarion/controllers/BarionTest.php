<?php namespace LivestudioDev\Lscartbarion\Controllers;

use Backend\Classes\Controller;
use LivestudioDev\Lscartbarion\Classes\BarionDriver;
use LivestudioDev\Lscart\Models\Order;

class BarionTest extends Controller
{
    public function index()
    {
        $order = Order::first();
        $driver = new BarionDriver();
        $url = $driver->getPayUrl($order);

        $this->vars['url'] = $url;
    }
}