<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
    use HasFactory;

    protected $table = 'public.t_organisasi';
    public $timestamps = false;
    protected $primaryKey = 'id_organisasi';
}
