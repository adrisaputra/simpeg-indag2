@extends('admin/layout')
@section('konten')

<div class="content-wrapper">
	<section class="content-header">
	<h1 class="fontPoppins">
		
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
	</ol>
	</ol>
	</section>
	
	<section class="content">
	
	<div class="box-body">
			<!-- Small boxes (Stat box) -->
			<div class="row">
			@if(Auth::user()->group==1)
				<div class="col-lg-6 col-xs-6">
				<!-- small box -->
					<div class="small-box bg-blue">
						<div class="inner">
						<h3>{{ $pegawai }}</h3>

						<p>Total Pegawai</p>
						</div>
						<div class="icon">
						<i class="fa fa-id-card"></i>
						</div>
						<a href="{{ url('pegawai') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-6 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-green">
						<div class="inner">
						<h3>{{ $honorer }}</h3>

						<p>Total Honorer</p>
						</div>
						<div class="icon">
						<i class="fa fa-id-card"></i>
						</div>
						<a href="{{ url('honorer') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-aqua">
						<div class="inner">
						<h3>{{ $kehadiran }}</h3>

						<p>Total Kehadiran</p>
						</div>
						<div class="icon">
						<i class="fa fa-user-clock"></i>
						</div>
						<a href="{{ url('absen') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-red">
						<div class="inner">
						<h3>{{ $pensiun }}</h3>

						<p>Pensiun</p>
						</div>
						<div class="icon">
						<i class="fa fa-user-times"></i>
						</div>
						<a href="{{ url('pegawai/pensiun') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- <div class="col-lg-3 col-xs-6"> -->
					<!-- small box -->
					<!-- <div class="small-box bg-yellow">
						<div class="inner">
						<h3>{{ $honorer }}</h3>

						<p>Diklat</p>
						</div>
						<div class="icon">
						<i class="fa fa-newspaper"></i>
						</div>
						<a href="{{ url('pegawai') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div> -->
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<!-- <div class="small-box bg-teal"> -->
					<div class="small-box bg-yellow">
						<div class="inner">
						<h3>{{ $kgb }}</h3>

						<p>Gaji Berkala</p>
						</div>
						<div class="icon">
						<i class="fa fa-wallet"></i>
						</div>
						<a href="{{ url('pegawai/kgb') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-maroon">
						<div class="inner">
						<h3>{{ $naik_pangkat }}</h3>

						<p>Naik Pangkat</p>
						</div>
						<div class="icon">
						<i class="fa fa-sort-amount-up"></i>
						</div>
						<a href="{{ url('pegawai/naik_pangkat') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
			@elseif(Auth::user()->group==3)
				<div class="col-lg-12 col-xs-12">
				<!-- small box -->
				@if($count)
					@if($status_kehadiran[0]->kehadiran=='H')
						<div class="small-box bg-green">
							<div class="inner">
							<h3>Hadir</h3>
							<p>Absen Pagi : {{ $status_kehadiran[0]->jam_datang }}<br>
							Absen Sore : {{ $status_kehadiran[0]->jam_pulang }}</p>
							</div>
							<div class="icon">
							<i class="fa fa-user-clock"></i>
							</div>
						</div>
					@elseif($status_kehadiran[0]->kehadiran=='S')
						<div class="small-box bg-yellow">
							<div class="inner">
							<h3>Sakit</h3>
							<p>Keterangan : {{ $status_kehadiran[0]->keterangan }}</p>
							</div>
							<div class="icon">
							<i class="fa fa-user-clock"></i>
							</div>
						</div>
					@elseif($status_kehadiran[0]->kehadiran=='I')
						<div class="small-box bg-aqua">
							<div class="inner">
							<h3>Izin</h3>
							<p>Keterangan : {{ $status_kehadiran[0]->keterangan }}</p>
							</div>
							<div class="icon">
							<i class="fa fa-user-clock"></i>
							</div>
						</div>
					@elseif($status_kehadiran[0]->kehadiran=='A')
						<div class="small-box bg-red">
							<div class="inner">
							<h3>Tanpa Keterangan</h3><br><br>
							</div>
							<div class="icon">
							<i class="fa fa-user-clock"></i>
							</div>
						</div>
					@else
						<div class="small-box bg-blue">
							<div class="inner">
							<h3>Belum Absen</h3><br><br>
							</div>
							<div class="icon">
							<i class="fa fa-user-clock"></i>
							</div>
						</div>
					@endif
				@else
					<div class="small-box bg-blue">
						<div class="inner">
						<h3>Belum Absen</h3><br><br>
						</div>
						<div class="icon">
						<i class="fa fa-user-clock"></i>
						</div>
					</div>
				@endif
				</div>
			@endif
			</div>
			<!-- /.row -->
	</section>
</div>
@endsection