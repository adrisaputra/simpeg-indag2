<?php

namespace App\Http\Controllers;

use App\Models\RiwayatTugas;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class RiwayatTugasController extends Controller
{
     ## Cek Login
     public function __construct()
     {
         $this->middleware('auth');
     }
     
     ## Tampikan Data
     public function index($id)
     {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

         $riwayat_tugas = RiwayatTugas::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
         return view('admin.riwayat_tugas.index',compact('riwayat_tugas','pegawai'));
     }
 
     ## Tampilkan Data Search
     public function search(Request $request, $id)
     {
         $riwayat_tugas = $request->get('search');

         if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

         $riwayat_tugas = RiwayatTugas::where('pegawai_id',$id)
                             ->where(function ($query) use ($riwayat_tugas) {
                                 $query->where('keterangan', 'LIKE', '%'.$riwayat_tugas.'%')
                                     ->orWhere('tingkat', 'LIKE', '%'.$riwayat_tugas.'%')
                                     ->orWhere('negara', 'LIKE', '%'.$riwayat_tugas.'%')
                                     ->orWhere('provinsi', 'LIKE', '%'.$riwayat_tugas.'%')
                                     ->orWhere('fakultas', 'LIKE', '%'.$riwayat_tugas.'%')
                                     ->orWhere('jurusan', 'LIKE', '%'.$riwayat_tugas.'%')
                                     ->orWhere('tmt_mulai', 'LIKE', '%'.$riwayat_tugas.'%')
                                     ->orWhere('tmt_selesai', 'LIKE', '%'.$riwayat_tugas.'%')
                                     ->orWhere('no_surat', 'LIKE', '%'.$riwayat_tugas.'%')
                                     ->orWhere('tanggal_izin', 'LIKE', '%'.$riwayat_tugas.'%');
                             })
                             ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
         return view('admin.riwayat_tugas.index',compact('riwayat_tugas','pegawai'));
     }
 
    ## Tampilkan Form Create
    public function create($id)
    {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

         $view=view('admin.riwayat_tugas.create',compact('pegawai'));
         $view=$view->render();
         return $view;
    }
 
    ## Simpan Data
    public function store($id, Request $request)
    {
         $this->validate($request, [
             'keterangan' => 'required',
             'tingkat' => 'required',
             'negara' => 'required',
             'provinsi' => 'required',
             'fakultas' => 'required',
             'jurusan' => 'required',
             'tmt_mulai' => 'required',
             'tmt_selesai' => 'required',
             'no_surat' => 'required',
             'tanggal_izin' => 'required',
             'arsip_tugas' => 'required|mimes:jpg,jpeg,png|max:500'
         ]);
 
        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

         $input['pegawai_id'] = $id;
         $input['keterangan'] = $request->keterangan;
         $input['tingkat'] = $request->tingkat;
         $input['negara'] = $request->negara;
         $input['provinsi'] = $request->provinsi;
         $input['fakultas'] = $request->fakultas;
         $input['jurusan'] = $request->jurusan;
         $input['tmt_mulai'] = $request->tmt_mulai;
         $input['tmt_selesai'] = $request->tmt_selesai;
         $input['no_surat'] = $request->no_surat;
         $input['tanggal_izin'] = $request->tanggal_izin;
         
         if($request->file('arsip_tugas')){
            //  $input['arsip_tugas'] = time().'.'.$request->arsip_tugas->getClientOriginalExtension();
            //  $request->arsip_tugas->move(public_path('upload/arsip_tugas'), $input['arsip_tugas']);
            // File information
            $uploaded_file = $request->file('arsip_tugas');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_tugas/');
            $encrypt = Hash::make($uploaded_name);
            $target_file = md5(uniqid() . $encrypt) . '.' . $uploaded_ext;
            $temp_file = sys_get_temp_dir() . '/' . md5(uniqid() . $encrypt) . '.' . $uploaded_ext;

            // // Is it an image?
            if (( strtolower( $uploaded_ext ) == 'jpg' || strtolower( $uploaded_ext ) == 'jpeg' || strtolower( $uploaded_ext ) == 'png' ) &&
                ($uploaded_size <= 500000) &&
                ($uploaded_type == 'image/jpeg' || $uploaded_type == 'image/png') &&
                getimagesize($uploaded_tmp)) {

                // Strip any metadata, by re-encoding image
                if ($uploaded_type == 'image/jpeg') {
                    $img = imagecreatefromjpeg($uploaded_tmp);
                    imagejpeg($img, $temp_file, 100);
                } else {
                    $img = imagecreatefrompng($uploaded_tmp);
                    imagepng($img, $temp_file, 9);
                }
                imagedestroy($img);

                // Can we move the file to the web root from the temp folder?
                if (rename($temp_file, ($target_path . $target_file))) {
                    // Yes!
                    // echo "<pre><a href='${target_path}${target_file}'>${target_path}${target_file}</a> succesfully uploaded!</pre>";
			        $input['arsip_tugas'] = $target_file;
                } else {
                    // No
                    echo '<pre>Your image was not uploaded.</pre>';
                }

                // Delete any temp files
                if (file_exists($temp_file)) {
                    unlink($temp_file);
                }
            } else {
                // Invalid file
                echo '<pre>Your image was not uploaded. We can only accept JPEG or PNG images.</pre>';
            }
         }	
         
         $input['user_id'] = Auth::user()->id;
        
         RiwayatTugas::create($input);
 
         return redirect('/riwayat_tugas/'.$id)->with('status','Data Tersimpan');
    }
 
    ## Tampilkan Form Edit
    public function edit($id, RiwayatTugas $riwayat_tugas)
    {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

         $view=view('admin.riwayat_tugas.edit', compact('pegawai','riwayat_tugas'));
         $view=$view->render();
         return $view;
    }
 
    ## Edit Data
    public function update(Request $request, $id, RiwayatTugas $riwayat_tugas)
    {
        $this->validate($request, [
            'keterangan' => 'required',
            'tingkat' => 'required',
            'negara' => 'required',
            'provinsi' => 'required',
            'fakultas' => 'required',
            'jurusan' => 'required',
            'tmt_mulai' => 'required',
            'tmt_selesai' => 'required',
            'no_surat' => 'required',
            'tanggal_izin' => 'required',
            'arsip_tugas' => 'mimes:jpg,jpeg,png|max:500'
        ]);
         
        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

         if($request->file('arsip_tugas') && $riwayat_tugas->arsip_tugas){
             $pathToYourFile = public_path('upload/arsip_tugas/'.$riwayat_tugas->arsip_tugas);
             if(file_exists($pathToYourFile))
             {
                 unlink($pathToYourFile);
             }
         }
 
         $riwayat_tugas->fill($request->all());
        
         if($request->file('arsip_tugas')){
            //  $filename = time().'.'.$request->arsip_tugas->getClientOriginalExtension();
            //  $request->arsip_tugas->move(public_path('upload/arsip_tugas'), $filename);
            //  $riwayat_tugas->arsip_tugas = $filename;

            // File information
            $uploaded_file = $request->file('arsip_tugas');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_tugas/');
            $encrypt = Hash::make($uploaded_name);
            $target_file = md5(uniqid() . $encrypt) . '.' . $uploaded_ext;
            echo  $target_file;
            $temp_file = sys_get_temp_dir() . '/' . md5(uniqid() . $encrypt) . '.' . $uploaded_ext;

            // // Is it an image?
            if (( strtolower( $uploaded_ext ) == 'jpg' || strtolower( $uploaded_ext ) == 'jpeg' || strtolower( $uploaded_ext ) == 'png' ) &&
                ($uploaded_size <= 500000) &&
                ($uploaded_type == 'image/jpeg' || $uploaded_type == 'image/png') &&
                getimagesize($uploaded_tmp)) {

                // Strip any metadata, by re-encoding image
                if ($uploaded_type == 'image/jpeg') {
                    $img = imagecreatefromjpeg($uploaded_tmp);
                    imagejpeg($img, $temp_file, 100);
                } else {
                    $img = imagecreatefrompng($uploaded_tmp);
                    imagepng($img, $temp_file, 9);
                }
                imagedestroy($img);

                // Can we move the file to the web root from the temp folder?
                if (rename($temp_file, ($target_path . $target_file))) {
                    // Yes!
                    // echo "<pre><a href='${target_path}${target_file}'>${target_path}${target_file}</a> succesfully uploaded!</pre>";
			        $riwayat_tugas->arsip_tugas = $target_file;
                } else {
                    // No
                    echo '<pre>Your image was not uploaded.</pre>';
                }

                // Delete any temp files
                if (file_exists($temp_file)) {
                    unlink($temp_file);
                }
            } else {
                // Invalid file
                echo '<pre>Your image was not uploaded. We can only accept JPEG or PNG images.</pre>';
            }
         }
 
         $riwayat_tugas->user_id = Auth::user()->id;
         $riwayat_tugas->save();
        
         return redirect('/riwayat_tugas/'.$id)->with('status', 'Data Berhasil Diubah');
    }
 
    ## Hapus Data
    public function delete($id, RiwayatTugas $riwayat_tugas)
    {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

         $pathToYourFile = public_path('upload/arsip_tugas/'.$riwayat_tugas->arsip_tugas);
         if(file_exists($pathToYourFile))
         {
             unlink($pathToYourFile);
         }
 
         $riwayat_tugas->delete();
        
         return redirect('/riwayat_tugas/'.$id)->with('status', 'Data Berhasil Dihapus');
    }
}
