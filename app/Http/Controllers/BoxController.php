<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Models\Box;
 
class BoxController extends Controller
{
    public function index(Request $request) 
    {
        $data['page']               = Route::current()->uri;
        $data['last_id_box_folder'] = DB::table('arsip.t_box_folder')->orderBy('id_box_folder', 'desc')->first();
        $data['lokasi_box']         = DB::table('arsip.t_box_folder as tbf')
                                        ->join('arsip.t_shelf as ts', 'tbf.id_shelf', '=', 'ts.id_shelf')
                                        ->join('arsip.t_rak as tr', 'ts.id_rak', '=', 'tr.id_rak')
                                        ->join('public.t_lokasi_penyimpanan as tlp', 'tr.id_lokasi_penyimpanan', '=', 'tlp.id_lokasi_penyimpanan')
                                        ->join('public.t_organisasi as torg', 'tlp.id_organisasi', '=', 'torg.id_organisasi')
                                        ->select('torg.id_organisasi', 'torg.nm_organisasi', 'tlp.id_lokasi_penyimpanan', 'tlp.nm_lokasi_penyimpanan', 'tr.id_rak', 'tr.nm_rak', 'ts.id_shelf', 'ts.nm_shelf', 'tbf.id_box_folder', 'tbf.cd_box_folder')
                                        ->where('tbf.id_box_folder', $data['last_id_box_folder']->id_box_folder)
                                        ->first();
                                        // echo json_encode($data);exit();
        return view('box', $data);
    }

    public function find(Request $request)
    {
        return DB::table('arsip.t_box_folder as tbf')
                ->join('arsip.t_shelf as ts', 'tbf.id_shelf', '=', 'ts.id_shelf')
                ->join('arsip.t_rak as tr', 'ts.id_rak', '=', 'tr.id_rak')
                ->join('public.t_lokasi_penyimpanan as tlp', 'tr.id_lokasi_penyimpanan', '=', 'tlp.id_lokasi_penyimpanan')
                ->join('public.t_organisasi as torg', 'tlp.id_organisasi', '=', 'torg.id_organisasi')
                ->select('torg.id_organisasi', 'torg.nm_organisasi', 'tlp.id_lokasi_penyimpanan', 'tlp.nm_lokasi_penyimpanan', 'tr.id_rak', 'tr.nm_rak', 'ts.id_shelf', 'ts.nm_shelf', 'tbf.id_box_folder', 'tbf.cd_box_folder')
                ->where('tbf.id_box_folder', $request->id)
                ->first();
    }

    public function generate(Request $request)
    {
        $id_box_folder = $request->last_id_box_folder + 1;
        $html = "";

        // range
        if ($request->range == "1") {
            $id_shelf = $request->id_shelfs[0] - 1;
            for ($rak = $request->start_rak; $rak <= $request->end_rak; $rak++) {
                for ($shelf = $request->start_shelf; $shelf <= $request->end_shelf; $shelf++) {
                    $id_shelf++;
                    for ($box = 1; $box <= $request->kapasitas_box; $box++) {
                        $kode_box = str_pad($rak,3,"0",STR_PAD_LEFT).".".str_pad($shelf,3,"0",STR_PAD_LEFT).".".str_pad($box,3,"0",STR_PAD_LEFT);
                        $html .= "<tr>";
                        $html .= "<td>".$id_box_folder++."</td>";
                        $html .= "<td>".$id_shelf."</td>";
                        $html .= "<td>".$request->kode_pelaksana."</td>";
                        $html .= "<td>".$kode_box."</td>";
                        $html .= "<td>false</td>";
                        $html .= "<td>".$kode_box."</td>";
                        $html .= "<td>".$request->tanggal."</td>";
                        $html .= "<td>".$request->user."</td>";
                        $html .= "<td>false</td>";
                        $html .= "<td></td>";
                        $html .= "</tr>";
                    }
                }
            }
        } else {
            foreach ($request->id_raks as $key => $value) {
                $rak = ltrim($value, '0');
                $id_shelf = $request->id_shelfs[$key] - 1;
                for ($shelf = $request->start_shelf; $shelf <= $request->end_shelf; $shelf++) {
                    $id_shelf++;
                    for ($box = 1; $box <= $request->kapasitas_box; $box++) {
                        $kode_box = str_pad($rak,3,"0",STR_PAD_LEFT).".".str_pad($shelf,3,"0",STR_PAD_LEFT).".".str_pad($box,3,"0",STR_PAD_LEFT);
                        $html .= "<tr>";
                        $html .= "<td>".$id_box_folder++."</td>";
                        $html .= "<td>".$id_shelf."</td>";
                        $html .= "<td>".$request->kode_pelaksana."</td>";
                        $html .= "<td>".$kode_box."</td>";
                        $html .= "<td>false</td>";
                        $html .= "<td>".$kode_box."</td>";
                        $html .= "<td>".$request->tanggal."</td>";
                        $html .= "<td>".$request->user."</td>";
                        $html .= "<td>false</td>";
                        $html .= "<td></td>";
                        $html .= "</tr>";
                    }
                }
            }
        }

        return $html;
    }
}