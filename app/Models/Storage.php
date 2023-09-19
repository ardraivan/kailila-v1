<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\StorageType;

class Storage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'storage_type_id',
        'name',
        'colour_id', 
        'user_id', 
    ];

    public function storageType()
    {
        return $this->belongsTo(StorageType::class);
    }

    public function colour()
    {
        return $this->belongsTo(Colour::class, 'colour_id'); 
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function itemLocations(): HasMany
    {
        return $this->hasMany(ItemLocation::class);
    }
}
