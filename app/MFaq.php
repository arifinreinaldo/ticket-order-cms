<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MFaq extends Model
{
    use  LogsActivity;

    protected $table = 'faqs';
    protected static $logAttributes = ['question', 'answer', 'order', 'status'];
    protected static $logName = 'faqs' ;
    protected static $logOnlyDirty = true;
    protected $guarded = ['id'];
}
