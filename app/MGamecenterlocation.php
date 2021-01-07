<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MGamecenterlocation extends Model
{
    use  LogsActivity;

    protected $table = 'game_center_locations';
    protected static $logAttributes = ['name'];
    protected static $logName = 'game center location';
    protected static $logOnlyDirty = true;
    protected $guarded = ['id'];

    public function getBranch()
    {
        return $this->hasMany(MGamecenterbranch::class, 'game_center_location_id', 'id')->orderBy('id');;
    }
}
