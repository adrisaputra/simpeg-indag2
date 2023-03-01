@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA PENDIDIKAN') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA PENDIDIKAN') }}</a></li>
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
			<h3 class="box-title">Edit Data Pendidikan</h3>
		</div>
		
		<form action="{{ url('/riwayat_pendidikan/edit/'.$pegawai[0]->id.'/'.$riwayat_pendidikan->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">

					<center><p style="font-size:20px">DATA PENDIDIKAN</p></center>

					
					<div class="form-group @if ($errors->has('tingkat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tingkat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tingkat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tingkat') }}</label>@endif
							<select class="form-control" name="tingkat">
                                        <option value=""> -Pilih Tingkat-</option>
                                        <option value="SD" @if($riwayat_pendidikan->tingkat=="SD") selected @endif> SD</option>
                                        <option value="SLTP" @if($riwayat_pendidikan->tingkat=="SLTP") selected @endif> SLTP</option>
                                        <option value="SLTP Kejuruan" @if($riwayat_pendidikan->tingkat=="SLTP Kejuruan") selected @endif> SLTP Kejuruan</option>
                                        <option value="SLTA" @if($riwayat_pendidikan->tingkat=="SLTA") selected @endif> SLTA</option>
                                        <option value="SLTA Kejuruan" @if($riwayat_pendidikan->tingkat=="SLTA Kejuruan") selected @endif> SLTA Kejuruan</option>
                                        <option value="SLTA Keguruan" @if($riwayat_pendidikan->tingkat=="SLTA Keguruan") selected @endif> SLTA Keguruan</option>
                                        <option value="Diploma I" @if($riwayat_pendidikan->tingkat=="Diploma I") selected @endif> Diploma I</option>
                                        <option value="Diploma II" @if($riwayat_pendidikan->tingkat=="Diploma II") selected @endif> Diploma II</option>
                                        <option value="Diploma III / Sarjana Muda" @if($riwayat_pendidikan->tingkat=="Diploma III / Sarjana Muda") selected @endif> Diploma III / Sarjana Muda</option>
                                        <option value="Diploma IV" @if($riwayat_pendidikan->tingkat=="Diploma IV") selected @endif> Diploma IV</option>
                                        <option value="S1 / Sarjana" @if($riwayat_pendidikan->tingkat=="S1 / Sarjana") selected @endif> S1 / Sarjana</option>
                                        <option value="S2" @if($riwayat_pendidikan->tingkat=="S2") selected @endif> S2</option>
                                        <option value="S3 / Doktor" @if($riwayat_pendidikan->tingkat=="S3 / Doktor") selected @endif> S3 / Doktor</option>
                                       
                                    </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('lembaga')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Sekolah / Institusi') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('lembaga'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('lembaga') }}</label>@endif
							<input type="text" class="form-control" placeholder="Sekolah / Institusi" name="lembaga" value="{{ $riwayat_pendidikan->lembaga }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('fakultas')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Fakultas') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('fakultas'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('fakultas') }}</label>@endif
							<input type="text" class="form-control" placeholder="Fakultas" name="fakultas" value="{{ $riwayat_pendidikan->fakultas }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('jurusan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Jurusan') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('jurusan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jurusan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Jurusan" name="jurusan" value="{{ $riwayat_pendidikan->jurusan }}" >
						</div>
					</div>
					
					<div class="form-group  @if ($errors->has('no_sttb') || $errors->has('tanggal_sttb')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('No. STTB') }}</label>
						<div class="col-sm-3" @if($errors->has('no_sttb') && $errors->has('tanggal_sttb')) @elseif ($errors->has('tanggal_sttb')) style="padding-top:27px" @endif>
							@if ($errors->has('no_sttb'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('no_sttb') }}</label>@endif
							<input type="text" class="form-control" placeholder="No. STTB" name="no_sttb" value="{{ $riwayat_pendidikan->no_sttb }}" @if($riwayat_pendidikan->no_sttb) style="border-color: #d3d7df;" @endif>
						</div>
						<div class="col-sm-3" @if($errors->has('no_sttb') && $errors->has('tanggal_sttb')) @elseif ($errors->has('no_sttb')) style="padding-top:27px" @endif>
							@if ($errors->has('tanggal_sttb'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_sttb') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon" @if($riwayat_pendidikan->tanggal_sttb) style="border-color: #d3d7df;" @endif>
                                        <i class="fa fa-calendar" @if($riwayat_pendidikan->tanggal_sttb) style="border-color: #555555;" @endif></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal STTB" name="tanggal_sttb" value="{{ $riwayat_pendidikan->tanggal_sttb }}" @if($riwayat_pendidikan->tanggal_sttb) style="border-color: #d3d7df;" @endif>
                                    </div>
						</div>
					</div>

					<div class="form-group @if ($errors->has('tanggal_kelulusan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Kelulusan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal_kelulusan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_kelulusan') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Kelulusan" name="tanggal_kelulusan" value="{{ $riwayat_pendidikan->tanggal_kelulusan }}">
                                    </div>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('ipk')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('IPK') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('ipk'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('ipk') }}</label>@endif
							<input type="text" class="form-control" placeholder="IPK" name="ipk" value="{{ $riwayat_pendidikan->ipk }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('arsip_ijazah')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Arsip Ijazah') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-4">
							@if ($errors->has('arsip_ijazah'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('arsip_ijazah') }}</label>@endif
							<input type="file" class="form-control" placeholder="Arsip Ijazah" name="arsip_ijazah" value="{{ $riwayat_pendidikan->arsip_ijazah }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
						</div>
						<div class="col-sm-2" @if($errors->has('arsip_ijazah')) style="padding-top:27px" @else style="padding-top:2px" @endif >
							@if($riwayat_pendidikan->arsip_ijazah)
								<a href="{{ asset('upload/arsip_ijazah/'.$riwayat_pendidikan->arsip_ijazah) }}" target="_blank" class="btn btn-sm btn-primary" >Lihat File</a>
							@endif
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('arsip_transkrip_nilai')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Arsip Transkrip Nilai') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-4">
							@if ($errors->has('arsip_transkrip_nilai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('arsip_transkrip_nilai') }}</label>@endif
							<input type="file" class="form-control" placeholder="Arsip Transkrip Nilai" name="arsip_transkrip_nilai" value="{{ $riwayat_pendidikan->arsip_transkrip_nilai }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_pendidikan/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
							</div>

						</div>
						<div class="col-sm-2" @if($errors->has('arsip_transkrip_nilai')) style="padding-top:27px" @else style="padding-top:2px" @endif >
							@if($riwayat_pendidikan->arsip_transkrip_nilai)
								<a href="{{ asset('upload/arsip_transkrip_nilai/'.$riwayat_pendidikan->arsip_transkrip_nilai) }}" target="_blank" class="btn btn-sm btn-primary" >Lihat File</a>
							@endif
						</div>
					</div>

				</div>
			</div>
		</form>
	</div>
	</section>
</div>

@endsection