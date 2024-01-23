<?php namespace LivestudioDev\Lscartreviews\Models;

use Model;
use \Carbon\Carbon;
use Livestudiodev\Lscartreviews\Models\Settings;
use Cms\Classes\Page as Pg;

/**
 * Model
 */
class ReviewCode extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscartreviews_reviewcodes';

    public $belongsTo = [
        'order' => ['LivestudioDev\Lscart\Models\Order'] 
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function scopeUnused($query)
    {
        return $query->where('used',0);
    }

    public static function generateFromOrder($order)
    {
        $code = self::where('order_id',$order->id)->first();
        if(!$code){
            $code = new self();
        }


        $code->order_id = $order->id;
        $code->code = rtrim(base64_encode(md5(microtime())),"=");
        $code->expires = Settings::get('expire');
        $code->expires_at = Carbon::now()->addWeeks(Settings::get('weekDelay') ? Settings::get('weekDelay') : 2);
        $code->save();

        $url = Pg::url(Settings::get('page'),['code' => $code->code]);

        return $url;
    } 
}
