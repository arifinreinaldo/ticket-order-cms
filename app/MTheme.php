<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MTheme extends Model
{
    use  LogsActivity;

    protected $table = 'themeparks';
    protected static $logAttributes = ['name', 'image', 'status'];
    protected static $logName = 'theme park';
    protected static $logOnlyDirty = true;
    protected $guarded = ['id'];

    public function getImage()
    {
        return ($this->image) ? asset('/storage/' . $this->image) : '/svg/icon.svg';
    }
}
