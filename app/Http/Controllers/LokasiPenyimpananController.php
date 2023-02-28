<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Models\LokasiPenyimpanan;
 
class LokasiPenyimpananController extends Controller
{
    public function index(Request $request)
    {
        //
    }

    public function find(Request $request)
    {
        $type = $request->type;

        $query = DB::table('public.t_lokasi_penyimpanan as tlp')
                ->join('public.t_organisasi as torg', 'tlp.id_organisasi', '=', 'torg.id_organisasi')
                ->select('torg.id_organisasi', 'torg.nm_organisasi', 'tlp.id_lokasi_penyimpanan', 'tlp.nm_lokasi_penyimpanan');
        
        if ($type == 'lokasi_penyimpanan') {
            return $query->where('tlp.id_lokasi_penyimpanan', $request->id)->first();
        } else {
            return $query->where('torg.id_organisasi', $request->id)->get();
        }
    }
}