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
					@if(Auth::user()->group==1)
						<a href="{{ url('/'.Request::segment(1).'/create') }}" class="btn btn-success btn-flat" title="Tambah Data">Tambah</a>
					@endif
					<a href="{{ url('/'.Request::segment(1)) }}" class="btn btn-warning btn-flat" title="Refresh halaman">Refresh</a>    
				</div>
			</div>
			<div class="box-tools pull-right">
				<div class="form-inline">
					<form action="{{ url('/'.Request::segment(1).'/search') }}" method="GET">
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
						<th>Nama Pegawai Honorer</th>
						<th>Tempat Lahir</th>
						<th>Tanggal Lahir</th>
						<th>Jenis Kelamin</th>
						<th>SK Honorer</th>
						@if(Auth::user()->group==1)
							<th style="width: 20%">#aksi</th>
						@endif
					</tr>
					@foreach($honorer as $v)
					<tr>
						<td>{{ ($honorer ->currentpage()-1) * $honorer ->perpage() + $loop->index + 1 }}</td>
						<td>{{ $v->nama_pegawai }}</td>
						<td>{{ $v->tempat_lahir }}</td>
						<td>{{ date('d-m-Y', strtotime($v->tanggal_lahir)) }}</td>
						<td>{{ $v->jenis_kelamin }}</td>
						<td>
							@if($v->sk_honorer)
								<a href="{{ asset('upload/sk_honorer/'.$v->sk_honorer) }}" class="btn btn-sm btn-primary" >Download SK Honorer</a>
							@endif
						</td>
						@if(Auth::user()->group==1)
							<td>
								<a href="{{ url('/'.Request::segment(1).'/edit/'.$v->id ) }}" class="btn btn-xs btn-flat btn-warning">Edit</a>
								<a href="{{ url('/'.Request::segment(1).'/hapus/'.$v->id ) }}" class="btn btn-xs btn-flat btn-danger" onclick="return confirm('Anda Yakin ?');">Hapus</a>
							</td>
						@endif
					</tr>
					@endforeach
				</table>

			</div>
		<div class="box-footer">
			<!-- PAGINATION -->
			<div class="float-right">{{ $honorer->appends(Request::only('search'))->links() }}</div>
		</div>
	</div>
	</section>
</div>
@endsection