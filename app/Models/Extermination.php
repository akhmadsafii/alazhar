<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extermination extends Model
{
    use HasFactory;

    protected $table = 'exterminations';

    protected $guarded = [];

    public function stuffs()
    {
        return $this->belongsTo(Stuff::class, 'id_stuff', 'id');
    }

    public function items()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id');
    }
}
