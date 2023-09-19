<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemLocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'item_id',
        'storage_id',
        'quantity',
    ];

    protected $touches = ['item'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }
}
