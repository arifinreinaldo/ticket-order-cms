<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MGamecenterbranch extends Model
{
    use  LogsActivity;

    protected $table = 'game_center_branches';
    protected static $logAttributes = ['name', 'title', 'image', 'content'];
    protected static $logName = 'game center branch';
    protected static $logOnlyDirty = true;
    protected $guarded = ['id'];

    public function getImage()
    {
        return ($this->image) ? asset('/storage/' . $this->image) : '/svg/icon.svg';
    }
}
