<?php namespace LivestudioDev\Lscart\Models;

use LivestudioDev\Lscart\Models\Product;

class ProductExport extends \Backend\Models\ExportModel
{
    public function exportData($columns, $sessionKey = null)
    {
        $products = Product::all();
        $products->each(function($product) use ($columns) {
            $product->addVisible($columns);
        });
        return $products->toArray();
    }
}