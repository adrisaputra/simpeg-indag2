<?php

namespace App\Http\Controllers;

use App\Models\RiwayatLhkpn;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class RiwayatLhkpnController extends Controller
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

        $riwayat_lhkpn = RiwayatLhkpn::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_lhkpn.index',compact('riwayat_lhkpn','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_lhkpn = $request->get('search');

        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $riwayat_lhkpn = RiwayatLhkpn::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_lhkpn) {
                                $query->where('periode_kp', 'LIKE', '%'.$riwayat_lhkpn.'%')
                                    ->orWhere('golongan', 'LIKE', '%'.$riwayat_lhkpn.'%')
                                    ->orWhere('status', 'LIKE', '%'.$riwayat_lhkpn.'%')
                                    ->orWhere('nama_pangkat', 'LIKE', '%'.$riwayat_lhkpn.'%')
                                    ->orWhere('tmt_mulai', 'LIKE', '%'.$riwayat_lhkpn.'%')
                                    ->orWhere('tmt_selesai', 'LIKE', '%'.$riwayat_lhkpn.'%')
                                    ->orWhere('mk_tahun', 'LIKE', '%'.$riwayat_lhkpn.'%')
                                    ->orWhere('mk_bulan', 'LIKE', '%'.$riwayat_lhkpn.'%')
                                    ->orWhere('no_sk', 'LIKE', '%'.$riwayat_lhkpn.'%')
                                    ->orWhere('tanggal_sk', 'LIKE', '%'.$riwayat_lhkpn.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_lhkpn.index',compact('riwayat_lhkpn','pegawai'));
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

        $view=view('admin.riwayat_lhkpn.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'nama_lhkpn' => 'required',
            'tanggal_lapor' => 'required',
            'jenis_pelaporan' => 'required',
            'jabatan' => 'required',
            'status_laporan' => 'required',
            'arsip_lhkpn' => 'required|mimes:jpg,jpeg,png|max:500'
        ]);

        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

        $input['pegawai_id'] = $id;
        $input['nama_lhkpn'] = $request->nama_lhkpn;
        $input['tanggal_lapor'] = $request->tanggal_lapor;
        $input['jenis_pelaporan'] = $request->jenis_pelaporan;
        $input['jabatan'] = $request->jabatan;
        $input['status_laporan'] = $request->status_laporan;

		if($request->file('arsip_lhkpn')){
			// $input['arsip_lhkpn'] = time().'.'.$request->arsip_lhkpn->getClientOriginalExtension();
			// $request->arsip_lhkpn->move(public_path('upload/arsip_lhkpn'), $input['arsip_lhkpn']);

            // File information
            $uploaded_file = $request->file('arsip_lhkpn');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_lhkpn/');
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
			        $input['arsip_lhkpn'] = $target_file;
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
       
        RiwayatLhkpn::create($input);

        return redirect('/riwayat_lhkpn/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatLhkpn $riwayat_lhkpn)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $view=view('admin.riwayat_lhkpn.edit', compact('pegawai','riwayat_lhkpn'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatLhkpn $riwayat_lhkpn)
   {
        $this->validate($request, [
            'nama_lhkpn' => 'required',
            'tanggal_lapor' => 'required',
            'jenis_pelaporan' => 'required',
            'jabatan' => 'required',
            'status_laporan' => 'required',
            'arsip_lhkpn' => 'mimes:jpg,jpeg,png|max:500'
        ]);
        
        // Check Anti-CSRF token
        if (!hash_equals($request->session()->token(), $request->user_token)) {
            abort(403);
        } else {
            // Generate Anti-CSRF token
            $request->session()->regenerateToken();
        }

        if($request->file('arsip_lhkpn') && $riwayat_lhkpn->arsip_lhkpn){
            $pathToYourFile = public_path('upload/arsip_lhkpn/'.$riwayat_lhkpn->arsip_lhkpn);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_lhkpn->fill($request->all());
       
        if($request->file('arsip_lhkpn')){
            // $filename = time().'.'.$request->arsip_lhkpn->getClientOriginalExtension();
            // $request->arsip_lhkpn->move(public_path('upload/arsip_lhkpn'), $filename);
            // $riwayat_lhkpn->arsip_lhkpn = $filename;

            // File information
            $uploaded_file = $request->file('arsip_lhkpn');
            $uploaded_name = $uploaded_file->getClientOriginalName();
            $uploaded_ext = $uploaded_file->getClientOriginalExtension();
            $uploaded_size = $uploaded_file->getSize();
            $uploaded_type = $uploaded_file->getMimeType();
            $uploaded_tmp = $uploaded_file->getPathName();

            // // Where are we going to be writing to?
            $target_path = public_path('upload/arsip_lhkpn/');
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
			        $riwayat_lhkpn->arsip_lhkpn = $target_file;
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

        $riwayat_lhkpn->user_id = Auth::user()->id;
        $riwayat_lhkpn->save();
       
        return redirect('/riwayat_lhkpn/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatLhkpn $riwayat_lhkpn)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $pathToYourFile = public_path('upload/arsip_lhkpn/'.$riwayat_lhkpn->arsip_lhkpn);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

        $riwayat_lhkpn->delete();
       
        return redirect('/riwayat_lhkpn/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
