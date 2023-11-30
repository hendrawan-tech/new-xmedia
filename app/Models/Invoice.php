<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'external_id',
        'invoice_url',
        'price',
        'status',
        'user_id',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
