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
			<h3 class="box-title">Tambah {{ __($title) }}</h3>
		</div>
		
		<form action="{{ url('/'.Request::segment(1)) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		{{ csrf_field() }}
			<div class="box-body">
				<div class="col-lg-12">
					
					<div class="form-group @if ($errors->has('nama_pegawai')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Nama Pegawai ') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('nama_pegawai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('nama_pegawai') }}</label>@endif
							<select class="form-control select2" name="nama_pegawai">
                                        <option value=""> -Pilih Nama Pegawai -</option>
								@foreach($pegawai as $v)
                                        	<option value="{{ $v->nip }}" @if(old('nip')==$v->nip) selected @endif> {{ $v->nama_pegawai }}</option>
								@endforeach
                                   </select>
						</div>
					</div>

					<div class="form-group @if ($errors->has('jenis')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Jenis') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('jenis'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jenis') }}</label>@endif
							<input type="text" class="form-control" placeholder="Jenis" name="jenis" value="{{ old('jenis') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('syarat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Syarat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('syarat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('syarat') }}</label>@endif
							<textarea class="form-control" placeholder="Syarat" name="syarat">{{ old('syarat') }}</textarea>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('group')) has-error @endif">
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<div>
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/pengusulan_penghargaan') }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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