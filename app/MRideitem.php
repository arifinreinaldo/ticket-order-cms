<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MRideitem extends Model
{
    use  LogsActivity;

    protected $table = 'game_center_ride_items';
    protected static $logAttributes = ['name', 'type', 'cover', 'banner', 'content'];
    protected static $logName = 'game center category items';
    protected static $logOnlyDirty = true;
    protected $guarded = ['id'];

    public function getBanner()
    {
        return ($this->banner) ? asset('/storage/' . $this->banner) : '/svg/icon.svg';
    }

    public function getCover()
    {
        return ($this->cover) ? asset('/storage/' . $this->cover) : '/svg/icon.svg';
    }

    public function getDetail()
    {
        return $this->hasMany(MRideitemDetail::class, 'gcr_category_item_id', 'id');
    }
}
