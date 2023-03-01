@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
	<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA KURSUS') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA KURSUS') }}</a></li>
	</ol>
	</section>
	
	<section class="content">

	<div class="box">
		<div class="box-body">
			<div class="col-lg-6">
				<div class="form-group">
					<label >NIP</label>
					<input type="text" class="form-control" placeholder="NIP" value="{{ $pegawai[0]->nip }}" disabled>
				</div>

			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label >Nama Pegawai</label>
					<input type="text" class="form-control" placeholder="Nama Pegawai" value="{{ $pegawai[0]->nama_pegawai }}" disabled>
				</div>
			</div>
		</div>
	</div>

	<div class="box">   
		<div class="box-header with-border">
			<div class="box-tools pull-left">
				<div style="padding-top:10px">
					<a href="{{ url('/riwayat_kursus/create/'.$pegawai[0]->id) }}" class="btn btn-success btn-flat" title="Tambah Data">Tambah</a>
					<a href="{{ url('/riwayat_kursus/'.$pegawai[0]->id) }}" class="btn btn-warning btn-flat" title="Refresh halaman">Refresh</a>    
					<a href="{{ url('/pegawai') }}" class="btn btn-danger btn-flat" title="Refresh halaman">Kembali</a>    
				</div>
			</div>
			<div class="box-tools pull-right">
				<div class="form-inline">
					<form action="{{ url('/riwayat_kursus/search/'.$pegawai[0]->id) }}" method="GET">
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

				@if ($message = Session::get('status'))
					<div class="alert alert-info alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i>Berhasil !</h4>
						{{ $message }}
					</div>
				@endif

				<table class="table table-bordered">
					<tr style="background-color: gray;color:white">
						<th style="width: 60px">No</th>
                              <th>Lokasi Tes</th>
                              <th>Tanggal Tes</th>
                              <th>Score Toefl</th>
                              <th>Listening</th>
                              <th>Structure</th>
                              <th>Reading</th>
                              <th>Writing</th>
                              <th>Speaking</th>
                              <th>Arsip</th>
						<th style="width: 20%">#aksi</th>
					</tr>
					@foreach($riwayat_kursus as $v)
					<tr>
						<td>{{ ($riwayat_kursus ->currentpage()-1) * $riwayat_kursus ->perpage() + $loop->index + 1 }}</td>
						<td>{{ $v->lokasi_tes }}</td>
						<td>{{ date('d-m-Y', strtotime($v->tanggal_tes)) }}</td>
						<td>{{ $v->score }}</td>
						<td>{{ $v->listening }}</td>
						<td>{{ $v->structure }}</td>
						<td>{{ $v->reading }}</td>
						<td>{{ $v->writing }}</td>
						<td>{{ $v->speaking }}</td>
						<td>
							@if($v->arsip_toefl)
								<a href="{{ asset('upload/arsip_toefl/'.$v->arsip_toefl) }}" class="btn btn-sm btn-primary" >Download File</a>
							@endif
						</td>
						<td>
							<a href="{{ url('/riwayat_kursus/edit/'.$pegawai[0]->id.'/'.$v->id ) }}" class="btn btn-xs btn-flat btn-warning">Edit</a>
							<a href="{{ url('/riwayat_kursus/hapus/'.$pegawai[0]->id.'/'.$v->id ) }}" class="btn btn-xs btn-flat btn-danger" onclick="return confirm('Anda Yakin ?');">Hapus</a>
						</td>
					</tr>
					@endforeach
				</table>

			</div>
		<div class="box-footer">
			<!-- PAGINATION -->
			<div class="float-right">{{ $riwayat_kursus->appends(Request::only('search'))->links() }}</div>
		</div>
	</div>
	</section>
</div>
@endsection