<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    // 取消维护时间戳
    public $timestamps = false;
}
