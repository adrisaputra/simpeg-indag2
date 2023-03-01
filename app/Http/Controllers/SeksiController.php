<?php

namespace App\Http\Controllers;

use App\Models\RelasiBidang;   //nama model
use App\Models\Seksi;   //nama model
use Illuminate\Http\Request;

class SeksiController extends Controller
{
    public function nama_seksi($bidang_id)
    {
        $seksi = Seksi::
                  where('bidang_id',$bidang_id)
                  ->orderBy('id','ASC')->get();

        echo "<option value=''> -PILIH SEKSI-</option>";
        foreach($seksi as $v){
            echo "<option value='".$v->id."'>".$v->nama_seksi."</option>";
        }
    }
}
