<?php namespace LivestudioDev\Lscart\Classes\Resolvers;

interface BaseResolver {
    public function retrieve() : array;
}

class ProductDTO {
    public $name;
    public $description;
    public $category;
    public $sku;
    public $price;
    public $stock;
    public $image;
    public $gallery;
    public $properties;
    public $partner;
    public $type;
    public $guarantee;
    public $transport;
    public $b_sku;
}