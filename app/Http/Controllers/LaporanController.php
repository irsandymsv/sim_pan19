<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SuratMasuk;
use App\SuratKeluar;

class LaporanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      $tahun = [];
      $old = 0;
      $new = 0;

      if (SuratMasuk::exists() && SuratKeluar::exists()) {
       	$oldestSM = SuratMasuk::orderBy("created_at", "asc")->first();
         $newestSM = SuratMasuk::orderBy("created_at", "desc")->first(); 

         $oldestSK = SuratKeluar::orderBy("created_at", "asc")->first();
       	$newestSK = SuratKeluar::orderBy("created_at", "desc")->first();

         $old = min($oldestSM->created_at->year, $oldestSK->created_at->year);
         $new = max($newestSM->created_at->year, $newestSK->created_at->year); 
      }
      elseif(SuratMasuk::exists()){
         $old = SuratMasuk::orderBy("created_at", "asc")->first()->created_at->year;
         $new = SuratMasuk::orderBy("created_at", "desc")->first()->created_at->year;
      }
      elseif(SuratKeluar::exists()){
         $old = SuratKeluar::orderBy("created_at", "asc")->first();
         $new = SuratKeluar::orderBy("created_at", "desc")->first();
      }

      for ($i=$old; $i <= $new; $i++) { 
         $tahun[] = $old;
         $old++;
      }
    	
    	// dd($tahun);
    	return view('laporan.index', [
    		'tahun' => $tahun
    	]);
    }

    //AJAX
    public function getData(Request $req)
    {
    	$suratMasuk = SuratMasuk::whereMonth("created_at", $req->bulan)
    	->whereYear("created_at", $req->tahun)
    	->with("kategori:id,name")
    	->get();

    	$suratKeluar = SuratKeluar::whereMonth("created_at", $req->bulan)
    	->whereYear("created_at", $req->tahun)
    	->with("kategori:id,name")
    	->get();

    	$surat = array(
    		'suratMasuk' => $suratMasuk, 
    		'suratKeluar' => $suratKeluar
    	);

    	echo json_encode($surat);
    }
}
