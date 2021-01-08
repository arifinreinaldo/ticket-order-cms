<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MRidecategory extends Model
{
    use  LogsActivity;

    protected $table = 'game_center_ride_categories';
    protected static $logAttributes = ['name'];
    protected static $logName = 'ride category';
    protected static $logOnlyDirty = true;
    protected $guarded = ['id'];

    /*public function getImage()
    {
        return ($this->image) ? asset('/storage/' . $this->image) : '/svg/icon.svg';
    }*/
}
