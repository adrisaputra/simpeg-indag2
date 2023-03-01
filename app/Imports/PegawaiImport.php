<?php

namespace App\Imports;

use App\Models\Pegawai;
use App\Models\RiwayatKepangkatan;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Hash;

class PegawaiImport implements ToCollection
{
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) 
        {
            if($row[9]=="Golongan I/a"){
                $jenis_golongan = 1;
                $nama_pangkat = 'Juru Muda';
            } else if($row[9]=="Golongan I/b"){
                $jenis_golongan = 2;
                $nama_pangkat = 'Juru Muda  Tingkat 1';
            } else if($row[9]=="Golongan I/c"){
                $jenis_golongan = 3;
                $nama_pangkat = 'Juru';
            } else if($row[9]=="Golongan I/d"){
                $jenis_golongan = 4;
                $nama_pangkat = 'Juru Tingkat 1';
            } else if($row[9]=="Golongan II/a"){
                $jenis_golongan = 5;
                $nama_pangkat = 'Pengatur Muda';
            } else if($row[9]=="Golongan II/b"){
                $jenis_golongan = 6;
                $nama_pangkat = 'Pengatur Muda Tingkat 1';
            } else if($row[9]=="Golongan II/c"){
                $jenis_golongan = 7;
                $nama_pangkat = 'Pengatur';
            } else if($row[9]=="Golongan II/d"){
                $jenis_golongan = 8;
                $nama_pangkat = 'Pengatur Tingkat 1';
            } else if($row[9]=="Golongan III/a"){
                $jenis_golongan = 9;
                $nama_pangkat = 'Penata Muda';
            } else if($row[9]=="Golongan III/b"){
                $jenis_golongan = 10;
                $nama_pangkat = 'Penata Muda Tingkat 1';
            } else if($row[9]=="Golongan III/c"){
                $jenis_golongan = 11;
                $nama_pangkat = 'Penata';
            } else if($row[9]=="Golongan III/d"){
                $jenis_golongan = 12;
                $nama_pangkat = 'Penata Tingkat 1';
            } else if($row[9]=="Golongan IV/a"){
                $jenis_golongan = 13;
                $nama_pangkat = 'Pembina';
            } else if($row[9]=="Golongan IV/b"){
                $jenis_golongan = 14;
                $nama_pangkat = 'Pembina Tingkat 1';
            } else if($row[9]=="Golongan IV/c"){
                $jenis_golongan = 15;
                $nama_pangkat = 'Pembina Utama Muda';
            } else if($row[9]=="Golongan IV/d"){
                $jenis_golongan = 16;
                $nama_pangkat = 'Pembina Utama Madya';
            }  else if($row[9]=="Golongan IV/e"){
                $jenis_golongan = 17;
                $nama_pangkat = 'Pembina Utama';
            }   
            
            Pegawai::create([
                'nip' => $row[0],
                'nama_pegawai' => $row[1],
                'tanggal_lahir' => Date::excelToDateTimeObject($row[2]),
                'jenis_kelamin' => $row[3],
                'jabatan_id' => $row[4],
                'bidang_id' => $row[5],
                'seksi_id' => $row[6],
                'status' => $row[7],
                'agama' => $row[8],
                'golongan' => $row[9],
            ]);

            RiwayatKepangkatan::create([
                'pegawai_id' => $row[10],
                'golongan' => $row[9],
                'jenis_golongan' =>  $jenis_golongan,
                'nama_pangkat' => $nama_pangkat
            ]);

            User::create([
                'name' => $row[0],
                'email' => $row[0].'@gmail.com',
                'password' =>  Hash::make($row[0]),
                'group' => 3
            ]);
        }

    }
}
