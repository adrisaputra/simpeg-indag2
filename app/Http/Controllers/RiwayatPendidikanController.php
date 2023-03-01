<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPendidikan;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class RiwayatPendidikanController extends Controller
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

        $riwayat_pendidikan = RiwayatPendidikan::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_pendidikan.index',compact('riwayat_pendidikan','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_pendidikan = $request->get('search');

        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $riwayat_pendidikan = RiwayatPendidikan::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_pendidikan) {
                                $query->where('tingkat', 'LIKE', '%'.$riwayat_pendidikan.'%')
                                    ->orWhere('lembaga', 'LIKE', '%'.$riwayat_pendidikan.'%')
                                    ->orWhere('jurusan', 'LIKE', '%'.$riwayat_pendidikan.'%')
                                    ->orWhere('no_sttb', 'LIKE', '%'.$riwayat_pendidikan.'%')
                                    ->orWhere('tanggal_sttb', 'LIKE', '%'.$riwayat_pendidikan.'%')
                                    ->orWhere('tanggal_kelulusan', 'LIKE', '%'.$riwayat_pendidikan.'%')
                                    ->orWhere('tanggal_kelulusan', 'LIKE', '%'.$riwayat_pendidikan.'%')
                                    ->orWhere('ipk', 'LIKE', '%'.$riwayat_pendidikan.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_pendidikan.index',compact('riwayat_pendidikan','pegawai'));
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

        $view=view('admin.riwayat_pendidikan.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'tingkat' => 'required',
            'lembaga' => 'required',
            'arsip_ijazah' => 'required|mimes:jpg,jpeg,png|max:500',
            'arsip_transkrip_nilai' => 'required|mimes:jpg,jpeg,png|max:500'
        ]);

        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

        $input['pegawai_id'] = $id;
        if($request->tingkat=="SD"){
            $input['jenis_pendidikan'] = 1;
        } else if($request->tingkat=="SLTP"){
            $input['jenis_pendidikan'] = 2;
        } else if($request->tingkat=="SLTP Kejuruan"){
            $input['jenis_pendidikan'] = 3;
        } else if($request->tingkat=="SLTA"){
            $input['jenis_pendidikan'] = 4;
        } else if($request->tingkat=="SLTA Kejuruan"){
            $input['jenis_pendidikan'] = 5;
        } else if($request->tingkat=="SLTA Keguruan"){
            $input['jenis_pendidikan'] = 6;
        } else if($request->tingkat=="Diploma I"){
            $input['jenis_pendidikan'] = 7;
        } else if($request->tingkat=="Diploma II"){
            $input['jenis_pendidikan'] = 8;
        } else if($request->tingkat=="Diploma III / Sarjana Muda"){
            $input['jenis_pendidikan'] = 9;
        } else if($request->tingkat=="Diploma IV"){
            $input['jenis_pendidikan'] = 10;
        } else if($request->tingkat=="S1 / Sarjana"){
            $input['jenis_pendidikan'] = 11;
        } else if($request->tingkat=="S2"){
            $input['jenis_pendidikan'] = 12;
        } else if($request->tingkat=="S3 / Doktor"){
            $input['jenis_pendidikan'] = 13;
        }   

        $input['tingkat'] = $request->tingkat;
        $input['lembaga'] = $request->lembaga;
        $input['fakultas'] = $request->fakultas;
        $input['jurusan'] = $request->jurusan;
        $input['no_sttb'] = $request->no_sttb;
        $input['tanggal_sttb'] = $request->tanggal_sttb;
        $input['tanggal_kelulusan'] = $request->tanggal_kelulusan;
        $input['ipk'] = $request->ipk;
        
		if($request->file('arsip_ijazah')){
			// $input['arsip_ijazah'] = time().'.'.$request->arsip_ijazah->getClientOriginalExtension();
			// $request->arsip_ijazah->move(public_path('upload/arsip_ijazah'), $input['arsip_ijazah']);

            // File information
            $uploaded_file = $request->file('arsip_ijazah');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_ijazah/');
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
			        $input['arsip_ijazah'] = $target_file;
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
		
		if($request->file('arsip_transkrip_nilai')){
			// $input['arsip_transkrip_nilai'] = time().'.'.$request->arsip_transkrip_nilai->getClientOriginalExtension();
			// $request->arsip_transkrip_nilai->move(public_path('upload/arsip_transkrip_nilai'), $input['arsip_transkrip_nilai']);

            // File information
            $uploaded_file = $request->file('arsip_transkrip_nilai');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_transkrip_nilai/');
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
			        $input['arsip_transkrip_nilai'] = $target_file;
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
       
        RiwayatPendidikan::create($input);

        $pendidikan = RiwayatPendidikan::where('pegawai_id',$id)->orderBy('jenis_pendidikan','DESC')->limit(1)->get();
        $pendidikan->toArray();
        
        $pegawai = Pegawai::find($id);
        $pegawai->pendidikan = $pendidikan[0]->tingkat;
        $pegawai->save();
        
        return redirect('/riwayat_pendidikan/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatPendidikan $riwayat_pendidikan)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $view=view('admin.riwayat_pendidikan.edit', compact('pegawai','riwayat_pendidikan'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatPendidikan $riwayat_pendidikan)
   {
        $this->validate($request, [
            'tingkat' => 'required',
            'lembaga' => 'required',
            'arsip_ijazah' => 'mimes:jpg,jpeg,png|max:500',
            'arsip_transkrip_nilai' => 'mimes:jpg,jpeg,png|max:500'
        ]);
        
        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

        if($request->file('arsip_ijazah') && $riwayat_pendidikan->arsip_ijazah){
            $pathToYourFile = public_path('upload/arsip_ijazah/'.$riwayat_pendidikan->arsip_ijazah);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        if($request->file('arsip_transkrip_nilai') && $riwayat_pendidikan->arsip_transkrip_nilai){
            $pathToYourFile = public_path('upload/arsip_transkrip_nilai/'.$riwayat_pendidikan->arsip_transkrip_nilai);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_pendidikan->fill($request->all());
       
        if($request->tingkat=="SD"){
            $riwayat_pendidikan->jenis_pendidikan = 1;
        } else if($request->tingkat=="SLTP"){
            $riwayat_pendidikan->jenis_pendidikan = 2;
        } else if($request->tingkat=="SLTP Kejuruan"){
            $riwayat_pendidikan->jenis_pendidikan = 3;
        } else if($request->tingkat=="SLTA"){
            $riwayat_pendidikan->jenis_pendidikan = 4;
        } else if($request->tingkat=="SLTA Kejuruan"){
            $riwayat_pendidikan->jenis_pendidikan = 5;
        } else if($request->tingkat=="SLTA Keguruan"){
            $riwayat_pendidikan->jenis_pendidikan = 6;
        } else if($request->tingkat=="Diploma I"){
            $riwayat_pendidikan->jenis_pendidikan = 7;
        } else if($request->tingkat=="Diploma II"){
            $riwayat_pendidikan->jenis_pendidikan = 8;
        } else if($request->tingkat=="Diploma III / Sarjana Muda"){
            $riwayat_pendidikan->jenis_pendidikan = 9;
        } else if($request->tingkat=="Diploma IV"){
            $riwayat_pendidikan->jenis_pendidikan = 10;
        } else if($request->tingkat=="S1 / Sarjana"){
            $riwayat_pendidikan->jenis_pendidikan = 11;
        } else if($request->tingkat=="S2"){
            $riwayat_pendidikan->jenis_pendidikan = 12;
        } else if($request->tingkat=="S3 / Doktor"){
            $riwayat_pendidikan->jenis_pendidikan = 13;
        }   
        
        if($request->file('arsip_ijazah')){
            // $filename = time().'.'.$request->arsip_ijazah->getClientOriginalExtension();
            // $request->arsip_ijazah->move(public_path('upload/arsip_ijazah'), $filename);
            // $riwayat_pendidikan->arsip_ijazah = $filename;
            // File information
            $uploaded_file = $request->file('arsip_ijazah');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_ijazah/');
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
			        $riwayat_pendidikan->arsip_ijazah = $target_file;
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

        if($request->file('arsip_transkrip_nilai')){
            // $filename = time().'.'.$request->arsip_transkrip_nilai->getClientOriginalExtension();
            // $request->arsip_transkrip_nilai->move(public_path('upload/arsip_transkrip_nilai'), $filename);
            // $riwayat_pendidikan->arsip_transkrip_nilai = $filename;
            // File information
            $uploaded_file = $request->file('arsip_transkrip_nilai');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_transkrip_nilai/');
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
			        $riwayat_pendidikan->arsip_transkrip_nilai = $target_file;
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

        $riwayat_pendidikan->user_id = Auth::user()->id;
        $riwayat_pendidikan->save();
       
        $pendidikan = RiwayatPendidikan::where('pegawai_id',$id)->orderBy('jenis_pendidikan','DESC')->limit(1)->get();
        $pendidikan->toArray();
        
        $pegawai = Pegawai::find($id);
        $pegawai->pendidikan = $pendidikan[0]->tingkat;
    	$pegawai->save();

        return redirect('/riwayat_pendidikan/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatPendidikan $riwayat_pendidikan)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $pathToYourFile = public_path('upload/arsip_ijazah/'.$riwayat_pendidikan->arsip_ijazah);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

        $pathToYourFile2 = public_path('upload/arsip_transkrip_nilai/'.$riwayat_pendidikan->arsip_transkrip_nilai);
        if(file_exists($pathToYourFile2))
        {
            unlink($pathToYourFile2);
        }

        $riwayat_pendidikan->delete();
       
        $pendidikan = RiwayatPendidikan::where('pegawai_id',$id)->orderBy('jenis_pendidikan','DESC')->limit(1)->get();
        $pendidikan->toArray();
        
        if($pendidikan){
            $pegawai = Pegawai::find($id);
            $pegawai->pendidikan = $pendidikan[0]->tingkat;
        } else {
            $pegawai = Pegawai::find($id);
            $pegawai->pendidikan = '';
        }
        
    	$pegawai->save();

        return redirect('/riwayat_pendidikan/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
