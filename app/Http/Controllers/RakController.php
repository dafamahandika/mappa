<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Models\Rak;
 
class RakController extends Controller
{
    public function index(Request $request)
    {
        $data['page']           = Route::current()->uri;
        $data['last_id_rak']    = DB::table('arsip.t_rak')->orderBy('id_rak', 'desc')->first();
        $data['lokasi_rak']     = DB::table('arsip.t_rak as tr')
                                    ->join('public.t_lokasi_penyimpanan as tlp', 'tr.id_lokasi_penyimpanan', '=', 'tlp.id_lokasi_penyimpanan')
                                    ->join('public.t_organisasi as torg', 'tlp.id_organisasi', '=', 'torg.id_organisasi')
                                    ->select('torg.id_organisasi', 'torg.nm_organisasi', 'tlp.id_lokasi_penyimpanan', 'tlp.nm_lokasi_penyimpanan', 'tr.id_rak', 'tr.nm_rak')
                                    ->where('tr.id_rak', $data['last_id_rak']->id_rak)
                                    ->first();
        $data['last_id_lokasi_penyimpanan'] = DB::table('public.t_lokasi_penyimpanan as tlp')
                                    ->join('public.t_organisasi as torg', 'tlp.id_organisasi', '=', 'torg.id_organisasi')
                                    ->select('torg.id_organisasi', 'torg.nm_organisasi', 'tlp.id_lokasi_penyimpanan', 'tlp.nm_lokasi_penyimpanan')
                                    ->orderBy('id_lokasi_penyimpanan', 'desc')
                                    ->first();

        return view('rak', $data);
    }

    public function find(Request $request)
    {
        $type = $request->type;

        $query =  DB::table('arsip.t_rak as tr')
                ->join('public.t_lokasi_penyimpanan as tlp', 'tr.id_lokasi_penyimpanan', '=', 'tlp.id_lokasi_penyimpanan')
                ->join('public.t_organisasi as torg', 'tlp.id_organisasi', '=', 'torg.id_organisasi')
                ->select('torg.id_organisasi', 'torg.nm_organisasi', 'tlp.id_lokasi_penyimpanan', 'tlp.nm_lokasi_penyimpanan', 'tr.id_rak', 'tr.nm_rak');

        if ($type == 'lokasi_penyimpanan') {
            return $query->where('tlp.id_lokasi_penyimpanan', $request->id)->get();
        } else {
            return $query->where('tr.id_rak', $request->id)->first();
        }
    }

    public function generate(Request $request)
    {
        $id_rak = $request->last_id_rak + 1;
        $html = "";

        for ($no = $request->start_rak; $no <= $request->end_rak; $no++)
        {
            $cd_rak = str_pad($no,3,"0",STR_PAD_LEFT);
            $nm_rak = $request->prefix . ' ' . $cd_rak;
            $nm_rak = ltrim($nm_rak, ' ');
            
            $html .= "<tr>";
            $html .= "<td>".$id_rak++."</td>";
            $html .= "<td>".$request->id_lokasi_penyimpanan."</td>";
            $html .= "<td>".$nm_rak."</td>";
            $html .= "<td>".$cd_rak."</td>";
            $html .= "<td>".$request->tanggal."</td>";
            $html .= "<td>".$request->user."</td>";
            $html .= "<td>false</td>";
            $html .= "<td></td>";
            $html .= "</tr>";
        }

        return $html;
    }
}