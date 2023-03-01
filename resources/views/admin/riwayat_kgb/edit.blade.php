@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA KGB') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA KGB') }}</a></li>
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
			<h3 class="box-title">Edit Data KGB</h3>
		</div>
		
		<form action="{{ url('/riwayat_kgb/edit/'.$pegawai[0]->id.'/'.$riwayat_kgb->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">

					<center><p style="font-size:20px">DATA KGB</p></center>

					<div class="form-group @if ($errors->has('dasar')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Dasar') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('dasar'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('dasar') }}</label>@endif
							<select class="form-control" name="dasar">
                                        <option value=""> -Pilih Dasar-</option>
                                        <option value="KGB" @if($riwayat_kgb->dasar=="KGB") selected @endif> KGB</option>
                                        <option value="Kenaikan Pangkat" @if($riwayat_kgb->dasar=="Kenaikan Pangkat") selected @endif> Kenaikan Pangkat</option>
                                    </select>
						</div>
					</div>

					<div class="form-group @if ($errors->has('gaji_lama')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Gaji Lama') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('gaji_lama'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('gaji_lama') }}</label>@endif
							<input type="text" class="form-control" placeholder="Gaji Lama" name="gaji_lama" value="{{ number_format($riwayat_kgb->gaji_lama, 0, ',', '.') }}" onkeyup="formatRupiah(this, '.')">
						</div>
					</div>

					<div class="form-group @if ($errors->has('gaji_baru')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Gaji Baru') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('gaji_baru'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('gaji_baru') }}</label>@endif
							<input type="text" class="form-control" placeholder="Gaji Baru" name="gaji_baru" value="{{ number_format($riwayat_kgb->gaji_baru, 0, ',', '.') }}" onkeyup="formatRupiah(this, '.')">
						</div>
					</div>

					<div class="form-group @if ($errors->has('kgb_terakhir')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('KGB Terakhir') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('kgb_terakhir'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('kgb_terakhir') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="KGB Terakhir" name="kgb_terakhir" value="{{ $riwayat_kgb->kgb_terakhir }}">
                                    </div>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('kgb_saat_ini')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('KGB Saat Ini') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('kgb_saat_ini'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('kgb_saat_ini') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="KGB Saat Ini" name="kgb_saat_ini" value="{{ $riwayat_kgb->kgb_saat_ini }}">
                                    </div>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('arsip_kgb')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Berkas ') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-4">
							@if ($errors->has('arsip_kgb'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('arsip_kgb') }}</label>@endif
							<input type="file" class="form-control" placeholder="Arsip Jabatan" name="arsip_kgb" value="{{ $riwayat_kgb->arsip_kgb }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png,)</i></span>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_kgb/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
							</div>

						</div>
						
						<div class="col-sm-2" @if($errors->has('arsip_kgb')) style="padding-top:27px" @else style="padding-top:2px" @endif >
							@if($riwayat_kgb->arsip_kgb)
								<a href="{{ asset('upload/arsip_kgb/'.$riwayat_kgb->arsip_kgb) }}" target="_blank" class="btn btn-sm btn-primary" >Lihat File</a>
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