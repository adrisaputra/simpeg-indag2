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
					<!-- <a href="{{ url('/'.Request::segment(1).'/create') }}" class="btn btn-success btn-flat" title="Tambah Data">Tambah</a> -->
					<a href="{{ url('/'.Request::segment(1)) }}" class="btn btn-warning btn-flat" title="Refresh halaman">Refresh</a>    
				</div>
			</div>
			<!-- <div class="box-tools pull-right">
				<div class="form-inline">
					<form action="{{ url('/peraturan_kepegawaian/search') }}" method="GET">
						<div class="input-group margin">
							<input type="text" class="form-control" name="search" placeholder="Masukkan kata kunci pencarian">
							<span class="input-group-btn">
								<button type="submit" class="btn btn-danger btn-flat">cari</button>
							</span>
						</div>
					</form>
				</div>
			</div> -->
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
						<th>Informasi</th>
						<th style="width: 20%">#aksi</th>
					</tr>
					@foreach($peraturan_kepegawaian as $v)
					<tr>
						<td>{{ ($peraturan_kepegawaian ->currentpage()-1) * $peraturan_kepegawaian ->perpage() + $loop->index + 1 }}</td>
						<td>{{ $v->judul }}</td>
						<td>
							@if(Auth::user()->group==1)
								<a href="{{ url('/'.Request::segment(1).'/edit/'.$v->id ) }}" class="btn btn-xs btn-flat btn-warning">Edit</a>
							@elseif(Auth::user()->group==3)
								<a href="{{ url('/'.Request::segment(1).'/detail/'.$v->id ) }}" class="btn btn-xs btn-flat btn-info">Detail</a>
							@endif
						</td>
					</tr>
					@endforeach
				</table>

			</div>
		<div class="box-footer">
			<!-- PAGINATION -->
			<div class="float-right">{{ $peraturan_kepegawaian->appends(Request::only('search'))->links() }}</div>
		</div>
	</div>
	</section>
</div>
@endsection