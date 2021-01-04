<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MArticle extends Model
{
    use  LogsActivity;

    protected $table = 'articles';
    protected static $logAttributes = ['title', 'image', 'content', 'status'];
    protected static $logName = 'article';
    protected static $logOnlyDirty = true;
    protected $guarded = ['id'];

    public function getImage()
    {
        return ($this->image) ? asset('/storage/' . $this->image) : '/svg/icon.svg';
    }

    public function getBanner()
    {
        return ($this->banner) ? asset('/storage/' . $this->banner) : '/svg/icon.svg';
    }
}
