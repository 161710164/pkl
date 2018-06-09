<?php

namespace App\Http\Controllers;

use App\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gurus = Guru::all();
        return view('guru.index',compact('gurus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('guru.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $this->validate($request,[
            'foto' => 'required',
            'nama_guru' => 'required|',
            'nip' => 'required|',
            'jabatan' => 'required|'
        ]);
        $gurus = new Guru;
        $gurus->foto = $request->foto;
        $gurus->nama_guru = $request->nama_guru;
        $gurus->nip = $request->nip;
        $gurus->jabatan = $request->jabatan;
        // upload foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $destinationPath = public_path() .DIRECTORY_SEPARATOR. 'assets/img';
            $filename = str_random(6).'_'.$file->getClientOriginalName();
            $uploadSuccess = $file->move($destinationPath, $filename);
            $gurus->foto = $filename;
        }
            $gurus->save();
            return redirect()->route('guru.index');
        }
    



    /**
     * Display the specified resource.
     *
     * @param  \App\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gurus = Guru::findOrFail($id);
        return view('guru.show',compact('gurus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gurus = Guru::findOrFail($id);
        return view('guru.edit',compact('gurus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
         $this->validate($request,[
            'nama_guru' => 'required|',
            'nip' => 'required|',
             'jabatan' => 'required|'
        ]);
        $gurus = Guru::findOrFail($id);
        $gurus->nama_guru = $request->nama_guru;
        $gurus->nip = $request->nip;
        $gurus->jabatan = $request->jabatan;

        $gurus->save();
        return redirect()->route('guru.index');
        // edit upload foto
        if ($request->file('foto')) {
            $file = $request->file('foto');
            $destinationPath = public_path().'/img';
            $filename = str_random(6).'_'.$file->getClientOriginalName();
            $uploadSuccess = $file->move($destinationPath, $filename);

            //hapus foto lama
            if ($gurus->foto) {
                $old_foto = $gurus->foto;
                $filepath = public_path() . DIRECTORY_SEPARATOR .'/assets/admin/images/foto'. DIRECTORY_SEPARATOR . $gurus->foto;
                try {
                    File::delete($filepath);
                } catch (FileNotFoundException $e){
                    //file sudah dihapus /tidak ada
                }
            }
            $gurus->foto = $filename;
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $gurus = Guru::findOrFail($id);
         $gurus->delete();
        return redirect()->route('guru.index');
    }
}
