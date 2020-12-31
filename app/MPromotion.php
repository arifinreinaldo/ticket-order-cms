<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MPromotion extends Model
{
    use  LogsActivity;

    protected $table = 'promos';
    protected static $logAttributes = ['promo_name', 'promo_image', 'status', 'product_id'];
    protected static $logName = 'promo';
    protected static $logOnlyDirty = true;
    protected $guarded = ['id'];

    public function getImage()
    {
        return ($this->promo_image) ? asset('/storage/' . $this->promo_image) : '/svg/icon.svg';
    }
}
