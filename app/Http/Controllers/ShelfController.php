<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Models\Shelf;
 
class ShelfController extends Controller
{
    public function index(Request $request)
    {
        $data['page'] = Route::current()->uri;
        $data['last_id_rak']    = DB::table('arsip.t_rak')->orderBy('id_rak', 'desc')->first();
        $data['last_id_shelf']  = DB::table('arsip.t_shelf')->orderBy('id_shelf', 'desc')->first();
        $data['lokasi_shelf']   = DB::table('arsip.t_shelf as ts')
                                    ->join('arsip.t_rak as tr', 'ts.id_rak', '=', 'tr.id_rak')
                                    ->join('public.t_lokasi_penyimpanan as tlp', 'tr.id_lokasi_penyimpanan', '=', 'tlp.id_lokasi_penyimpanan')
                                    ->join('public.t_organisasi as torg', 'tlp.id_organisasi', '=', 'torg.id_organisasi')
                                    ->select('torg.id_organisasi', 'torg.nm_organisasi', 'tlp.id_lokasi_penyimpanan', 'tlp.nm_lokasi_penyimpanan', 'tr.id_rak', 'tr.nm_rak', 'ts.id_shelf', 'ts.nm_shelf')
                                    ->where('ts.id_shelf', $data['last_id_shelf']->id_shelf)
                                    ->first();

        return view('shelf', $data);
    }

    public function find(Request $request)
    {
        $type = $request->type;

        $query = DB::table('arsip.t_shelf as ts')
                    ->join('arsip.t_rak as tr', 'ts.id_rak', '=', 'tr.id_rak')
                    ->join('public.t_lokasi_penyimpanan as tlp', 'tr.id_lokasi_penyimpanan', '=', 'tlp.id_lokasi_penyimpanan')
                    ->join('public.t_organisasi as torg', 'tlp.id_organisasi', '=', 'torg.id_organisasi')
                    ->select('torg.id_organisasi', 'torg.nm_organisasi', 'tlp.id_lokasi_penyimpanan', 'tlp.nm_lokasi_penyimpanan', 'tr.id_rak', 'tr.nm_rak', 'ts.id_shelf', 'ts.nm_shelf');

        if ($type == 'rak') {
            $query->where('tr.id_rak', $request->id);
            return $query->get();
        } else {
            $query->where('ts.id_shelf', $request->id);
            return $query->first();
        }
    }

    public function find_id_rak(Request $request)
    {
        return DB::table('arsip.t_shelf as ts')
                ->join('arsip.t_rak as tr', 'ts.id_rak', '=', 'tr.id_rak')
                ->join('public.t_lokasi_penyimpanan as tlp', 'tr.id_lokasi_penyimpanan', '=', 'tlp.id_lokasi_penyimpanan')
                ->join('public.t_organisasi as torg', 'tlp.id_organisasi', '=', 'torg.id_organisasi')
                ->select('torg.id_organisasi', 'torg.nm_organisasi', 'tlp.id_lokasi_penyimpanan', 'tlp.nm_lokasi_penyimpanan', 'tr.id_rak', 'tr.nm_rak', 'ts.id_shelf', 'ts.nm_shelf')
                ->where('ts.id_shelf', $request->id)
                ->first();
    }

    public function generate(Request $request)
    {
        $id_shelf = $request->last_id_shelf + 1;
        $html = "";

        // range
        if ($request->range == "1") {
            for ($id_rak = $request->start_id_rak; $id_rak <= $request->end_id_rak; $id_rak++) {
                for ($shelf = $request->start_shelf; $shelf <= $request->end_shelf; $shelf++) {
                    $kuota = $request->kuota;
                    $nm_shelf = str_pad($shelf,3,"0",STR_PAD_LEFT);
                    $html .= "<tr>";
                    $html .= "<td>".$id_shelf++."</td>";
                    $html .= "<td>".$id_rak."</td>";
                    $html .= "<td>".$nm_shelf."</td>";
                    $html .= "<td>".$nm_shelf."</td>";
                    $html .= "<td>".$kuota."</td>";
                    $html .= "<td>".$request->tanggal."</td>";
                    $html .= "<td>".$request->user."</td>";
                    $html .= "<td>false</td>";
                    $html .= "<td></td>";
                    $html .= "</tr>";
                }
            }
        }
        // selektif
        else {
            foreach ($request->id_raks as $id_rak) {
                for ($shelf = $request->start_shelf; $shelf <= $request->end_shelf; $shelf++) {
                    $kuota = $request->kuota;
                    $nm_shelf = str_pad($shelf,3,"0",STR_PAD_LEFT);
                    $html .= "<tr>";
                    $html .= "<td>".$id_shelf++."</td>";
                    $html .= "<td>".$id_rak."</td>";
                    $html .= "<td>".$nm_shelf."</td>";
                    $html .= "<td>".$nm_shelf."</td>";
                    $html .= "<td>".$kuota."</td>";
                    $html .= "<td>".$request->tanggal."</td>";
                    $html .= "<td>".$request->user."</td>";
                    $html .= "<td>false</td>";
                    $html .= "<td></td>";
                    $html .= "</tr>";
                }
            }
        }

        return $html;
    }
}