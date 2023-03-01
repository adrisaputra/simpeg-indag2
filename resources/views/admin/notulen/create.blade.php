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
		
		<form action="{{ url('/notulen') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		{{ csrf_field() }}
			<div class="box-body">
				<div class="col-lg-12">
					
					<div class="form-group @if ($errors->has('tanggal')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Rapat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Rapat" name="tanggal" value="{{ old('tanggal') }}">
                                    </div>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('agenda')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Agenda Rapat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('agenda'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('agenda') }}</label>@endif
							<input type="text" class="form-control" placeholder="Agenda Rapat" name="agenda" value="{{ old('agenda') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('pimpinan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Pimpinan Rapat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('pimpinan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('pimpinan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Pimpinan Rapat" name="pimpinan" value="{{ old('pimpinan') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('anggota')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Peserta Rapat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('anggota'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('anggota') }}</label>@endif
							<select class="form-control" name="anggota">
                                        <option value=""> -Pilih Peserta Rapat-</option>
                                        <option value="Pejabat" @if(old('anggota')=="Pejabat") selected @endif> Pejabat</option>
                                        <option value="Kepala Bidang" @if(old('anggota')=="Bidang") selected @endif> Kepala Bidang</option>
                                        <option value="Seluruh Pegawai" @if(old('anggota')=="Seluruh Pegawai") selected @endif> Seluruh Pegawai</option>
                                   </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('file_notulen')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('File Notulen') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('file_notulen'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('file_notulen') }}</label>@endif
							<input type="file" class="form-control" placeholder="File Notulen" name="file_notulen" value="{{ old('file_notulen') }}" style="border-color: #d3d7df;" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (PDF)</i></span>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('group')) has-error @endif">
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<div>
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/notulen') }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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