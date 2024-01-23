<?php

namespace LivestudioDev\Lscart\Classes\Resolvers;

use Winter\Storm\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CompMarketResolver implements BaseResolver
{
    private $url = 'https://compmarket.hu/xml/termeklista.php';
    private $folder = 'compmarket';
    private $debug = true;

    private function getUrl() {
        return $this->url.'?pid=6141&authcode=8CEAFC3A-0CEEF8A8-659F7957-E0DAA786';
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
        return Storage::disk('local')->get($this->folder . '/feed.xml');
    }

    private function parseProduct($product): ProductDTO {
        $images = isset($product['kepek']['kep']) ? 
            collect($product['kepek']['kep']) : 
            collect([]);

        $p = new ProductDTO();
        $p->name = is_array($product['nev']) ? null : $product['nev'];
        $p->description = is_array($product['leiras']) ? '' : $product['leiras'];
        $p->category = is_array($product['kategoria']) ? null : $product['kategoria'];
        $p->sku = is_array($product['cikkszam']) ? null : $product['cikkszam'];
        $p->price = is_array($product['ar']) ? null : $product['ar'];

        if (is_array($product['keszlet_kod'])) {
            if ($product['keszlet_kod'] == 0) {
                $p->stock = 0;
            } elseif ($product['keszlet_kod'] == 1) {
                $p->stock = 50;
            } elseif ($product['keszlet_kod'] == 2) {
                $p->stock = 1;
            }
        }
        
        $p->image = $images->first();
        $p->gallery = $images->toArray();
        $p->partner = 'Compmarket';
        $p->guarantee = $product['garido'] ?? '';
        $p->b_sku = $product['gy_cikkszam'] ?? '';
        $p->transport = $product['beerkezes'];

        $p->type = is_array($product['tipus']) ? null : $product['tipus'];
        
        $properties = [];

        if (isset($product['leiras']) && !empty($product['leiras'])) {
            $descriptionText = $product['leiras'];
       
            // A sorok szétválasztása
            $lines = explode("\n", $descriptionText);
        
            // A sorok feldolgozása
            foreach ($lines as $line) {
                // Az első kettőspont pozíciójának meghatározása
                $colonPosition = strpos($line, ':');
        
                // Ha van kettőspont a sorban
                if ($colonPosition !== false) {
                    $property = trim(substr($line, 0, $colonPosition));
                    $value = trim(substr($line, $colonPosition + 1));
                    $properties[$property] = $value;
                }
            }
        }

        $p->properties = $properties;

        if (!$p->name || !$p->category || !$p->sku || !$p->price) {
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
        foreach ($array['cikk'] as $key => $product) {
            $p = $this->parseProduct($product);
            if ($p == null) {
                continue;
            }
            $products[] = $p;
        }

        return $products;
    }
}
