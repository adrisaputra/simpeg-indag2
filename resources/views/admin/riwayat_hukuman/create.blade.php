@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA HUKUMAN') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA HUKUMAN') }}</a></li>
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
			<h3 class="box-title">Tambah Data Hukuman</h3>
		</div>
		
		<form action="{{ url('/riwayat_hukuman/'.$pegawai[0]->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
			<div class="box-body">
				<div class="col-lg-12">

				<center><p style="font-size:20px">DATA HUKUMAN</p></center>

					<div class="form-group @if ($errors->has('jenis_hukuman')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Jenis Hukuman ') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('jenis_hukuman'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jenis_hukuman') }}</label>@endif
							<select class="form-control" name="jenis_hukuman">
                                        <option value=""> -Pilih Jenis Hukuman -</option>
                                        <option value="Teguran Lisan" @if(old('jenis_hukuman')=="Teguran Lisan") selected @endif> Teguran Lisan</option>
                                        <option value="Teguran Tertulis" @if(old('jenis_hukuman')=="Teguran Tertulis") selected @endif> Teguran Tertulis</option>
                                        <option value="Pernyataan Tidak Puas Secara Tertulis" @if(old('jenis_hukuman')=="Pernyataan Tidak Puas Secara Tertulis") selected @endif> Pernyataan Tidak Puas Secara Tertulis</option>
                                        <option value="Penundaan kenaikan gaji berkala selama 1 (satu) tahun" @if(old('jenis_hukuman')=="Penundaan kenaikan gaji berkala selama 1 (satu) tahun") selected @endif> Penundaan kenaikan gaji berkala selama 1 (satu) tahun</option>
                                        <option value="Penundaan kenaikan pangkat selama 1 (tahun) tahun" @if(old('jenis_hukuman')=="Penundaan kenaikan pangkat selama 1 (tahun) tahun") selected @endif> Penundaan kenaikan pangkat selama 1 (tahun) tahun</option>
                                        <option value="Penurunan pangkat setingkat lebih rendah selama 1 (satu) tahun" @if(old('jenis_hukuman')=="Penurunan pangkat setingkat lebih rendah selama 1 (satu) tahun") selected @endif> Penurunan pangkat setingkat lebih rendah selama 1 (satu) tahun</option>
                                        <option value="Penurunan pangkat setingkat lebih rendah selama 3 (tiga) tahun" @if(old('jenis_hukuman')=="Penurunan pangkat setingkat lebih rendah selama 3 (tiga) tahun") selected @endif> Penurunan pangkat setingkat lebih rendah selama 3 (tiga) tahun</option>
                                        <option value="Pemindahan dalam rangka penurunan jabatan setingkat lebih rendah" @if(old('jenis_hukuman')=="Pemindahan dalam rangka penurunan jabatan setingkat lebih rendah") selected @endif> Pemindahan dalam rangka penurunan jabatan setingkat lebih rendah</option>
                                        <option value="Pembebasan dari jabatan" @if(old('jenis_hukuman')=="Pembebasan dari jabatan") selected @endif> Pembebasan dari jabatan</option>
                                        <option value="Pemberhentian dengan hormat tidak atas permintaan sendiri sebagai PNS" @if(old('jenis_hukuman')=="Pemberhentian dengan hormat tidak atas permintaan sendiri sebagai PNS") selected @endif> Pemberhentian dengan hormat tidak atas permintaan sendiri sebagai PNS</option>
                                        <option value="Pemberhentian tidak dengan hormat sebagai PNS" @if(old('jenis_hukuman')=="Pemberhentian tidak dengan hormat sebagai PNS") selected @endif> Pemberhentian tidak dengan hormat sebagai PNS</option>
                                   </select>
						</div>
					</div>
					
					<div class="form-group  @if ($errors->has('mulai') || $errors->has('selesai')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Periode Hukuman') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-3" @if($errors->has('mulai') && $errors->has('selesai')) @elseif ($errors->has('selesai')) style="padding-top:27px" @endif>
							@if ($errors->has('mulai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('mulai') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon" @if(old('mulai')) style="border-color: #d3d7df;" @endif>
                                        <i class="fa fa-calendar" @if(old('mulai')) style="color: #555555;" @endif></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="TMT Mulai" name="mulai" value="{{ old('mulai') }}" @if(old('mulai')) style="border-color: #d3d7df;" @endif>
                                    </div>
						</div>
						<div class="col-sm-3" @if($errors->has('mulai') && $errors->has('selesai')) @elseif ($errors->has('mulai')) style="padding-top:27px" @endif>
							@if ($errors->has('selesai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('selesai') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon" @if(old('selesai')) style="border-color: #d3d7df;" @endif>
                                        <i class="fa fa-calendar" @if(old('selesai')) style="color: #555555;" @endif></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="TMT Selesai" name="selesai" value="{{ old('selesai') }}" @if(old('selesai')) style="border-color: #d3d7df;" @endif>
                                    </div>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('no_sk')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('No. SK') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('no_sk'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('no_sk') }}</label>@endif
							<input type="text" class="form-control" placeholder="No. SK" name="no_sk" value="{{ old('no_sk') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal_sk')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal SK') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal_sk'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_sk') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal SK" name="tanggal_sk" value="{{ old('tanggal_sk') }}">
                                    </div>
						</div>
					</div>

					<div class="form-group @if ($errors->has('pejabat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Pejabat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('pejabat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('pejabat') }}</label>@endif
							<input type="text" class="form-control" placeholder="Pejabat" name="pejabat" value="{{ old('pejabat') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('keterangan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Keterangan') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('keterangan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('keterangan') }}</label>@endif
							<textarea class="form-control" placeholder="Keterangan" name="keterangan">{{ old('keterangan') }}</textarea>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('arsip_hukuman')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Berkas') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('arsip_hukuman'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('arsip_hukuman') }}</label>@endif
							<input type="file" class="form-control" placeholder="Berkas" name="arsip_hukuman" value="{{ old('arsip_hukuman') }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_hukuman/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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