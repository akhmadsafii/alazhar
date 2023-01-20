<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $guarded = [];

    public function types()
    {
        return $this->belongsTo(Type::class, 'id_type', 'id');
    }

    public function stuffs()
    {
        return $this->belongsTo(Stuff::class, 'id_stuff', 'id');
    }

    public function locations()
    {
        return $this->belongsTo(Location::class, 'id_location', 'id');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class, 'id_item', 'id');
    }
}
