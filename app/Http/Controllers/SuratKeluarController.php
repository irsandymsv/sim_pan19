<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\SuratKeluar;
use App\Kategori;
use App\Lemari;
use App\User;
use App\Role;
use Notification;
use App\Notifications\surat_keluar;

class SuratKeluarController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surat = SuratKeluar::orderBy('created_at', 'desc')->with('lemari:id,nomor')->get();
        return view('surat.index', [
            'surat' => $surat,
            'tipe' => 'surat keluar'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Kategori::all();
        $lemari = Lemari::all();
        // dd($lemari);
        return  view('surat.create', [
            'kategori' => $kategori,
            'lemari' => $lemari,
            'tipe' => 'surat keluar'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nomor_surat' =>'required|string|unique:surat_keluar',
            'perihal' => 'required|string',
            'kategori_id' => 'required',
            'tujuan' => 'required|string',
            'tanggal_surat' => 'required',
            'jumlah_lampiran' => 'required|numeric|max:127',
            // 'file_surat' => 'required|mimetypes:application/pdf, image/jpeg, image/png|max:2048'
        ]);

        $data_file = null;
        if ($request->hasFile('file_surat')) {
            foreach ($request->file_surat as $key => $value) {
               $filename = $request->nomor_surat."_".$value->getClientOriginalName();
               $path = $value->storeAs('suratKeluar', $filename);
               $data_file[$key] = $path;
            }
        }

        if (!is_null($data_file)) {
            $data_file = json_encode($data_file);  
        } 
        

        $surat = SuratKeluar::create([
            'nomor_surat' => $request->nomor_surat,
            'perihal' => $request->perihal,
            'kategori_id' => $request->kategori_id,
            'tujuan' => $request->tujuan,
            'tanggal_surat' => $request->tanggal_surat,
            'jumlah_lampiran' => $request->jumlah_lampiran,
            'lemari_id' => $request->lemari_id,
            'baris_lemari' => $request->baris_lemari,
            'file_surat' => $data_file,
            'operator_id' => Auth::id()
        ]);

        $role= Role::where("name", "manajer")->first();
        $manajer = $role->user;
        Notification::send($manajer, new surat_keluar($surat));

        return redirect()->route('operator.surat-keluar.show', $surat->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $surat = SuratKeluar::findOrFail($id);
        
        // dd($file);
        if (!is_null($surat->file_surat)) {
            $file = json_decode($surat->file_surat, true);
            $url = [];
            foreach ($file as $key => $value) {
                $url[$key] = Storage::url("$value");
            }
            $surat->file_surat = $url;
        }
        
        return view('surat.detail', [
            'surat' => $surat,
            'tipe' => 'surat keluar'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $surat = SuratKeluar::findOrFail($id);
        $file = [];
        if (!is_null($surat->file_surat)) {
            $file = json_decode($surat->file_surat, true);    
            $surat->file_surat = $file;
        }

        $kategori = Kategori::all();
        $lemari = Lemari::all();
        return view('surat.edit', [
            'surat' => $surat,
            'kategori' => $kategori,
            'lemari' =>$lemari,
            'tipe' => 'surat keluar'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $surat = SuratKeluar::findOrFail($id);
        $valdiate = validator::make($request->all(), [
            'perihal' => 'required|string',
            'kategori_id' => 'required',
            'tujuan' => 'required|string',
            'tanggal_surat' => 'required',
            'jumlah_lampiran' => 'required|numeric|max:127',
            'nomor_surat' => [
                'required', 'string',
                Rule::unique('surat_keluar')->ignore($surat)
            ]
        ])->validate();
        
        $file = json_decode($surat->file_surat, true);
        $hapus = $request->hapus_file;
        if (!is_null($hapus)) {
            foreach ($hapus as $key => $value) {
                if (!is_null($value)) {
                    Storage::delete("$file[$value]");
                    unset($file[$value]);    
                }
            }
        }
        
        // $data_file = $file;

        if ($request->hasFile('file_surat')) {
            foreach ($request->file_surat as $key => $value) {
               $filename = $request->nomor_surat."_".$value->getClientOriginalName();
               $path = $value->storeAs('suratKeluar', $filename);
               $file[] = $path;
            }
        }

        if (!empty($file)) {
            $file = json_encode($file);
        }
        else{
            $file = null;
        }

        $surat->nomor_surat = $request->nomor_surat;
        $surat->perihal = $request->perihal;
        $surat->kategori_id = $request->kategori_id;
        $surat->tujuan = $request->tujuan;
        $surat->tanggal_surat = $request->tanggal_surat;
        $surat->jumlah_lampiran = $request->jumlah_lampiran;
        $surat->file_surat = $file;
        $surat->lemari_id = $request->lemari_id;
        $surat->baris_lemari = $request->baris_lemari;
        $surat->save();

        return redirect()->route('operator.surat-keluar.show', $surat->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = SuratKeluar::findOrFail($id)->delete();
        echo "$deleted";
    }


    //Manajer update status surat keluar
    public function updateStatus(Request $request, $id)
    {
        $validateData = $request->validate([
            'status' => 'required'
        ]);

        $surat = SuratKeluar::findOrFail($id);
        $surat->status = $request->status;
        $surat->catatan_revisi = $request->catatan_revisi;
        $surat->save();

        $role= Role::where("name", "operator")->first();
        $operator = $role->user;
        Notification::send($operator, new surat_keluar($surat));

        return redirect()->route('manajer.surat-keluar.show', $id);
    }

    /**
     * Menampilkan surat keluar yang belum lengkap datanya (file atau lemari)
     * @param string $kelengkapan
     */
    public function kelengkapan($data)
    {
        if ($data == "Lemari") {
            $surat = SuratKeluar::where('lemari_id', null)
            ->with('lemari:id,nomor')
            ->get();
        }
        elseif ($data == "File"){
            $surat = SuratKeluar::where('file_surat', null)
            ->with('lemari:id,nomor')
            ->get();
        }
        elseif ($data == "Revisi") {
            $surat = SuratKeluar::where('status', "Revisi")
            ->with('lemari:id,nomor')
            ->get();
        }
        // dd($surat);

        foreach ($surat as $item) {
            $file = json_decode($item->file_surat);
            $url = [];

            if (!is_null($file)) {
                
                foreach ($file as $key => $value) {
                    $url[$key] = Storage::url("$value");
                }
                $item->file_surat = $url;
            }
        }

        $tipe = "surat keluar";
        return view('surat/index_kelengkapan', [
            'surat' => $surat,
            'tipe' => $tipe,
            'data' => $data
        ]);
        
    }
}
