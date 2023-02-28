<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;

    protected $table = 'arsip.t_box_folder';
    public $timestamps = false;
    protected $primaryKey = 'id_box_folder';
}
