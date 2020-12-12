<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MActivity extends Model
{
//    protected static $logAttributes = [];
//    protected static $logName = ;
    protected static $logOnlyDirty = true;
    protected $guarded = ['id'];
}
