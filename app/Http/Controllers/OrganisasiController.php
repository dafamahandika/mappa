<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Models\Organisasi;
 
class OrganisasiController extends Controller
{
    public function index(Request $request)
    {
        //
    }

    public function all()
    {
        return DB::table('t_organisasi')->orderBy('id_organisasi', 'asc')->get();
    }
}