<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\SuratMasuk;
use App\Kategori;
use App\Lemari;
use App\User;
use App\Role;
use Notification;
use App\Notifications\surat_masuk;

class SuratMasukController extends Controller
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
        $surat = SuratMasuk::orderBy('created_at', 'desc')->with('lemari:id,nomor')->get();
        return view('surat.index', [
            'surat' => $surat,
            'tipe' => 'surat masuk'
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
            'tipe' => 'surat masuk'
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
            'nomor_surat' =>'required|string|unique:surat_masuk',
            'perihal' => 'required|string',
            'kategori_id' => 'required',
            'pengirim' => 'required|string',
            'tujuan' => 'required|string',
            'tanggal_diterima' => 'required',
            'tanggal_surat' => 'required',
            'jumlah_lampiran' => 'required|numeric|max:127',
            // 'file_surat' => 'required|mimetypes:application/pdf, image/jpeg, image/png|max:2048'
        ]);

        $data_file = null;
        if ($request->hasFile('file_surat')) {
            foreach ($request->file_surat as $key => $value) {
               $filename = $request->nomor_surat."_".$value->getClientOriginalName();
               $path = $value->storeAs('suratMasuk', $filename);
               $data_file[$key] = $path;
            }
        }

        // dd($data_file);

        if (!is_null($data_file)) {
            $data_file = json_encode($data_file);  
        } 
        

        $surat = SuratMasuk::create([
            'nomor_surat' => $request->nomor_surat,
            'perihal' => $request->perihal,
            'kategori_id' => $request->kategori_id,
            'pengirim' => $request->pengirim,
            'tujuan' => $request->tujuan,
            'tanggal_diterima' => $request->tanggal_diterima,
            'tanggal_surat' => $request->tanggal_surat,
            'jumlah_lampiran' => $request->jumlah_lampiran,
            'lemari_id' => $request->lemari_id,
            'baris_lemari' => $request->baris_lemari,
            'file_surat' => $data_file,
            'status' => "Belum dilihat",
            'operator_id' => Auth::id()
        ]);

        $role= Role::where("name", "manajer")->first();
        $manajer = $role->user;
        Notification::send($manajer, new surat_masuk($surat));

        return redirect()->route('operator.surat-masuk.show', $surat->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $surat = SuratMasuk::findOrFail($id);

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
            'tipe' => 'surat masuk'
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
        $surat = SuratMasuk::findOrFail($id);
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
            'tipe' => 'surat masuk'
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
        $surat = SuratMasuk::findOrFail($id);
        $valdiate = validator::make($request->all(), [
            'perihal' => 'required|string',
            'kategori_id' => 'required',
            'pengirim' => 'required|string',
            'tujuan' => 'required|string',
            'tanggal_diterima' => 'required',
            'tanggal_surat' => 'required',
            'jumlah_lampiran' => 'required|numeric|max:127',
            'nomor_surat' => [
                'required', 'string',
                Rule::unique('surat_masuk')->ignore($surat)
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
               $path = $value->storeAs('suratMasuk', $filename);
               $file[] = $path;
            }
        }

        if (!empty($file)) {
            $file = json_encode($file);
        }else{
            $file = null;
        }

        $surat->nomor_surat = $request->nomor_surat;
        $surat->perihal = $request->perihal;
        $surat->kategori_id = $request->kategori_id;
        $surat->pengirim = $request->pengirim;
        $surat->tujuan = $request->tujuan;
        $surat->tanggal_diterima = $request->tanggal_diterima;
        $surat->tanggal_surat = $request->tanggal_surat;
        $surat->jumlah_lampiran = $request->jumlah_lampiran;
        $surat->file_surat = $file;
        $surat->lemari_id = $request->lemari_id;
        $surat->baris_lemari = $request->baris_lemari;
        $surat->save();

        return redirect()->route('operator.surat-masuk.show', $surat->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = SuratMasuk::findOrFail($id)->delete();
        echo "$deleted";
    }

    /**
     * Menampilkan surat masuk yang belum lengkap datanya (file atau lemari)
     * @param string $kelengkapan
     */
    public function kelengkapan($data)
    {
        if ($data == "Lemari") {
            $surat = SuratMasuk::where('lemari_id', null)
            ->with('lemari:id,nomor')
            ->get();
        }
        elseif ($data == "File"){
            $surat = SuratMasuk::where('file_surat', null)
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

        $tipe = "surat masuk";
        return view('surat/index_kelengkapan', [
            'surat' => $surat,
            'tipe' => $tipe,
            'data' => $data
        ]);
        
    }

    public function updateStatus(Request $request)
    {
        $surat = SuratMasuk::findOrFail($request->id);
        $surat->status = "Sudah dilihat";
        $surat->save();

        echo "Status diubah";
    }
}
