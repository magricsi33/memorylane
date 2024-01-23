<?php

namespace LivestudioDev\Lscart\Classes\Resolvers;

use Winter\Storm\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MascoResolver implements BaseResolver
{
    private $url = 'https://masco.hu/api/?route=export/feed&id=shopalike';
    private $folder = 'masco';
    private $debug = true;

    public function __construct()
    {
        if (!Storage::disk('local')->exists($this->folder)) {
            Storage::disk('local')->makeDirectory($this->folder);
        }
    }

    private function download()
    {
        $response = Http::get($this->url);
        Storage::disk('local')->put($this->folder . '/feed.xml', $response->body);
    }

    private function getData(): string
    {
        if (Storage::exists($this->folder . '/feed.xml')) {
            if (!$this->debug) {
                $this->download();
            }
        } else {
            $this->download();
        }
        return Storage::disk('local')->get($this->folder . '/feed.xml');
    }

    private function parseProduct($product): ?ProductDTO
    {
        $image = is_array($product['image_url']) ? null : $product['image_url'];
        $p = new ProductDTO();
        if (is_array($product['name']) || is_array($product['category']) || is_array($product['sku'])) {
            // Név vagy kategória vagy sku név nélkül nem lehet termék
            return null;
        }

        $p->name = $product['name'];
        if (is_array($product['description'])) {
            $p->description = '';
        } else {
            $p->description = $product['description'];
        }
        $category_parts = explode('>', $product['category']);
        $p->category = trim(array_pop($category_parts));
        $p->sku = $product['sku'];
        if (is_array($product['price'])) {
            // Ezt kommenteld ki ha azt akarod létezzen a termék 0 forintos áron
            return null;
            $p->price = 0;
        } else {
            $p->price = $product['price'];
        }
        $p->price = $product['price'];
        $p->stock = 100; // Ricsi: "legyen száz és akkor mindig van raktáron"
        $p->image = $image;
        $p->gallery = [$image];

        return $p;
    }

    public function retrieve(): array
    {
        $data = $this->getData();

        $xmlData = simplexml_load_string($data, "SimpleXMLElement", LIBXML_NOCDATA);

        $json = json_encode($xmlData);

        $array = json_decode($json, TRUE);

        $products = [];
        foreach ($array['product'] as $key => $product) {
            $p = $this->parseProduct($product);
            if ($p == null) {
                continue;
            }
            $products[] = $p;
        }

        return $products;
    }
}
