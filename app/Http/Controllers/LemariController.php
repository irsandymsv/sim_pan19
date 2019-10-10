<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Lemari;

class LemariController extends Controller
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
        $lemari = Lemari::orderBy('created_at', 'desc')->get();
        return view('lemari.index', [
            'lemari' => $lemari
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lemari.create');
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
            'nomor' => 'required|string|unique:lemari',
            'lokasi' => 'required',
            'jml_baris' => 'required|numeric|max:127'
        ]);

        $lemari = new Lemari();
        $lemari->nomor = $request->nomor;
        $lemari->lokasi = $request->lokasi;
        $lemari->jml_baris = $request->jml_baris;
        $lemari->save();

        return redirect()->route('admin.lemari.index')->with('create_lemari', 'Data lemari berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lemari = Lemari::findOrFail($id);
        return view('lemari.edit', [
            'lemari' => $lemari
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
        $lemari = Lemari::findOrFail($id);
        $validateData = validator::make($request->all(), [
            'lokasi' => 'required',
            'jml_baris' => 'required|numeric|max:127',
            'nomor' => [
                'required','string',
                Rule::unique('lemari')->ignore($lemari)
            ],
        ])->validate();

        $lemari->nomor = $request->nomor;
        $lemari->lokasi = $request->lokasi;
        $lemari->jml_baris = $request->jml_baris;
        $lemari->save();

        return redirect()->route('admin.lemari.index')->with('update_lemari', 'Data lemari berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Lemari::destroy($id);
       echo "sukses hapus id ".$id;
    }
}
