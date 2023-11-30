<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserMeta extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'phone',
        'address',
        'rt',
        'rw',
        'longlat',
        'province_id',
        'province_name',
        'regencies_id',
        'regencies_name',
        'district_id',
        'district_name',
        'ward_id',
        'ward_name',
        'package_id',
        'xmedia_id',
        'status',
    ];



    protected $table = 'user_metas';

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
