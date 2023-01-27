<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depreciation extends Model
{
    use HasFactory;

    protected $table = 'depreciations';

    protected $guarded = [];

    public function items()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id');
    }
}
