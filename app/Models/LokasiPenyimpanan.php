<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiPenyimpanan extends Model
{
    use HasFactory;

    protected $table = 'public.t_lokasi_penyimpanan';
    public $timestamps = false;
    protected $primaryKey = 'id_lokasi_penyimpanan';
}
