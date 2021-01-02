<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MBanner extends Model
{
    use  LogsActivity;

    protected $table = 'banners';
    protected static $logAttributes = ['title', 'image', 'link', 'order', 'status'];
    protected static $logName = 'banner';
    protected static $logOnlyDirty = true;
    protected $guarded = ['id'];

    public function getImage()
    {
        return ($this->image) ? asset('/storage/' . $this->image) : '/svg/icon.svg';
    }
}
