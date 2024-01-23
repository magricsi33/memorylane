<?php

namespace LivestudioDev\Lscart\Classes;

use LivestudioDev\Lscart\Classes\Resolvers\ComputerImperiumResolver;
use LivestudioDev\Lscart\Classes\Resolvers\DotcompResolver;
use LivestudioDev\Lscart\Models\Category;
use LivestudioDev\Lscart\Models\Product;
use LivestudioDev\Lscart\Models\StorageItem;
use LivestudioDev\Lscart\Models\Property;
use LivestudioDev\Lscart\Models\Propertable;
use Carbon\Carbon;

class FeedType
{
    const COMPUTER_IMPERIUM = 1;
    const COMPMARKET = 2;
    const DOTCOMP = 3;
}

class XmlFeedResolver
{

    public function resolve(int $type)
    {
        $feed = null;

        switch ($type) {
            case FeedType::COMPUTER_IMPERIUM:
                $feed = new ComputerImperiumResolver();
                break;
            case FeedType::COMPMARKET:
                $feed = new CompMarketResolver();
                break;
            case FeedType::DOTCOMP:
                $feed = new DotcompResolver();
                break;
        }

        if ($feed == null) {
            throw new \Exception("Feed type not found");
        }

        return $feed->retrieve();
    }

    public static function syncProducts($type = null) {

        set_time_limit(0); // no time limit
        $resolver = new self();
        
        // Resolve each type of feed
        if (!$type) {
            $types = [
                FeedType::COMPUTER_IMPERIUM, 
                FeedType::COMPMARKET, 
                FeedType::DOTCOMP, 
            ];
        } else {
            $types[] = $type;
        }
       
        foreach ($types as $type) {

            $products = collect($resolver->resolve($type));

            $categoryDatas = $products->map(function ($product) {
                return $product->category;
            })->unique()->values()->all();

            Category::updateOrCreate([
                'name' => $cname
            ], [
                'name' => $cname,
                'active' => 1,
            ]);

            foreach ($products as $product_key => $pData) {

                if ($product_key < 10) {
 
                    try {

                        $categories = explode('>', $pData->category);

                        $category = Category::where('name', $pData->category)->first();

                        $properties = $pData->properties;

                        if (count($properties) > 0) {
                            foreach ($properties as $pp_key => $p_property) {
                                $property = Property::firstOrCreate([
                                    'name' => $pp_key,
                                ], [
                                    'name' => $pp_key,
                                    'type' => 2,
                                    'extra' => [],
                                    'filter_type' => "checklist",
                                    'filter_unit' => "",
                                ]);
                            
                                $extras = $property->extra;
                            
                                try {
                                    $found = false;
                            
                                    foreach ($extras as $key => $extra) {
                                        if ($extra['item'] == $p_property) {
                                            $found = true;
                                            break;
                                        }
                                    }
                            
                                    if (!$found) {
                                        $extras[] = [
                                            'item' => $p_property,
                                        ];
                                    }
                            
                                    $property->extra = $extras;
                                    $property->save();
                                } catch (\Throwable $th) {
                                    dd($p_property);
                                }
                            
                                $propertable = Propertable::firstOrCreate([
                                    'property_id' => $property->id,
                                    'propertable_type' => 'LivestudioDev\Lscart\Models\Category',
                                    'propertable_id' => $category->id,
                                ], [
                                    'property_id' => $property->id,
                                    'propertable_type' => 'LivestudioDev\Lscart\Models\Category',
                                    'propertable_id' => $category->id,
                                    'propertable_value' => null,
                                ]);
                            }
                        }

                        $product = Product::firstOrCreate([
                            'b_sku' => $pData->b_sku,
                        ], [
                            'name' => $pData->name,
                            'description' => $pData->description,
                            'cikkszam' => $pData->sku,
                            'image_link' => $pData->image,
                            'gallery_links' => $pData->gallery,
                            'category_id' => $category ? $category->id : null,
                            'b_sku' => $pData->b_sku,
                        ]);

                        $category_id = $product->category_id;

                        if ($product->image_link && empty($product->image)) {

                            $file = new \System\Models\File;
                            $file->fromUrl($product->image_link, 'termek-'.Carbon::now()->format('YmdHis').'.png');
                            $product->image = $file;
                            $product->save();
                        }

                        if ($product->gallery_links && count($product->gallery) == 0) {
                            
                            $galleries = [];

                            foreach ($product->gallery_links as $key => $galleryImg) {
                                
                                $file = new \System\Models\File;
                                $file->fromUrl($galleryImg, 'termek-geleria-'.Carbon::now()->format('YmdHis').'.png');
                                $galleries = $file;
                                
                            }

                            $product->gallery = $galleries;
                            $product->save();
                        }

                        if (count($properties) > 0) {
                            foreach ($category->properties as $c_prop_key => $prop) {

                                $index = null;

                                $checkArray = $pData->properties[$prop->name] ?? false;
                                
                                if ($checkArray) {
                                    foreach ($prop->extra as $extra_key => $prop_extra) {
                                
                                        if ($prop_extra['item'] == $pData->properties[$prop->name]) {
                                            $index = $extra_key;
                                            break;
                                        }

                                    }
                                
                                    $property_find = Property::where('name', $prop->name)->first();
                            
                                    $propertable = Propertable::firstOrCreate([
                                        'property_id' => $property_find->id,
                                        'propertable_type' => 'LivestudioDev\Lscart\Models\Product',
                                        'propertable_id' => $product->id,
                                    ], [
                                        'property_id' => $property_find->id,
                                        'propertable_type' => 'LivestudioDev\Lscart\Models\Product',
                                        'propertable_id' => $product->id,
                                        'propertable_value' => $index,
                                    ]);        
                                }

                            }
                        }

                        $storage = StorageItem::updateOrCreate([
                            'b_sku' => $pData->b_sku,
                            'partner' => $pData->partner
                        ], [
                            'name' => $pData->name,
                            'description' => $pData->description,
                            'cikkszam' => $pData->sku,
                            'price_netto' => intval($pData->price),
                            'price_brutto' => intval($pData->price) * 1.27,
                            'stock' => $pData->stock,
                            'image_link' => $pData->image,
                            'gallery_links' => implode(',', $pData->gallery),
                            'category_id' => $category ? $category->id : $category_id,
                            'partner' => $pData->partner,
                            'type' => $pData->type,
                            'guarantee' => $pData->guarantee,
                            'properties' => $pData->properties,
                            'transport' => $pData->transport,
                            'b_sku' => $pData->b_sku,
                            'product_id' => $product->id,
                        ]);

                    } catch (\Throwable $th) {
                        dd($th->getMessage());
                    }

                } else {
                    break;
                }
            }

        }

        // $products = $resolver->retrieve();

    }
}
