<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteSeries extends Model
{
    protected $fillable = ['user_id', 'series_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $table = 'favorites_series';
}
