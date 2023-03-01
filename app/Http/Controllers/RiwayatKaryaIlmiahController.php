<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKaryaIlmiah;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class RiwayatKaryaIlmiahController extends Controller
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

        $riwayat_karya_ilmiah = RiwayatKaryaIlmiah::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_karya_ilmiah.index',compact('riwayat_karya_ilmiah','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_karya_ilmiah = $request->get('search');

        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $riwayat_karya_ilmiah = RiwayatKaryaIlmiah::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_karya_ilmiah) {
                                $query->where('jenis_buku', 'LIKE', '%'.$riwayat_karya_ilmiah.'%')
                                    ->orWhere('judul_buku', 'LIKE', '%'.$riwayat_karya_ilmiah.'%')
                                    ->orWhere('jenis_kegiatan', 'LIKE', '%'.$riwayat_karya_ilmiah.'%')
                                    ->orWhere('peranan', 'LIKE', '%'.$riwayat_karya_ilmiah.'%')
                                    ->orWhere('tahun', 'LIKE', '%'.$riwayat_karya_ilmiah.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_karya_ilmiah.index',compact('riwayat_karya_ilmiah','pegawai'));
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

        $view=view('admin.riwayat_karya_ilmiah.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'jenis_buku' => 'required',
            'judul_buku' => 'required',
            'jenis_kegiatan' => 'required',
            'peranan' => 'required',
            'tahun' => 'required|numeric',
            'arsip_karya_ilmiah' => 'required|mimes:jpg,jpeg,png,|max:500'
        ]);

        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

        $input['pegawai_id'] = $id;
        $input['jenis_buku'] = $request->jenis_buku;
        $input['judul_buku'] = $request->judul_buku;
        $input['jenis_kegiatan'] = $request->jenis_kegiatan;
        $input['peranan'] = $request->peranan;
        $input['tahun'] = $request->tahun;
        
        if($request->file('arsip_karya_ilmiah')){
            // $input['arsip_karya_ilmiah'] = time().'.'.$request->arsip_karya_ilmiah->getClientOriginalExtension();
            // $request->arsip_karya_ilmiah->move(public_path('upload/arsip_karya_ilmiah'), $input['arsip_karya_ilmiah']);

            // File information
            $uploaded_file = $request->file('arsip_karya_ilmiah');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_karya_ilmiah/');
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
			        $input['arsip_karya_ilmiah'] = $target_file;
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
       
        RiwayatKaryaIlmiah::create($input);

        return redirect('/riwayat_karya_ilmiah/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatKaryaIlmiah $riwayat_karya_ilmiah)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $view=view('admin.riwayat_karya_ilmiah.edit', compact('pegawai','riwayat_karya_ilmiah'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatKaryaIlmiah $riwayat_karya_ilmiah)
   {
        $this->validate($request, [
            'jenis_buku' => 'required',
            'judul_buku' => 'required',
            'jenis_kegiatan' => 'required',
            'peranan' => 'required',
            'tahun' => 'required|numeric',
            'arsip_karya_ilmiah' => 'mimes:jpg,jpeg,png|max:500'
        ]);
        
        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

        if($request->file('arsip_karya_ilmiah') && $riwayat_karya_ilmiah->arsip_karya_ilmiah){
            $pathToYourFile = public_path('upload/arsip_karya_ilmiah/'.$riwayat_karya_ilmiah->arsip_karya_ilmiah);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        $riwayat_karya_ilmiah->fill($request->all());
       
        if($request->file('arsip_karya_ilmiah')){
            // $filename = time().'.'.$request->arsip_karya_ilmiah->getClientOriginalExtension();
            // $request->arsip_karya_ilmiah->move(public_path('upload/arsip_karya_ilmiah'), $filename);
            // $riwayat_karya_ilmiah->arsip_karya_ilmiah = $filename;
             // File information
             $uploaded_file = $request->file('arsip_karya_ilmiah');
             $uploaded_name = $uploaded_file->getClientOriginalName();
             $uploaded_ext = $uploaded_file->getClientOriginalExtension();
             $uploaded_size = $uploaded_file->getSize();
             $uploaded_type = $uploaded_file->getMimeType();
             $uploaded_tmp = $uploaded_file->getPathName();
 
             // // Where are we going to be writing to?
             $target_path = public_path('upload/arsip_karya_ilmiah/');
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
                     $riwayat_karya_ilmiah->arsip_karya_ilmiah = $target_file;
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

        $riwayat_karya_ilmiah->user_id = Auth::user()->id;
        $riwayat_karya_ilmiah->save();
       
        return redirect('/riwayat_karya_ilmiah/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatKaryaIlmiah $riwayat_karya_ilmiah)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $pathToYourFile = public_path('upload/arsip_karya_ilmiah/'.$riwayat_karya_ilmiah->arsip_karya_ilmiah);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

        $riwayat_karya_ilmiah->delete();
       
        return redirect('/riwayat_karya_ilmiah/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
