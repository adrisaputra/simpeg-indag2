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
			<h3 class="box-title">Edit {{ __($title) }}</h3>
		</div>
		
		<form action="{{ url('/'.Request::segment(1).'/edit/'.$arsip->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		{{ csrf_field() }}
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">
					
					<div class="form-group @if ($errors->has('no_surat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('No. Surat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('no_surat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('no_surat') }}</label>@endif
							<input type="text" class="form-control" placeholder="No. Surat" name="no_surat" value="{{ $arsip->no_surat }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Surat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Surat" name="tanggal" value="{{ $arsip->tanggal }}">
                                    </div>
						</div>
					</div>
					
					@if(Request::segment(1)=='arsip_surat_masuk')
					<div class="form-group @if ($errors->has('disposisi')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tujuan Disposisi') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('disposisi'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('disposisi') }}</label>@endif
							<input type="text" class="form-control" placeholder="Tujuan Disposisi" name="disposisi" value="{{ $arsip->disposisi }}" >
						</div>
					</div>
					@endif

					<div class="form-group @if ($errors->has('perihal')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Perihal') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('perihal'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('perihal') }}</label>@endif
							<textarea class="form-control" placeholder="Perihal" name="perihal">{{ $arsip->perihal }}</textarea>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('file_arsip')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('File Arsip') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-5">
							@if ($errors->has('file_arsip'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('file_arsip') }}</label>@endif
							<input type="file" class="form-control" placeholder="File Arsip" name="file_arsip" value="{{ $arsip->file_arsip }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png,pdf)</i></span>
						</div>
						
						<div class="col-sm-2" @if($errors->has('file_arsip')) style="padding-top:27px" @else style="padding-top:2px" @endif >
							@if($arsip->file_arsip)
								<a href="{{ asset('upload/file_arsip/'.$arsip->file_arsip) }}" target="_blank" class="btn btn-sm btn-primary" >Lihat File</a>
							@endif
						</div>
					</div>

					<div class="form-group @if ($errors->has('group')) has-error @endif">
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<div>
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/'.Request::segment(1)) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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