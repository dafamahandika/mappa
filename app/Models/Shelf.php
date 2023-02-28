<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    use HasFactory;

    protected $table = 'arsip.t_shelf';
    public $timestamps = false;
    protected $primaryKey = 'id_shelf';
}
