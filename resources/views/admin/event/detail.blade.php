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
			<h3 class="box-title">{{ __($title) }}</h3>
		</div>
		
		<form action="{{ url('/agenda/edit/'.$agenda->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		{{ csrf_field() }}
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">

					<div class="form-group">
						<label class="col-sm-2 control-label">{{ __('Nama Kegiatan') }} : </label>
						<div class="col-sm-10" style="padding-top:7px">
							{{ $agenda->title }}
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label">{{ __('Tanggal Mulai') }} : </label>
						<div class="col-sm-10" style="padding-top:7px">
							{{ date('d-m-Y', strtotime($agenda->start)) }}
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label">{{ __('Tanggal Selesai') }} : </label>
						<div class="col-sm-10" style="padding-top:7px">
							{{ date('d-m-Y', strtotime($agenda->end2)) }}
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label">{{ __('Pelaksana') }} : </label>
						<div class="col-sm-10" style="padding-top:7px">
							@foreach($pelaksana as $v)	
								- {{ $v->pegawai->nama_pegawai }} <br>
							@endforeach
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label">{{ __('Uraian Kegiatan') }} : </label>
						<div class="col-sm-10" style="padding-top:7px">
							{{ $agenda->uraian }}

							<div style="padding-top:10px">
								<a href="{{ url('/agenda') }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
							</div>

						</div>
						 
					</div>
					
				</div>
			</div>
		</form>
	</div>
	</section>
</div>

@endsection