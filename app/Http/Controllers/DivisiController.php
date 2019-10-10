<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Divisi;

class DivisiController extends Controller
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
        $divisi = Divisi::orderBy("created_at", "desc")->get();
        return view('divisi.index', [
            'divisi' => $divisi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = validator::make($request->all(), [
            'name' => 'required|string'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator, 'create')->withinput();
        }
        

        $divisi = Divisi::create([
            'name' => $request->name
        ]);

        return back()->with('create_divisi', "Data divisi berhasil ditambahkan");
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
        //
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
        $validator = validator::make($request->all(),[
            'name' => 'required|string'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator, 'edit')->withinput()
            ->with('id_divisi', $id);
        }

        $divisi = Divisi::findOrFail($id);
        $divisi->name = $request->name;
        $divisi->save();

        return back()->with('update_divisi', 'Data divisi berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Divisi::destroy($id);
        echo "Data Divisi ".$id." Berhasil Dihapus";
    }
}
