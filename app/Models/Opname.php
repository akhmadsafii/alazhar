<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opname extends Model
{
    use HasFactory;

    protected $table = 'opnames';

    protected $guarded = [];

    public function stuffs()
    {
        return $this->belongsTo(Stuff::class, 'id_stuff', 'id');
    }
}
