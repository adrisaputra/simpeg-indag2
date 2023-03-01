@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
	<section class="content-header">
	<h1 class="fontPoppins">{{ __('PEGAWAI') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('PEGAWAI') }}</a></li>
	</ol>
	</section>
	
	<section class="content">
	<div class="box">   
		<div class="box-header with-border">
			<div class="box-tools pull-left">
				<div style="padding-top:10px">
					<a href="{{ url('/pegawai/download_cv/'.$pegawai[0]->id) }}" class="btn btn-success btn-flat" title="Download CV">Download CV</a>
					<a href="{{ url('/pegawai/edit/'.$pegawai[0]->id) }}" class="btn btn-warning btn-flat" title="Edit Data Pribadi">Edit Data Pribadi</a>    
				</div>
			</div>
		</div>
			
			<div class="table-responsive box-body">

				<table class="table table-bordered">
					<tr>
						<td colspan=2>
							<center>
								@if($pegawai[0]->foto_formal)
									<img src="{{ asset('storage/upload/foto_formal_pegawai/thumbnail/'.$pegawai[0]->foto_formal) }}" class="img-circle" alt="User Image"  width="150px" height="150px">
								@else
									<img src="{{ asset('upload/user/15.jpg') }}" class="img-circle" alt="User Image" width="150px" height="150px">
								@endif
								<br><br>
								<p style="font-size:22px;font-weight:bold">{{ $pegawai[0]->nama_pegawai }}</p>
								<p style="font-size:18px;font-weight:bold">{{ $pegawai[0]->nip }}</p>
							</center>
						</td>
					</tr>
					<tr style="background-color: #2196f3;color:white">
						<th style="width: 200px;text-align:center;font-size:16px" colspan=2>DATA PRIBADI</th>
					</tr>
					<tr>
						<th style="width: 200px">Tempat Tanggal Lahir</th>
						<td>: {{ $pegawai[0]->tempat_lahir }}, {{ date('d-m-Y', strtotime($pegawai[0]->tanggal_lahir)) }}</td>
					</tr>
					<tr>
						<th style="width: 200px">Jenis Kelamin</th>
						<td>: {{ $pegawai[0]->jenis_kelamin}}</td>
					</tr>
					<tr>
						<th style="width: 200px">Alamat</th>
						<td>: {{ $pegawai[0]->alamat}}</td>
					</tr>
					<tr>
						<th style="width: 200px">Agama</th>
						<td>: {{ $pegawai[0]->agama}}</td>
					</tr>
					<tr>
						<th style="width: 200px">Gol. Darah</th>
						<td>: {{ $pegawai[0]->gol_darah}}</td>
					</tr>
					<tr>
						<th style="width: 200px">Email</th>
						<td>: {{ $pegawai[0]->email}}</td>
					</tr>
					<tr>
						<th style="width: 200px">No. KTP</th>
						<td>: {{ $pegawai[0]->no_ktp}}</td>
					</tr>
					<tr>
						<th style="width: 200px">No. BPJS</th>
						<td>: {{ $pegawai[0]->no_bpjs}}</td>
					</tr>
					<tr>
						<th style="width: 200px">Nomor NPWP</th>
						<td>: {{ $pegawai[0]->no_npwp }} </td>
					</tr>
					<tr>
						<th style="width: 200px">Nomor Karpeg</th>
						<td>: {{ $pegawai[0]->no_karpeg }} </td>
					</tr>
					<tr>
						<th style="width: 200px">No. Karsu/Karis</th>
						<td>: {{ $pegawai[0]->no_karsu }} </td>
					</tr>
					<tr>
						<th style="width: 200px">Golongan</th>
						<td>: {{ $pegawai[0]->golongan }}</td>
					</tr>
					<tr>
						<th style="width: 200px">Pendidikan</th>
						<td>: {{ $pegawai[0]->pendidikan }}</td>
					</tr>
					<tr>
						<th style="width: 200px">Status Kepegawaian</th>
						<td>: {{ $pegawai[0]->status }}</td>
					</tr>
					<tr style="background-color: #2196f3;color:white">
						<th style="width: 200px;text-align:center;font-size:16px" colspan=2>DATA RIWAYAT</th>
					</tr>
					<tr>
						<th style="width: 200px">Riwayat 1</th>
						<td>
							<a href="{{ url('riwayat_jabatan/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Jabatan</a>
							<a href="{{ url('riwayat_angka_kredit/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Angka Kredit</a>
							<a href="{{ url('riwayat_kepangkatan/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Pangkat</a>
							<a href="{{ url('riwayat_lhkpn/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">LHKPN</a>
							<a href="{{ url('riwayat_kompetensi/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Kompetensi</a>
						</td>
					</tr>
					<tr>
						<th style="width: 200px">Riwayat 2</th>
						<td>
							<a href="{{ url('riwayat_pendidikan/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Pendidikan</a>
							<a href="{{ url('riwayat_seminar/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Seminar</a>
							<a href="{{ url('riwayat_diklat/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Diklat/Sertifikasi</a>
							<a href="{{ url('riwayat_tugas/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Tugas/Izin Belajar</a>
							<a href="{{ url('riwayat_karya_ilmiah/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Karya Ilmiah</a>
						</td>
					</tr>
					<tr>
						<th style="width: 200px">Riwayat 3</th>
						<td>
							<a href="{{ url('riwayat_penghargaan/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Penghargaan</a>
							<a href="{{ url('riwayat_cuti/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Cuti</a>
							<a href="{{ url('riwayat_hukuman/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Hukuman Disiplin</a>
							<a href="{{ url('riwayat_kursus/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Kursus</a>
							<a href="{{ url('riwayat_gaji/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Gaji</a>
							<a href="{{ url('riwayat_kgb/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Kenaikan Gaji Berkala</a>
							<a href="{{ url('riwayat_tugas_luar_negeri/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Riwayat Tugas Luar Negeri</a>
						</td>
					</tr>
					<tr>
						<th style="width: 200px">Riwayat 4</th>
						<td>
							<a href="{{ url('riwayat_pajak/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Laporan Pajak</a>
						</td>
					</tr>
					<tr>
						<th style="width: 200px">Riwayat Keluarga</th>
						<td>
							<a href="{{ url('riwayat_orang_tua/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Orang Tua</a>
							<a href="{{ url('riwayat_pasangan/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Pasangan</a>
							<a href="{{ url('riwayat_anak/'.$pegawai[0]->id) }}" class="btn btn-info btn-flat btn-sm">Anak</a>
						</td>
					</tr>
				</table>
				
			</div>
		<div class="box-footer">
			<!-- PAGINATION -->
		</div>
	</div>
	</section>
</div>
@endsection