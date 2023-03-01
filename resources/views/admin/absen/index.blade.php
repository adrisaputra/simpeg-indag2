@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
	<section class="content-header">
	<h1 class="fontPoppins">{{ __($title) }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __($title) }}</a></li>
	</ol>
	</section>
	
	<section class="content">
	<div class="box">   
		<div class="box-header with-border">
			<div class="box-tools pull-left">
				<div style="padding-top:10px">
					@if($cek_absen)
						@if($cek_absen[0]->tanggal != date('Y-m-d'))
							<a href="{{ url('/buat_absen') }}" class="btn btn-success btn-flat" title="Tambah Data" onclick="return confirm('Anda Yakin ?');">Buat Absen</a>
						@endif
					@else
						<a href="{{ url('/buat_absen') }}" class="btn btn-success btn-flat" title="Tambah Data" onclick="return confirm('Anda Yakin ?');">Buat Absen</a>
					@endif
					<a href="{{ url('/absen') }}" class="btn btn-warning btn-flat" title="Refresh halaman">Refresh</a>
				</div>
			</div>
			<div class="box-tools pull-right">
				<div class="form-inline">
					<form action="{{ url('/absen/search') }}" method="GET">
						<div class="input-group margin">
							<input type="text" class="form-control" name="search" placeholder="Masukkan kata kunci pencarian">
							<span class="input-group-btn">
								<button type="submit" class="btn btn-danger btn-flat">cari</button>
							</span>
						</div>
					</form>
				</div>
			</div>
		</div>
			
			<div class="table-responsive box-body">

				@if($cek_absen)
					@if($cek_absen[0]->tanggal != date('Y-m-d'))
						<div class="alert alert-danger">
							<h4 style="margin-top: 10px;"><i class="icon fa fa-close"></i>Belum Buat Absen Hari ini !</h4>
						</div>
					@else
						<div class="alert alert-success">
							<h4 style="margin-top: 10px;"><i class="icon fa fa-check"></i>{{ $jumlah_pegawai_absen_pagi }} Pegawai Sudah Absen Pagi !</h4>
							<h4 style="margin-top: 10px;"><i class="icon fa fa-check"></i>{{ $jumlah_pegawai_absen_sore }} Pegawai Sudah Absen Sore !</h4>
						</div>
					@endif
				@else
					<div class="alert alert-danger">
								<h4 style="margin-top: 10px;"><i class="icon fa fa-close"></i>Belum Buat Absen Hari ini !</h4>
					</div>
				@endif

				<table class="table table-bordered">
					<tr style="background-color: gray;color:white">
						<th style="width: 1px" rowspan=2>No</th>
						<th style="width: 60%" rowspan=2>Tanggal</th>
						<th colspan=4><center>Kehadiran</center></th>
						<th style="width: 15%" rowspan=2>#aksi</th>
					</tr>
					<tr style="background-color: gray;color:white">
						<th><center>Hadir</th>
						<th><center>Sakit</th>
						<th><center>Izin</th>
						<th><center>Tanpa Keterangan</th>
					</tr>
					@foreach($absen as $v)
					<tr>
						<td>{{ ($absen ->currentpage()-1) * $absen ->perpage() + $loop->index + 1 }}</td>
						<td>
							@if($v->tanggal == date('Y-m-d'))
								<span class="label label-success">Hari Ini</span>
							@else
								{{ date('d-m-Y', strtotime($v->tanggal)) }}
							@endif
						</td>
						@php
							$hadir = DB::table('absen_tbl')->where('tanggal',$v->tanggal)->where('kehadiran','H')->count();
							$izin = DB::table('absen_tbl')->where('tanggal',$v->tanggal)->where('kehadiran','I')->count();
							$sakit = DB::table('absen_tbl')->where('tanggal',$v->tanggal)->where('kehadiran','S')->count();
							$alpa = DB::table('absen_tbl')->where('tanggal',$v->tanggal)->where('kehadiran','A')->count();
						@endphp
						<td><center>{{ $hadir }}</td>
						<td><center>{{ $izin }}</td>
						<td><center>{{ $sakit }}</td>
						<td><center>{{ $alpa }}</td>
						<td>
							<a href="{{ url('/absen/absen_pagi/'.$v->tanggal ) }}" class="btn btn-xs btn-flat btn-block btn-success">Absen Pagi</a>
							<a href="{{ url('/absen/absen_sore/'.$v->tanggal ) }}" class="btn btn-xs btn-flat btn-block btn-danger">Absen Sore</a>
							<a href="{{ url('/public/absen/report/'.$v->tanggal ) }}" class="btn btn-xs btn-flat btn-block btn-primary">Download Absen</a>
						</td>
					</tr>
					@endforeach
				</table>

			</div>
		<div class="box-footer">
			<!-- PAGINATION -->
			<div class="float-right">{{ $absen->appends(Request::only('search'))->links() }}</div>
		</div>
	</div>
	</section>
</div>
@endsection