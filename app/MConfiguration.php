<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MConfiguration extends Model
{
    use  LogsActivity;

    protected $table = 'social_media';
    protected static $logAttributes = ['name', 'link', 'icon', 'order'];
    protected static $logName = 'social_media';
    protected static $logOnlyDirty = true;
    protected $guarded = ['id'];

    public function getImage()
    {
        return ($this->icon) ? asset('/storage/' . $this->icon) : '/svg/icon.svg';
    }
}
