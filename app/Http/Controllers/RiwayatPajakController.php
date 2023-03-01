<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPajak;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class RiwayatPajakController extends Controller
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

        $riwayat_pajak = RiwayatPajak::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_pajak.index',compact('riwayat_pajak','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_pajak = $request->get('search');

        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $riwayat_pajak = RiwayatPajak::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_pajak) {
                                $query->where('nama_pajak', 'LIKE', '%'.$riwayat_pajak.'%')
                                    ->orWhere('tempat', 'LIKE', '%'.$riwayat_pajak.'%')
                                    ->orWhere('penyelenggara', 'LIKE', '%'.$riwayat_pajak.'%')
                                    ->orWhere('no_sertifikat', 'LIKE', '%'.$riwayat_pajak.'%')
                                    ->orWhere('tanggal_sertifikat', 'LIKE', '%'.$riwayat_pajak.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_pajak.index',compact('riwayat_pajak','pegawai'));
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

        $view=view('admin.riwayat_pajak.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'no_npwp' => 'required',
            'jenis_spt' => 'required',
            'tahun' => 'required|numeric',
            'pembetulan' => 'required|numeric',
            'status' => 'required',
            'jumlah' => 'required|numeric',
            'arsip_spt' => 'required|mimes:jpg,jpeg,png|max:500'
        ]);

        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

       $input['pegawai_id'] = $id;
       $input['no_npwp'] = $request->no_npwp;
       $input['jenis_spt'] = $request->jenis_spt;
       $input['tahun'] = $request->tahun;
       $input['pembetulan'] = $request->pembetulan;
       $input['status'] = $request->status;
       $input['jumlah'] = $request->jumlah;
       
       if($request->file('arsip_spt')){
            // $input['arsip_spt'] = time().'.'.$request->arsip_spt->getClientOriginalExtension();
            // $request->arsip_spt->move(public_path('upload/arsip_spt'), $input['arsip_spt']);
            // File information
            $uploaded_file = $request->file('arsip_spt');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_spt/');
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
			        $input['arsip_spt'] = $target_file;
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
    
        RiwayatPajak::create($input);

        return redirect('/riwayat_pajak/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatPajak $riwayat_pajak)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $view=view('admin.riwayat_pajak.edit', compact('pegawai','riwayat_pajak'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatPajak $riwayat_pajak)
   {
        $this->validate($request, [
            'no_npwp' => 'required',
            'jenis_spt' => 'required',
            'tahun' => 'required|numeric',
            'pembetulan' => 'required|numeric',
            'status' => 'required',
            'jumlah' => 'required|numeric',
            'arsip_spt' => 'mimes:jpg,jpeg,png|max:500'
        ]);

        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

        if($request->file('arsip_spt') && $riwayat_pajak->arsip_spt){
            $pathToYourFile = public_path('upload/arsip_spt/'.$riwayat_pajak->arsip_spt);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        $riwayat_pajak->fill($request->all());
       
        if($request->file('arsip_spt')){
            // $filename = time().'.'.$request->arsip_spt->getClientOriginalExtension();
            // $request->arsip_spt->move(public_path('upload/arsip_spt'), $filename);
            // $riwayat_pajak->arsip_spt = $filename;

            // File information
            $uploaded_file = $request->file('arsip_spt');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_spt/');
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
			        $riwayat_pajak->arsip_spt = $target_file;
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
        
        $riwayat_pajak->user_id = Auth::user()->id;
        $riwayat_pajak->save();
    
        return redirect('/riwayat_pajak/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatPajak $riwayat_pajak)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $pathToYourFile = public_path('upload/arsip_spt/'.$riwayat_pajak->arsip_spt);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }
        $riwayat_pajak->delete();
       
        return redirect('/riwayat_pajak/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
