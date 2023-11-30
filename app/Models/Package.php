<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'price', 'month', 'speed', 'description'];



    public function userMetas()
    {
        return $this->hasMany(UserMeta::class);
    }
}
