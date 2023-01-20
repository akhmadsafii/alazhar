<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stuff extends Model
{
    use HasFactory;

    protected $table = 'stuffs';

    protected $guarded = [];

    public function types()
    {
        return $this->belongsTo(Type::class, 'id_type', 'id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id');
    }

    public function units()
    {
        return $this->belongsTo(Unit::class, 'id_unit', 'id');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'id_stuff', 'id');
    }

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id');
    }

    public function activeItems(){
        return $this->hasMany(Item::class, 'id_stuff', 'id')->where('status', '!=', 0);
    }
}
