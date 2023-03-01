@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA GAJI') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA GAJI') }}</a></li>
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
			<h3 class="box-title">Tambah Data Gaji</h3>
		</div>
		
		<form action="{{ url('/riwayat_gaji/'.$pegawai[0]->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
			<div class="box-body">
				<div class="col-lg-12">

				<center><p style="font-size:20px">DATA GAJI</p></center>

					<div class="form-group  @if ($errors->has('golongan') || $errors->has('status')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Golongan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-3" @if($errors->has('golongan') && $errors->has('status')) @elseif ($errors->has('status')) style="padding-top:27px" @endif>
							@if ($errors->has('golongan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('golongan') }}</label>@endif
							<select class="form-control" name="golongan"  @if(old('golongan')) style="border-color: #d3d7df;" @endif>
                                        <option value=""> -Pilih Golongan-</option>
                                        <option value="Golongan I/a" @if(old('golongan')=="Golongan I/a") selected @endif> Golongan I/a</option>
                                        <option value="Golongan I/b" @if(old('golongan')=="Golongan I/b") selected @endif> Golongan I/b</option>
                                        <option value="Golongan I/c" @if(old('golongan')=="Golongan I/c")selected @endif> Golongan I/c</option>
                                        <option value="Golongan I/d" @if(old('golongan')=="Golongan I/d") selected @endif> Golongan I/d</option>
                                        <option value="Golongan II/a" @if(old('golongan')=="Golongan II/a") selected @endif> Golongan II/a</option>
                                        <option value="Golongan II/b" @if(old('golongan')=="Golongan II/b") selected @endif> Golongan II/b</option>
                                        <option value="Golongan II/c" @if(old('golongan')=="Golongan II/c")selected @endif> Golongan II/c</option>
                                        <option value="Golongan II/d" @if(old('golongan')=="Golongan II/d") selected @endif> Golongan II/d</option>
                                        <option value="Golongan III/a" @if(old('golongan')=="Golongan III/a") selected @endif> Golongan III/a</option>
                                        <option value="Golongan III/b" @if(old('golongan')=="Golongan III/b") selected @endif> Golongan III/b</option>
                                        <option value="Golongan III/c" @if(old('golongan')=="Golongan III/c") selected @endif> Golongan III/c</option>
                                        <option value="Golongan III/d" @if(old('golongan')=="Golongan III/d") selected @endif> Golongan III/d</option>
                                        <option value="Golongan IV/a" @if(old('golongan')=="Golongan IV/a") selected @endif> Golongan IV/a</option>
                                        <option value="Golongan IV/b" @if(old('golongan')=="Golongan IV/b") selected @endif> Golongan IV/b</option>
                                        <option value="Golongan IV/c" @if(old('golongan')=="Golongan IV/c") selected @endif> Golongan IV/c</option>
                                        <option value="Golongan IV/d" @if(old('golongan')=="Golongan IV/d") selected @endif> Golongan IV/d</option>
                                        <option value="Golongan IV/e" @if(old('golongan')=="Golongan IV/e") selected @endif> Golongan IV/e</option>
                                    </select>
						</div>
					</div>

					<div class="form-group @if ($errors->has('masa_kerja')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Masa Kerja') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('masa_kerja'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('masa_kerja') }}</label>@endif
							<input type="text" class="form-control" placeholder="Masa Kerja" name="masa_kerja" value="{{ old('masa_kerja') }}" >
						</div>
					</div>
						
						<div class="form-group @if ($errors->has('tmt')) has-error @endif">
							<label class="col-sm-2 control-label">{{ __('TMT') }} <span class="required" style="color: #dd4b39;">*</span></label>
							<div class="col-sm-10">
								@if ($errors->has('tmt'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tmt') }}</label>@endif
								<div class="input-group date">
								 <div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								 </div>
									<input type="text" class="form-control datepicker" placeholder="TMT" name="tmt" value="{{ old('tmt') }}">
								 </div>
							</div>
						</div>	
					
					<div class="form-group @if ($errors->has('sk_pejabat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('SK Pejabat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('sk_pejabat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('sk_pejabat') }}</label>@endif
							<input type="text" class="form-control" placeholder="SK Pejabat" name="sk_pejabat" value="{{ old('sk_pejabat') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('gaji')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Gaji') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('gaji'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('gaji') }}</label>@endif
							<input type="text" class="form-control" placeholder="Gaji" name="gaji" value="{{ old('gaji') }}" onkeyup="formatRupiah(this, '.')">
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('arsip_gaji')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Berkas') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('arsip_gaji'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('arsip_gaji') }}</label>@endif
							<input type="file" class="form-control" placeholder="Arsip Jabatan" name="arsip_gaji" value="{{ old('arsip_gaji') }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_gaji/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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