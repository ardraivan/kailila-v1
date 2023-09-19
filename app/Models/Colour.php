<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colour extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'hexcode'];

    public function storage()
    {
        return $this->hasOne(Storage::class)->whereHas('storageType', function ($query) {
            $query->where('name', 'Therapy Room');
        });
    }
}
