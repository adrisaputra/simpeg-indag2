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
		
		<form action="{{ url('/'.Request::segment(1).'/edit/'.$pengumuman_ujian_pangkat->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		{{ csrf_field() }}
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">
					
					
					<div class="form-group @if ($errors->has('lokasi')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Lokasi') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('lokasi'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('lokasi') }}</label>@endif
							<input type="text" class="form-control" placeholder="Lokasi" name="lokasi" value="{{ $pengumuman_ujian_pangkat->lokasi }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('syarat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Syarat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('syarat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('syarat') }}</label>@endif
							<textarea class="form-control" placeholder="Syarat" name="syarat">{{ $pengumuman_ujian_pangkat->syarat }}</textarea>
						</div>
					</div>
					
					<div class="form-group  @if ($errors->has('tanggal_mulai') || $errors->has('tanggal_selesai')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-3" @if($errors->has('tanggal_mulai') && $errors->has('tanggal_selesai')) @elseif ($errors->has('tanggal_selesai')) style="padding-top:27px" @endif>
							@if ($errors->has('tanggal_mulai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_mulai') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon" @if($pengumuman_ujian_pangkat->tanggal_mulai) style="border-color: #d3d7df;" @endif>
                                        <i class="fa fa-calendar" @if($pengumuman_ujian_pangkat->tanggal_mulai) style="color: #555555;" @endif></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Mulai" name="tanggal_mulai" value="{{ $pengumuman_ujian_pangkat->tanggal_mulai }}" @if($pengumuman_ujian_pangkat->tanggal_mulai) style="border-color: #d3d7df;" @endif>
                                    </div>
						</div>
						<div class="col-sm-3" @if($errors->has('tanggal_mulai') && $errors->has('tanggal_selesai')) @elseif ($errors->has('tanggal_mulai')) style="padding-top:27px" @endif>
							@if ($errors->has('tanggal_selesai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_selesai') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon" @if($pengumuman_ujian_pangkat->tanggal_selesai) style="border-color: #d3d7df;" @endif>
                                        <i class="fa fa-calendar" @if($pengumuman_ujian_pangkat->tanggal_selesai) style="color: #555555;" @endif></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Selesai" name="tanggal_selesai" value="{{ $pengumuman_ujian_pangkat->tanggal_selesai }}" @if($pengumuman_ujian_pangkat->tanggal_selesai) style="border-color: #d3d7df;" @endif>
                                    </div>
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