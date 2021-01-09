<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MRideitemDetail extends Model
{
    use  LogsActivity;

    protected $table = 'game_center_ride_item_details';
    protected static $logAttributes = ['name', 'image', 'content'];
    protected static $logName = 'game center category items detail';
    protected static $logOnlyDirty = true;
    protected $guarded = ['id'];

    public function getImage()
    {
        return ($this->image) ? asset('/storage/' . $this->image) : '/svg/icon.svg';
    }
}
