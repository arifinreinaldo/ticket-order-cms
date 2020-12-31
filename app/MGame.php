<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MGame extends Model
{
    use  LogsActivity;

    protected $guarded = ['id'];
    protected $table = 'games';
    protected static $logAttributes = ['title', 'image', 'link', 'order'];
    protected static $logName = "game";
    protected static $logOnlyDirty = true;

    public function getImage()
    {
        return ($this->image) ? asset('/storage/' . $this->image) : '/svg/icon.svg';
    }

}
