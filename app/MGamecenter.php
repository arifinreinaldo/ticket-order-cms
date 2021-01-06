<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MGamecenter extends Model
{
    use  LogsActivity;

    protected $table = 'game_centers';
    protected static $logAttributes = ['name', 'status'];
    protected static $logName = 'game center';
    protected static $logOnlyDirty = true;
    protected $guarded = ['id'];

    public function getImage()
    {
        return ($this->image) ? asset('/storage/' . $this->image) : '/svg/icon.svg';
    }
}
