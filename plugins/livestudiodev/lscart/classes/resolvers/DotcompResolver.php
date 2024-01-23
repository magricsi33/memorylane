<?php

namespace LivestudioDev\Lscart\Classes\Resolvers;

use Winter\Storm\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use LivestudioDev\Lscart\Models\Product;

class DotcompResolver implements BaseResolver
{
    private $url = 'https://dotcomp.hu/files/arlista/dotcomp-b6h4A@d0tc03p.stock.xml';
    private $folder = 'dotcomp';
    private $debug = true;

    private function getUrl() {
        return $this->url;
    }

    public function __construct()
    {
        if (!Storage::disk('local')->exists($this->folder)) {
            Storage::disk('local')->makeDirectory($this->folder);
        }
    }

    private function download()
    {
        $response = Http::get($this->getUrl());
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

        $data = Storage::disk('local')->get($this->folder . '/feed.xml');
        $data = iconv('UTF-8', 'UTF-8//IGNORE', $data);

        return $data;

    }

    private function parseProduct($product): ?ProductDTO {

        if ($product['szallitasi_ido'] == 0 && $product['keszleten'] == 0 && $product['keszletszam'] == 0) {
            return null;
        }

        $images = isset($product['termekkep']) ? collect($product['termekkep']) : collect([]);

        $p = new ProductDTO();
        $p->name = is_array($product['termek_nev']) ? null : $product['termek_nev'];
        $p->description = is_array($product['termekleiras']) ? '' : $product['termekleiras'];
        $p->category = is_array($product['termekkategoria']) ? null : $product['termekkategoria'];
        $p->sku = is_array($product['arukod']) ? null : $product['arukod'];
        $p->price = is_array($product['netto_ar']) ? null : $product['netto_ar'];
        $p->stock = is_array($product['keszletszam']) ? 0 : $product['keszletszam'];
        $p->image = $images->first();
        $p->gallery = $images->toArray();
        $p->partner = 'Dotcomp';
        $p->guarantee = $product['garancia'] ?? '';
        $p->b_sku = $product['gyari_cikkszam'] ?? '';
        $p->transport = $product['szallitasi_ido'] ? Carbon::now()->addDay($product['szallitasi_ido'])->format('Y-m-d') : 0;

        $p->type = null;
        
        $properties = [];

        // if (isset($product['leiras']) && !empty($product['leiras'])) {
        //     $descriptionText = $product['leiras'];
       
        //     // A sorok szétválasztása
        //     $lines = explode("\n", $descriptionText);
        
        //     // A sorok feldolgozása
        //     foreach ($lines as $line) {
        //         // Az első kettőspont pozíciójának meghatározása
        //         $colonPosition = strpos($line, ':');
        
        //         // Ha van kettőspont a sorban
        //         if ($colonPosition !== false) {
        //             $property = trim(substr($line, 0, $colonPosition));
        //             $value = trim(substr($line, $colonPosition + 1));
        //             $properties[$property] = $value;
        //         }
        //     }
        // }

        $p->properties = $properties;
        if (!$p->name || !$p->category || !$p->price) {
            return null;
        }
        
        return $p;
    }

    public function retrieve(): array
    {
       
        $data = $this->getData();

        $xmlData = simplexml_load_string($data, "SimpleXMLElement", LIBXML_NOCDATA);
        
        $json = json_encode($xmlData);

        $array = json_decode($json, TRUE);

        $products = [];
        foreach ($array['termek'] as $key => $product) {

            $p = $this->parseProduct($product);

            if ($p == null) {
                continue;
            }
            
            $products[] = $p;
     
            //$products[] = $p;

            //$find_product = Product::where('b_sku', $p->b_sku)->first();
            //dd($find_product);

        }

        return $products;
    }
}
