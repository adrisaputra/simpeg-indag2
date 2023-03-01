@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA ANGKA KREDIT') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA ANGKA KREDIT') }}</a></li>
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
			<h3 class="box-title">Edit Data Angka Kredit</h3>
		</div>
		
		<form action="{{ url('/riwayat_angka_kredit/edit/'.$pegawai[0]->id.'/'.$riwayat_angka_kredit->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		@csrf
    		<input type="hidden" name="user_token" value="{{ csrf_token() }}">
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">

					<center><p style="font-size:20px">DATA ANGKA KREDIT</p></center>

					
					<div class="form-group @if ($errors->has('jabatan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Jabatan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('jabatan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jabatan') }}</label>@endif
							<select class="form-control" name="jabatan">
                                        <option value=""> -Pilih Jabatan-</option>
                                        <option value="Kepala Dinas" @if($riwayat_angka_kredit->jabatan=="Kepala Dinas") selected @endif> Kepala Dinas</option>
                                        <option value="Sekretaris" @if($riwayat_angka_kredit->jabatan=="Sekretaris") selected @endif> Sekretaris</option>
                                        <option value="Kepala Bidang" @if($riwayat_angka_kredit->jabatan=="Kepala Bidang") selected @endif> Kepala Bidang</option>
                                        <option value="Kepala UPTD" @if($riwayat_angka_kredit->jabatan=="Kepala UPTD") selected @endif> Kepala UPTD</option>
                                        <option value="Kepala Sub Bagian" @if($riwayat_angka_kredit->jabatan=="Kepala Sub Bagian") selected @endif> Kepala Sub Bagian</option>
                                        <option value="Kepala Seksi" @if($riwayat_angka_kredit->jabatan=="Kepala Seksi") selected @endif> Kepala Seksi</option>
                                        <option value="Staf" @if($riwayat_angka_kredit->jabatan=="Staf") selected @endif> Staf</option>
                                    </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('no_pak')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('No. PAK') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('no_pak'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('no_pak') }}</label>@endif
							<input type="text" class="form-control" placeholder="No. PAK" name="no_pak" value="{{ $riwayat_angka_kredit->no_pak }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal_pak')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal PAK') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal_pak'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_pak') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal PAK" name="tanggal_pak" value="{{ $riwayat_angka_kredit->tanggal_pak }}">
                                    </div>
						</div>
					</div>
					
					<hr style="border-top: 1px solid #eee;">
					
					<center><p style="font-size:20px">ANGKA KREDIT</p></center>
					
					<div class="form-group @if ($errors->has('pendidikan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Pendidikan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('pendidikan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('pendidikan') }}</label>@endif
							<input type="number" class="form-control" placeholder="Pendidikan" name="pendidikan" id="pendidikan"  onkeyup="sum();findTotal();" @if($riwayat_angka_kredit->pendidikan) value="{{ $riwayat_angka_kredit->pendidikan }}" @else  value="0" @endif" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('pelaksanaan_tupok')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Pelaksanaan TUPOK') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('pelaksanaan_tupok'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('pelaksanaan_tupok') }}</label>@endif
							<input type="number" class="form-control" placeholder="Pelaksanaan TUPOK" name="pelaksanaan_tupok" id="pelaksanaan_tupok"  onkeyup="sum();" @if($riwayat_angka_kredit->pelaksanaan_tupok) value="{{ $riwayat_angka_kredit->pelaksanaan_tupok }}" @else  value="0" @endif" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('pengembangan_profesi')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Pengembangan Profesi') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('pengembangan_profesi'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('pengembangan_profesi') }}</label>@endif
							<input type="number" class="form-control" placeholder="Pengembangan Profesi" name="pengembangan_profesi" id="pengembangan_profesi"  onkeyup="sum();" @if($riwayat_angka_kredit->pengembangan_profesi) value="{{ $riwayat_angka_kredit->pengembangan_profesi }}" @else  value="0" @endif" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('unsur_penunjang')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Unsur Penunjang') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('unsur_penunjang'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('unsur_penunjang') }}</label>@endif
							<input type="number" class="form-control" placeholder="Unsur Penunjang" name="unsur_penunjang" id="unsur_penunjang" onkeyup="sum();" @if($riwayat_angka_kredit->unsur_penunjang)  value="{{ $riwayat_angka_kredit->unsur_penunjang }}" @else  value="0" @endif" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('jumlah')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Jumlah') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('jumlah'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jumlah') }}</label>@endif
							<input type="text" class="form-control" placeholder="Jumlah" name="jumlah" value="{{ $riwayat_angka_kredit->jumlah }}" id="total" disabled>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tmt_angka_kredit')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('TMT Angka Kredit') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tmt_angka_kredit'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tmt_angka_kredit') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="TMT Angka Kredit" name="tmt_angka_kredit" value="{{ $riwayat_angka_kredit->tmt_angka_kredit }}">
                                    </div>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('sk')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('SK') }}</label>
						<div class="col-sm-4">
							@if ($errors->has('sk'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('sk') }}</label>@endif
							<input type="file" class="form-control" placeholder="SK" name="sk" value="{{ $riwayat_angka_kredit->sk }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_angka_kredit/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
							</div>

						</div>
						<div class="col-sm-2" @if($errors->has('sk')) style="padding-top:27px" @else style="padding-top:2px" @endif >
							@if($riwayat_angka_kredit->sk)
								<a href="{{ asset('upload/sk_angka_kredit/'.$riwayat_angka_kredit->sk) }}" target="_blank" class="btn btn-sm btn-primary" >Lihat File</a>
							@endif
						</div>
					</div>

					
				</div>
			</div>
		</form>
	</div>
	</section>
</div>
<script>
function sum()
	{
		
		pendidikan = document.getElementById('pendidikan').value;
		pelaksanaan_tupok = document.getElementById('pelaksanaan_tupok').value;
		pengembangan_profesi = document.getElementById('pengembangan_profesi').value;
		unsur_penunjang = document.getElementById('unsur_penunjang').value;
		result = parseInt(pendidikan) + parseInt(pelaksanaan_tupok) + parseInt(pengembangan_profesi) + parseInt(unsur_penunjang);
		if (!isNaN(result)) {
		document.getElementById('total').value = result;
		}
	}
</script>
@endsection