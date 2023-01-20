<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procurement extends Model
{
    use HasFactory;

    protected $table = 'procurements';

    protected $guarded = [];

    public function stuffs()
    {
        return $this->belongsTo(Stuff::class, 'id_stuff', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
