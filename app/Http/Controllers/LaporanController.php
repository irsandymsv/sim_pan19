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
    	$suratMasuk = SuratMasuk::all();
    	$suratKeluar = SuratMasuk::all();
    	$oldestSM = SuratMasuk::orderBy("created_at", "asc")->first();
    	$oldestSK = SuratKeluar::orderBy("created_at", "asc")->first();
    	$newestSM = SuratMasuk::orderBy("created_at", "desc")->first();
    	$newestSK = SuratKeluar::orderBy("created_at", "desc")->first();

    	if ($oldestSK->created_at->year > $oldestSM->created_at->year) {
    		$old = $oldestSM->created_at->year;
    	}
    	elseif ($oldestSK->created_at->year < $oldestSM->created_at->year) {
    		$old = $oldestSK->created_at->year;
    	}
    	else{
    		$old = $oldestSK->created_at->year;
    	}

    	if ($newestSM->created_at->year > $newestSK->created_at->year) {
    		$new = $newestSM->created_at->year;
    	}
    	elseif ($newestSM->created_at->year < $newestSK->created_at->year) {
    		$new = $newestSK->created_at->year;
    	}
    	else{
    		$new = $newestSM->created_at->year;
    	}

    	$tahun = [];
    	for ($i=$old; $i <= $new; $i++) { 
    		$tahun[] = $old;
    		$old++;
    	}

    	// dd($tahun);
    	return view('laporan.index', [
    		'suratkeluar' => $suratKeluar,
    		'suratMasuk' => $suratMasuk,
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
