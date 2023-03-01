@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
	<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA CUTI') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA CUTI') }}</a></li>
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
					<a href="{{ url('/riwayat_cuti/create/'.$pegawai[0]->id) }}" class="btn btn-success btn-flat" title="Tambah Data">Tambah</a>
					<a href="{{ url('/riwayat_cuti/'.$pegawai[0]->id) }}" class="btn btn-warning btn-flat" title="Refresh halaman">Refresh</a>    
					<a href="{{ url('/pegawai') }}" class="btn btn-danger btn-flat" title="Refresh halaman">Kembali</a>    
				</div>
			</div>
			<div class="box-tools pull-right">
				<div class="form-inline">
					<form action="{{ url('/riwayat_cuti/search/'.$pegawai[0]->id) }}" method="GET">
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
						<th>Jenis Cuti</th>
						<th>Keterangan</th>
						<th>Mulai</th>
						<th>Akhir</th>
						<th>No. SK</th>
						<th>Arsip</th>
						<th style="width: 20%">#aksi</th>
					</tr>
					@foreach($riwayat_cuti as $v)
					<tr>
						<td>{{ ($riwayat_cuti ->currentpage()-1) * $riwayat_cuti ->perpage() + $loop->index + 1 }}</td>
						<td>{{ $v->jenis_cuti }}</td>
						<td>{{ $v->keterangan }}</td>
						<td>{{ date('d-m-Y', strtotime($v->mulai)) }}</td>
						<td>{{ date('d-m-Y', strtotime($v->selesai)) }}</td>
						<td>{{ $v->no_sk }}</td>
						<td>
							@if($v->arsip_cuti)
								<a href="{{ asset('upload/arsip_cuti/'.$v->arsip_cuti) }}" class="btn btn-sm btn-primary" >Download File</a>
							@endif
						</td>
						<td>
							<a href="{{ url('/riwayat_cuti/edit/'.$pegawai[0]->id.'/'.$v->id ) }}" class="btn btn-xs btn-flat btn-warning">Edit</a>
							<a href="{{ url('/riwayat_cuti/hapus/'.$pegawai[0]->id.'/'.$v->id ) }}" class="btn btn-xs btn-flat btn-danger" onclick="return confirm('Anda Yakin ?');">Hapus</a>
						</td>
					</tr>
					@endforeach
				</table>

			</div>
		<div class="box-footer">
			<!-- PAGINATION -->
			<div class="float-right">{{ $riwayat_cuti->appends(Request::only('search'))->links() }}</div>
		</div>
	</div>
	</section>
</div>
@endsection