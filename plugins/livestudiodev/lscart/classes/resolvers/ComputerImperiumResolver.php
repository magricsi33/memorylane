<?php

namespace LivestudioDev\Lscart\Classes\Resolvers;

use Winter\Storm\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ComputerImperiumResolver implements BaseResolver
{
    private $url = 'http://www.computeremporium.hu/datafeed/';
    private $folder = 'computerimperium';
    private $debug = true;

    private function getUrl() {
        return $this->url.'?file=proba.xml&user=Codergram&pass='.urlencode("##Cly2023").'&query=teljes_termektorzs&format=xml';
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
        $images = isset($product['kepek']['kep']) ? collect($product['kepek']['kep']) : collect([]);

        $p = new ProductDTO();
        $p->name = is_array($product['cikknev']) ? null : $product['cikknev'];
        $p->description = is_array($product['leiras']) ? '' : $product['leiras'];
        $p->category = is_array($product['cikkcsopnev']) ? null : $product['cikkcsopnev'];
        $p->sku = is_array($product['cikkszam']) ? null : $product['cikkszam'];
        $p->price = is_array($product['ar']) ? null : $product['ar'];
        $p->stock = is_array($product['keszlet']) ? 0 : $product['keszlet'];
        $p->image = $images->first();
        $p->gallery = $images->toArray();
        $p->partner = 'Computer Emporium';
        $p->guarantee = $product['garancia'] ?? '';
        $p->b_sku = $product['gycikkszam'] ?? '';
        $p->transport = $product['varhato'] ? Carbon::createFromFormat('Y.m.d', $product['varhato'])->format('Y-m-d') : null;

        $p->type = is_array($product['cikkfajta']) ? null : $product['cikkfajta'];
        
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
