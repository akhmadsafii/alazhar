<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrokenAction extends Model
{
    use HasFactory;
    protected $table = 'broken_actions';

    protected $guarded = [];

}
