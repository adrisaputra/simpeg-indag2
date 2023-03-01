<?php

namespace App\Http\Controllers;

use App\Models\Notulen;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class NotulenController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Notulen Rapat";
		$notulen = DB::table('notulen_tbl')->orderBy('id','DESC')->paginate(10);
		return view('admin.notulen.index',compact('title','notulen'));
    }
	
	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Notulen Rapat";
        $notulen = $request->get('search');
		$notulen = Notulen::
                where(function ($query) use ($notulen) {
                    $query->where('agenda', 'LIKE', '%'.$notulen.'%')
                        ->orWhere('pimpinan', 'LIKE', '%'.$notulen.'%')
                        ->orWhere('anggota', 'LIKE', '%'.$notulen.'%')
                        ->orWhere('tanggal', 'LIKE', '%'.$notulen.'%');
                })
                ->orderBy('id','DESC')->paginate(10);
		return view('admin.notulen.index',compact('title','notulen'));
    }
	
	## Tampilkan Form Create
	public function create()
    {
        $title = "Notulen Rapat";
        $view=view('admin.notulen.create', compact('title'));
        $view=$view->render();
        return $view;
    }
	
	## Simpan Data
	public function store(Request $request)
    {
		$this->validate($request, [
            'agenda' => 'required',
            'pimpinan' => 'required',
            'anggota' => 'required',
            'tanggal' => 'required',
            'file_notulen' => 'required|mimes:pdf|max:500'
		]);
		
        $input['agenda'] = $request->agenda;
        $input['pimpinan'] = $request->pimpinan;
        $input['anggota'] = $request->anggota;
        $input['tanggal'] = $request->tanggal;

        if($request->file('file_notulen')){
            $input['file_notulen'] = time().'.'.$request->file_notulen->getClientOriginalExtension();
            $request->file_notulen->move(public_path('upload/file_notulen'), $input['file_notulen']);
        }	
		
        $input['user_id'] = Auth::user()->id;
        Notulen::create($input);
		
		return redirect('/notulen')->with('status','Data Tersimpan');

    }
	
	## Tampilkan Form Edit
    public function edit(Notulen $notulen)
    {
        $title = "Notulen Rapat";
        $view=view('admin.notulen.edit', compact('title','notulen'));
        $view=$view->render();
		return $view;
    }
	
	## Edit Data
    public function update(Request $request, Notulen $notulen)
    {
		$this->validate($request, [
            'agenda' => 'required',
            'pimpinan' => 'required',
            'anggota' => 'required',
            'tanggal' => 'required',
            'file_notulen' => 'mimes:pdf|max:500'
		]);
		
        if($request->file('file_notulen') && $notulen->file_notulen){
            $pathToYourFile = public_path('upload/file_notulen/'.$notulen->file_notulen);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        $notulen->fill($request->all());
       
        if($request->file('file_notulen')){
            $filename = time().'.'.$request->file_notulen->getClientOriginalExtension();
            $request->file_notulen->move(public_path('upload/file_notulen'), $filename);
            $notulen->file_notulen = $filename;
        }
        
        $notulen->user_id = Auth::user()->id;
        $notulen->save();
    
		return redirect('/notulen')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete(Notulen $notulen)
    {
        $pathToYourFile = public_path('upload/file_notulen/'.$notulen->file_notulen);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

		$notulen->delete();
		
		return redirect('/notulen')->with('status', 'Data Berhasil Dihapus');
    }
}
