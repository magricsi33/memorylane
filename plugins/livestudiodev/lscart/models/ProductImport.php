<?php namespace LivestudioDev\Lscart\Models;

use LivestudioDev\Lscart\Models\Product;

class ProductImport extends \Backend\Models\ImportModel
{
    /**
     * @var array The rules to be applied to the data.
     */
    public $rules = [];

    public function importData($results, $sessionKey = null)
    {
        foreach ($results as $row => $data) {

            foreach ($data as $key => $value) {
                if($value == ""){
                    unset($data[$key]);
                }
            }

            try {                
                $product = new Product;
                $product->fill($data);
                $product->save();

                $this->logCreated();
            }
            catch (\Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }

        }
    }
}