<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;
use App\Kategori;
use App\Divisi;
use App\Lemari;
use App\SuratMasuk;
use App\SuratKeluar;
use Carbon\Carbon;

class DashboardController extends Controller
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

    public function admin()
    {
    	$user = Auth::user();
        $jml_user = User::count();
        $jml_kategori = Kategori::count();
        $jml_lemari = Lemari::count();
        $new_users = User::orderBy('created_at', 'desc')->take(8)->get();

        $jml_user_role = [];
        $roles = Role::all();
        foreach ($roles as $role) {
            $jml_user_role[$role->name] = $role->user()->count();
        }
        // dd($jml_user_role);
        // $jml_divisi = Divisi::count();
    	return view('dashboard.adminDashboard', [
    		'user' => $user,
            'jml_user' => $jml_user,
            'jml_kategori' => $jml_kategori,
            'jml_lemari' => $jml_lemari,
            'new_users' => $new_users,
            'jml_user_role' => $jml_user_role
            // 'jml_divisi' => $jml_divisi,
    	]);
    }

    public function operator()
    {
        $suratMasuk_count = SuratMasuk::count();
        $suratKeluar_count = SuratKeluar::count();

        $bulan = Carbon::today()->locale('id_ID')->isoFormat('MMMM Y');
        $jml_sm = [];
        $jml_sk = [];
        $start = Carbon::today()->startOfMonth();
        $batas = Carbon::today()->startOfMonth()->addDays(7);
        for ($i=0; $i < 4; $i++) { 
            $jml_sm[] = SuratMasuk::whereBetween('created_at', [$start, $batas])->count();
            $jml_sk[] = SuratKeluar::whereBetween('created_at', [$start, $batas])->count();
            if ($i == 3) {
                $batas = Carbon::today()->endOfMonth();
            }
            else{
                $batas->addDays(7);
            }
            $start->addDays(7);
        }
        
        $sm_noLemari = SuratMasuk::where('lemari_id', null)->count();
        $sm_noFile = SuratMasuk::where('file_surat', null)->count();

        $sk_noLemari = SuratKeluar::where('lemari_id', null)->count();
        $sk_noFile = SuratKeluar::where('file_surat', null)->count();
        $sk_revisi = SuratKeluar::where('status', "Revisi")->count();

        $surat_baru = SuratMasuk::orderBy('created_at', 'desc')->take(3)->get();
        $surat_baru2 = SuratKeluar::orderBy('created_at', 'desc')->take(3)->get();
        foreach ($surat_baru2 as $key) {
            $surat_baru->push($key);
        }
        $surat_baru = $surat_baru->sortByDesc('created_at');
        // dd($surat_baru);
        
        return view('dashboard.operatorDashboard', [
            'suratMasuk_count' => $suratMasuk_count,
            'suratKeluar_count' => $suratKeluar_count,
            'bulan' => $bulan,
            'jml_sm' => $jml_sm,
            'jml_sk' => $jml_sk,
            'sm_noLemari' => $sm_noLemari,
            'sm_noFile' => $sm_noFile,
            'sk_noLemari' => $sk_noLemari,
            'sk_noFile' => $sk_noFile,
            'sk_revisi' => $sk_revisi,
            'surat_baru' => $surat_baru
        ]);
    }

    public function manajer()
    {
        $suratMasuk_count = SuratMasuk::count();
        $suratKeluar_count = SuratKeluar::count();

        $bulan = Carbon::today()->locale('id_ID')->isoFormat('MMMM Y');
        $jml_sm = [];
        $jml_sk = [];
        $start = Carbon::today()->startOfMonth();
        $batas = Carbon::today()->startOfMonth()->addDays(7);
        for ($i=0; $i < 4; $i++) { 
            $jml_sm[] = SuratMasuk::whereBetween('created_at', [$start, $batas])->count();
            $jml_sk[] = SuratKeluar::whereBetween('created_at', [$start, $batas])->count();
            if ($i == 3) {
                $batas = Carbon::today()->endOfMonth();
            }
            else{
                $batas->addDays(7);
            }
            $start->addDays(7);
        }
        
        
        return view('dashboard.manajerDashboard', [
            'suratMasuk_count' => $suratMasuk_count,
            'suratKeluar_count' => $suratKeluar_count,
            'bulan' => $bulan,
            'jml_sm' => $jml_sm,
            'jml_sk' => $jml_sk
            
        ]);
    }
}
