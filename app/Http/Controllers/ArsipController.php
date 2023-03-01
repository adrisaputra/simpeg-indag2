<?php

namespace App\Http\Controllers;

use App\Models\Arsip;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ArsipController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        if(request()->segment(1)=='arsip_surat_masuk'){
            $title = "Arsip Surat Masuk";
            $arsip = Arsip::where('jenis',1)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        }else{
            $title = "Arsip Surat Keluar";
            $arsip = Arsip::where('jenis',2)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        }
		return view('admin.arsip.index',compact('title','arsip'));
    }
	
	## Tampilkan Data Search
	public function search(Request $request)
    {
        $arsip = $request->get('search');
        
        if(request()->segment(1)=='arsip_surat_masuk'){
            $title = "Arsip Surat Masuk";
            $arsip = Arsip::
                where('jenis',1)
                ->where(function ($query) use ($arsip) {
                    $query->where('no_surat', 'LIKE', '%'.$arsip.'%')
                        ->orWhere('perihal', 'LIKE', '%'.$arsip.'%')
                        ->orWhere('tanggal', 'LIKE', '%'.$arsip.'%');
                })
                ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        }else{
            $title = "Arsip Surat Keluar";
            $arsip = Arsip::
                where('jenis',2)
                ->where(function ($query) use ($arsip) {
                    $query->where('no_surat', 'LIKE', '%'.$arsip.'%')
                        ->orWhere('perihal', 'LIKE', '%'.$arsip.'%')
                        ->orWhere('tanggal', 'LIKE', '%'.$arsip.'%');
                })
                ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        }
		
		return view('admin.arsip.index',compact('title','arsip'));
    }
	
	## Tampilkan Form Create
	public function create()
    {
        if(request()->segment(1)=='arsip_surat_masuk'){
            $title = "Arsip Surat Masuk";
        } else {
            $title = "Arsip Surat Keluar";
        }
        $view=view('admin.arsip.create', compact('title'));
        $view=$view->render();
        return $view;
    }
	
	## Simpan Data
	public function store(Request $request)
    {
        if(request()->segment(1)=='arsip_surat_masuk'){
            $this->validate($request, [
                'no_surat' => 'required',
                'tanggal' => 'required',
                'perihal' => 'required',
                'disposisi' => 'required',
                'file_arsip' => 'required|mimes:pdf|max:500'
            ]);
        } else {
            $this->validate($request, [
                'no_surat' => 'required',
                'tanggal' => 'required',
                'perihal' => 'required',
                'file_arsip' => 'required|mimes:pdf|max:500'
            ]);
        }
		
        if(request()->segment(1)=='arsip_surat_masuk'){
            $input['jenis'] = 1;      
            $input['disposisi'] = $request->disposisi;   
        } else {
            $input['jenis'] = 2;      
        }

        $input['no_surat'] = $request->no_surat;
        $input['tanggal'] = $request->tanggal;
        $input['perihal'] = $request->perihal;

        if($request->file('file_arsip')){
            $input['file_arsip'] = time().'.'.$request->file_arsip->getClientOriginalExtension();
            $request->file_arsip->move(public_path('upload/file_arsip'), $input['file_arsip']);
        }	
		
        $input['user_id'] = Auth::user()->id;
        Arsip::create($input);
		
		return redirect('/'.request()->segment(1))->with('status','Data Tersimpan');

    }
	
	## Tampilkan Form Edit
    public function edit(Arsip $arsip)
    {
        if(request()->segment(1)=='arsip_surat_masuk'){
            $title = "Arsip Surat Masuk";
        } else {
            $title = "Arsip Surat Keluar";
        }
        $view=view('admin.arsip.edit', compact('title','arsip'));
        $view=$view->render();
		return $view;
    }
	
	## Edit Data
    public function update(Request $request, Arsip $arsip)
    {
		if(request()->segment(1)=='arsip_surat_masuk'){
            $this->validate($request, [
                'no_surat' => 'required',
                'tanggal' => 'required',
                'perihal' => 'required',
                'disposisi' => 'required',
                'file_arsip' => 'mimes:pdf|max:500'
            ]);
        } else {
            $this->validate($request, [
                'no_surat' => 'required',
                'tanggal' => 'required',
                'perihal' => 'required',
                'file_arsip' => 'mimes:pdf|max:500'
            ]);
        }
		
        if($request->file('file_arsip') && $arsip->file_arsip){
            $pathToYourFile = public_path('upload/file_arsip/'.$arsip->file_arsip);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        $arsip->fill($request->all());
       
        if($request->file('file_arsip')){
            $filename = time().'.'.$request->file_arsip->getClientOriginalExtension();
            $request->file_arsip->move(public_path('upload/file_arsip'), $filename);
            $arsip->file_arsip = $filename;
        }
        
        $arsip->user_id = Auth::user()->id;
        $arsip->save();
    
		return redirect('/'.request()->segment(1))->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete(Arsip $arsip)
    {
        $pathToYourFile = public_path('upload/file_arsip/'.$arsip->file_arsip);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

		$arsip->delete();
		
		return redirect('/'.request()->segment(1))->with('status', 'Data Berhasil Dihapus');
    }
}
