<html>
<head>
	<title>CV {{ $pegawai[0]->nama_pegawai }}</title>
</head>
<style type="text/css">
		/* table tr td,
		table tr th{
			font-size: 9pt;
		} */
		table {
			border-collapse: collapse;
			border-spacing: 0;
			}
		table {
		background-color: transparent;
		}
		table col[class*="col-"] {
		position: static;
		display: table-column;
		float: none;
		}
		table td[class*="col-"],
		table th[class*="col-"] {
		position: static;
		display: table-cell;
		float: none;
		}
		.table {
		width: 100%;
		max-width: 100%;
		margin-bottom: 20px;
		}
		.table > thead > tr > th,
		.table > tbody > tr > th,
		.table > tfoot > tr > th,
		.table > thead > tr > td,
		.table > tbody > tr > td,
		.table > tfoot > tr > td {
		padding: 3px;
		line-height: 1.42857143;
		vertical-align: top;
		border-top: 1px solid #ddd;
		}
		.table > tbody + tbody {
		border-top: 2px solid #ddd;
		}
		.table .table {
		background-color: #fff;
		}
		
		.table-bordered {
		border: 1px solid #ddd;
		}
		
		.table-striped > tbody > tr:nth-of-type(odd) {
		background-color: #f9f9f9;
		}
		.table-bordered > thead > tr > th,
		.table-bordered > tbody > tr > th,
		.table-bordered > tfoot > tr > th,
		.table-bordered > thead > tr > td,
		.table-bordered > tbody > tr > td,
		.table-bordered > tfoot > tr > td {
		/* border: 1px solid #f4f4f4; */
		border: 1px solid #e1e1e1;
		}
		html {
			font-family: sans-serif;
		-ms-text-size-adjust: 100%;
		-webkit-text-size-adjust: 100%;
		}
	</style>
	<style>
		.page-break {
		page-break-after: always;
		}
		.page-break2 {
		page-break-after: avoid;
		}
	</style>
<body>
	
	<center>
		@if($pegawai[0]->foto_formal)
			<img src="{{ asset('storage/upload/foto_formal_pegawai/thumbnail/'.$pegawai[0]->foto_formal) }}" class="img-circle" alt="User Image"  width="150px" height="150px">
		@else
			<img src="{{ asset('upload/user/15.jpg') }}" class="img-circle" alt="User Image" width="150px" height="150px">
		@endif
		<br>
		<p style="font-size:20px;font-weight:bold">{{ $pegawai[0]->nama_pegawai }}</p>
		<p style="font-size:16px;font-weight:bold">{{ $pegawai[0]->nip }}</p>
	</center>
	<table class="table table-bordered" style="width : 100%; padding-top: -10px; height: 10px" >
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:14px" colspan=2>DATA PRIBADI</th>
		</tr>
		<tr>
			<th style="width: 200px;text-align:left">Tempat Tanggal Lahir</th>
			<td> {{ $pegawai[0]->tempat_lahir }}, {{ date('d-m-Y', strtotime($pegawai[0]->tanggal_lahir)) }}</td>
		</tr>
		<tr>
			<th style="width: 200px;text-align:left">Jenis Kelamin</th>
			<td> {{ $pegawai[0]->jenis_kelamin}}</td>
		</tr>
		<tr>
			<th style="width: 200px;text-align:left">Alamat</th>
			<td> {{ $pegawai[0]->alamat}}</td>
		</tr>
		<tr>
			<th style="width: 200px;text-align:left">Agama</th>
			<td> {{ $pegawai[0]->agama}}</td>
		</tr>
		<tr>
			<th style="width: 200px;text-align:left">Gol. Darah</th>
			<td> {{ $pegawai[0]->gol_darah}}</td>
		</tr>
		<tr>
			<th style="width: 200px;text-align:left">Email</th>
			<td> {{ $pegawai[0]->email}}</td>
		</tr>
		<tr>
			<th style="width: 200px;text-align:left">No. KTP</th>
			<td> {{ $pegawai[0]->no_ktp}}</td>
		</tr>
		<tr>
			<th style="width: 200px;text-align:left">No. BPJS</th>
			<td> {{ $pegawai[0]->no_bpjs}}</td>
		</tr>
		<tr>
			<th style="width: 200px;text-align:left">Nomor NPWP</th>
			<td> {{ $pegawai[0]->no_npwp }} </td>
		</tr>
		<tr>
			<th style="width: 200px;text-align:left">Nomor Karpeg</th>
			<td> {{ $pegawai[0]->no_karpeg }} </td>
		</tr>
		<tr>
			<th style="width: 200px;text-align:left">No. Karsu/Karis</th>
			<td> {{ $pegawai[0]->no_karsu }} </td>
		</tr>
		<tr>
			<th style="width: 200px;text-align:left">Golongan</th>
			<td> {{ $pegawai[0]->golongan }}</td>
		</tr>
		<tr>
			<th style="width: 200px;text-align:left">Pendidikan</th>
			<td> {{ $pegawai[0]->pendidikan }}</td>
		</tr>
		<tr>
			<th style="width: 200px;text-align:left">Status Kepegawaian</th>
			<td> {{ $pegawai[0]->status }}</td>
		</tr>
	</table>

	<div class="page-break"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=5>DATA RIWAYAT JABATAN</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Uraian jabatan</th>
			<th>Tipe Jabatan</th>
			<th>TMT Mulai</th>
			<th>TMT Akhir</th>
			<th>No SK</th>
		</tr>
		@if(count($riwayat_jabatan)>0)
			@foreach($riwayat_jabatan as $v)
			<tr>
				<td>{{ $v->jabatan }}</td>
				<td>{{ $v->tipe_jabatan }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tmt_mulai)) }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tmt_selesai)) }}</td>
				<td>{{ $v->no_sk }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=5><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=4>DATA RIWAYAT ANGKA KREDIT</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Nomor PAK</th>
			<th>Tanggal PAK</th>
			<th>Jumlah AK</th>
			<th>TMT AK</th>
		</tr>
		@if(count($riwayat_angka_kredit)>0)
			@foreach($riwayat_angka_kredit as $v)
			<tr>
				<td>{{ $v->no_pak }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tanggal_pak)) }}</td>
				<td>{{ $v->jumlah }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tmt_angka_kredit)) }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=4><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=5>DATA RIWAYAT KEPANGKATAN</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Golongan</th>
			<th>Pangkat</th>
			<th>TMT</th>
			<th>No. SK</th>
			<th>Pejabat Yang Menetapkan</th>
		</tr>
		@if(count($riwayat_kepangkatan)>0)
			@foreach($riwayat_kepangkatan as $v)
			<tr>
				<td>{{ $v->golongan }}</td>
				<td>{{ $v->nama_pangkat }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tmt)) }}</td>
				<td>{{ $v->no_sk }}</td>
				<td>{{ $v->pejabat }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=5><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=5>DATA RIWAYAT LHKPN</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Nama</th>
			<th>Tanggal Lapor</th>
			<th>Jenis Pelaporan</th>
			<th>Jabatan</th>
			<th>Status Laporan</th>
		</tr>
		@if(count($riwayat_lhkpn)>0)
			@foreach($riwayat_lhkpn as $v)
			<tr>
				<td>{{ $v->nama_lhkpn }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tanggal_lapor)) }}</td>
				<td>{{ $v->jenis_pelaporan }}</td>
				<td>{{ $v->jabatan }}</td>
				<td>{{ $v->status_laporan }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=5><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=4>DATA RIWAYAT KOMPETENSI</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Nama Kegiatan</th>
			<th>Tanggal</th>
			<th>Tempat</th>
			<th>Angkatan</th>
		</tr>
		@if(count($riwayat_kompetensi)>0)
			@foreach($riwayat_kompetensi as $v)
			<tr>
				<td>{{ $v->nama_kegiatan }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tanggal)) }}</td>
				<td>{{ $v->tempat }}</td>
				<td>{{ $v->angkatan }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=4><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=4>DATA RIWAYAT PENDIDIKAN</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Pendidikan</th>
			<th>Nama Sekolah / Institusi</th>
			<th>Jurusan / Program Studi</th>
			<th>Tanggal Lulus</th>
		</tr>
		@if(count($riwayat_pendidikan)>0)
			@foreach($riwayat_pendidikan as $v)
			<tr>
				<td>{{ $v->tingkat }}</td>
				<td>{{ $v->lembaga }}</td>
				<td>{{ $v->jurusan }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tanggal_kelulusan)) }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=4><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=6>DATA RIWAYAT SEMINAR</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Nama Seminar</th>
			<th>Tingkat</th>
			<th>Tempat</th>
			<th>Tanggal</th>
			<th>Penyelenggara</th>
			<th>Tempat</th>
		</tr>
		@if(count($riwayat_seminar)>0)
			@foreach($riwayat_seminar as $v)
			<tr>
				<td>{{ $v->nama_seminar }}</td>
				<td>{{ $v->tingkat_seminar }}</td>
				<td>{{ $v->peranan }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tanggal)) }}</td>
				<td>{{ $v->penyelenggara }}</td>
				<td>{{ $v->tempat }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=6><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=5>DATA RIWAYAT DIKLAT</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Jenis Diklat</th>
			<th>Nama Diklat</th>
			<th>Tempat Diklat</th>
			<th>Tanggal Mulai</th>
			<th>Tanggal Selesai</th>
		</tr>
		@if(count($riwayat_diklat)>0)
			@foreach($riwayat_diklat as $v)
			<tr>
				<td>{{ $v->jenis_diklat }}</td>
				<td>{{ $v->nama_diklat }}</td>
				<td>{{ $v->lokasi }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tmt_mulai)) }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tmt_selesai)) }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=5><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=4>DATA RIWAYAT TUGAS</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Keterangan</th>
			<th>Pendidikan</th>
			<th>Tanggal Izin</th>
			<th>No. Izin</th>
		</tr>
		@if(count($riwayat_tugas)>0)
			@foreach($riwayat_tugas as $v)
			<tr>
				<td>{{ $v->keterangan }}</td>
				<td>{{ $v->jurusan }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tanggal_izin)) }}</td>
				<td>{{ $v->no_surat }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=4><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=4>DATA RIWAYAT KARYA ILMIAH</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Jenis Buku</th>
			<th>Judul Buku</th>
			<th>Peranan</th>
			<th>Tahun</th>
		</tr>
		@if(count($riwayat_karya_ilmiah)>0)
			@foreach($riwayat_karya_ilmiah as $v)
			<tr>
				<td>{{ $v->jenis_buku }}</td>
				<td>{{ $v->judul_buku }}</td>
				<td>{{ $v->peranan }}</td>
				<td>{{ $v->tahun }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=4><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=3>DATA RIWAYAT PENGHARGAAN</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Nama Jasa/Penghargaan</th>
			<th>No. SK</th>
			<th>Tanggal SK</th>
		</tr>
		@if(count($riwayat_penghargaan)>0)	
			@foreach($riwayat_penghargaan as $v)
			<tr>
				<td>{{ $v->nama_penghargaan }}</td>
				<td>{{ $v->no_sk }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tanggal_sk)) }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=3><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=5>DATA RIWAYAT CUTI</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Jenis Cuti</th>
			<th>Keterangan</th>
			<th>Mulai</th>
			<th>Akhir</th>
			<th>No. SK</th>
		</tr>
		@if(count($riwayat_cuti)>0)	
			@foreach($riwayat_cuti as $v)
			<tr>
				<td>{{ $v->jenis_cuti }}</td>
				<td>{{ $v->keterangan }}</td>
				<td>{{ date('d-m-Y', strtotime($v->mulai)) }}</td>
				<td>{{ date('d-m-Y', strtotime($v->selesai)) }}</td>
				<td>{{ $v->no_sk }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=5><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=5>DATA RIWAYAT HUKUMAN DISIPLIN</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Jenis Hukuman</th>
			<th>Periode Hukuman</th>
			<th>No. SK</th>
			<th>Tanggal. SK</th>
			<th>Keterangan</th>
		</tr>
		@if(count($riwayat_hukuman)>0)	
			@foreach($riwayat_hukuman as $v)
			<tr>
				<td>{{ $v->jenis_hukuman }}</td>
				<td>{{ date('d-m-Y', strtotime($v->mulai)) }} Sampai {{ date('d-m-Y', strtotime($v->selesai)) }} </td>
				<td>{{ $v->no_sk }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tanggal_sk)) }}</td>
				<td>{{ $v->keterangan }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=5><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=8>DATA RIWAYAT KURSUS</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Lokasi Tes</th>
			<th>Tanggal Tes</th>
			<th>Score Toefl</th>
			<th>Listening</th>
			<th>Structure</th>
			<th>Reading</th>
			<th>Writing</th>
			<th>Speaking</th>
		</tr>
		@if(count($riwayat_kursus)>0)	
			@foreach($riwayat_kursus as $v)
			<tr>
				<td>{{ $v->lokasi_tes }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tanggal_tes)) }}</td>
				<td>{{ $v->score }}</td>
				<td>{{ $v->listening }}</td>
				<td>{{ $v->structure }}</td>
				<td>{{ $v->reading }}</td>
				<td>{{ $v->writing }}</td>
				<td>{{ $v->speaking }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=8><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=5>DATA RIWAYAT GAJI</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Golongan</th>
			<th>Masa Kerja</th>
			<th>Gaji Pokok</th>
			<th>TMT</th>
			<th>SK Pejabat</th>
		</tr>
		@if(count($riwayat_gaji)>0)	
			@foreach($riwayat_gaji as $v)
			<tr>
				<td>{{ $v->golongan }}</td>
				<td>{{ $v->masa_kerja }}</td>
				<td>{{ number_format($v->gaji,0,",",".") }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tmt)) }}</td>
				<td>{{ $v->sk_pejabat }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=5><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=5>DATA RIWAYAT KENAIKAN GAJI BERKALA</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Dasar</th>
			<th>Gaji Lama</th>
			<th>Gaji Baru</th>
			<th>KGB Terakhir</th>
			<th>KGB Saat Ini</th>
		</tr>
		@if(count($riwayat_kgb)>0)	
			@foreach($riwayat_kgb as $v)
			<tr>
				<td>{{ $v->dasar }}</td>
				<td>{{ number_format($v->gaji_lama,0,",",".") }}</td>
				<td>{{ number_format($v->gaji_baru,0,",",".") }}</td>
				<td>{{ date('d-m-Y', strtotime($v->kgb_terakhir)) }}</td>
				<td>{{ date('d-m-Y', strtotime($v->kgb_saat_ini)) }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=5><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=5>DATA RIWAYAT TUGAS LUAR NEGERI</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Tipe Kunjungan</th>
			<th>Tujuan</th>
			<th>Mulai</th>
			<th>Selesai</th>
			<th>Asal Dana</th>
		</tr>
		@if(count($riwayat_tugas_luar_negeri)>0)
			@foreach($riwayat_tugas_luar_negeri as $v)
			<tr>
				<td>{{ $v->tipe_kunjungan }}</td>
				<td>{{ $v->tujuan }}</td>
				<td>{{ $v->tanggal_mulai }}</td>
				<td>{{ $v->tanggal_selesai }}</td>
				<td>{{ $v->asal_dana }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=5><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=6>DATA RIWAYAT LAPORAN PAJAK</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>No. NPWP</th>
			<th>Jenis SPT</th>
			<th>Tahun/Masa Pajak</th>
			<th>Pembetulan Ke</th>
			<th>Status</th>
			<th>Jumlah</th>
		</tr>
		@if(count($riwayat_pajak)>0)
			@foreach($riwayat_pajak as $v)
			<tr>
				<td>{{ $v->no_npwp }}</td>
				<td>{{ $v->jenis_spt }}</td>
				<td>{{ $v->tahun }}</td>
				<td>{{ $v->pembetulan }}</td>
				<td>{{ $v->status }}</td>
				<td>{{ $v->jumlah }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=6><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=4>DATA RIWAYAT ORANG TUA</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Orang Tua</th>
			<th>Nama Orang Tua</th>
			<th>Tanggal Lahir</th>
			<th>Pekerjaan</th>
		</tr>
		@if(count($riwayat_orang_tua)>0)
			@foreach($riwayat_orang_tua as $v)
			<tr>
				<td>{{ $v->orang_tua }}</td>
				<td>{{ $v->nama_orang_tua }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tanggal_lahir)) }}</td>
				<td>{{ $v->pekerjaan }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=4><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=4>DATA RIWAYAT PASANGAN</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Nama Suami/Istri</th>
			<th>Tanggal Lahir</th>
			<th>Status Nikah</th>
			<th>Tanggal Status Nikah</th>
		</tr>
		@if(count($riwayat_pasangan)>0)
			@foreach($riwayat_pasangan as $v)
			<tr>
				<td>{{ $v->nama_pasangan }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tanggal_lahir)) }}</td>
				<td>{{ $v->status }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tanggal_nikah)) }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=4><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

	<div class="page-break2"></div>

	<table class="table table-bordered">
		<tr style="background-color: #2196f3;color:white">
			<th style="width: 200px;text-align:center;font-size:16px" colspan=4>DATA RIWAYAT ANAK</th>
		</tr>
		<tr style="background-color: gray;color:white">
			<th>Nama Anak</th>
			<th>Tanggal Lahir</th>
			<th>Pendidikan</th>
			<th>Status</th>
		</tr>
		@if(count($riwayat_anak)>0)
			@foreach($riwayat_anak as $v)
			<tr>
				<td>{{ $v->nama_anak }}</td>
				<td>{{ date('d-m-Y', strtotime($v->tanggal_lahir)) }}</td>
				<td>{{ $v->pendidikan }}</td>
				<td>{{ $v->status }}</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan=4><center>Data Tidak Ada</center></td>
			</tr>
		@endif
	</table>

</body>
</html>