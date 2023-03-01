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
			
			<div class="table-responsive box-body">

				<table class="table table-bordered">
					<tr style="background-color: gray;color:white">
						<th style="text-align:center">NIP</th>
						<th style="text-align:center">Nama Pegawai</th>
						<th style="text-align:center">Golongan Saat Ini</th>
						<th style="text-align:center">TMT Golongan Saat Ini</th>
						<th style="text-align:center">Golongan Selanjutnya</th>
						<th style="text-align:center">TMT Kenaikan pangkat Selanjutnya</th>
					</tr>
					<tr>
						@if(Auth::user()->group==1)

							@foreach($pegawai as $v)
							<tr>
								<td style="text-align:center">{{ $v->nip }}</td>
								<td style="text-align:center">{{ $v->nama_pegawai }}</td>
								<td style="text-align:center">{{ $v->golongan }}</td>
								<td style="text-align:center">{{ date('d-m-Y', strtotime($v->tmt)) }}</td>
								<td style="text-align:center;font-weight:bold"><span class="label label-success">{{ $golongan_selanjutnya }}</span></td>
								<td style="text-align:center;font-weight:bold"><span class="label label-success">{{ date('d-m-Y', strtotime($v->naikpangkat_berikutnya)) }}</span></td>
								
							</tr>
							@endforeach

						@else

							@if(@$pegawai[0]->tmt)
								<td style="text-align:center">{{ $pegawai[0]->nip }}</td>
								<td style="text-align:center">{{ $pegawai[0]->nama_pegawai }}</td>
								<td style="text-align:center">{{ $pegawai[0]->golongan }}</td>
								<td style="text-align:center">{{ date('d-m-Y', strtotime($pegawai[0]->tmt)) }}</td>
								<td style="text-align:center;font-weight:bold"><span class="label label-success">{{ $golongan_selanjutnya }}</span></td>
								<td style="text-align:center;font-weight:bold"><span class="label label-success">{{ date('d-m-Y', strtotime($pegawai[0]->naikpangkat_berikutnya)) }}</span></td>
							@else
								<td style="text-align:center">{{ $pegawai[0]->nip }}</td>
								<td style="text-align:center">{{ $pegawai[0]->nama_pegawai }}</td>
								<td style="text-align:center"><span class="label label-danger">Riwayat Pangkat Belum Diisi</span></td>
								<td style="text-align:center"><span class="label label-danger">Riwayat Pangkat Belum Diisi</span></td>
								<td style="text-align:center;font-weight:bold"><span class="label label-danger">Riwayat Pangkat Belum Diisi</span></td>
								<td style="text-align:center;font-weight:bold"><span class="label label-danger">Riwayat Pangkat Belum Diisi</span></td>
							@endif

						@endif
					</tr>
				</table>

			</div>
		<div class="box-footer">
			<!-- PAGINATION -->
			@if(Auth::user()->group==1)
				<div class="float-right">{{ $pegawai->appends(Request::only('search'))->links() }}</div>
			@endif
		</div>
	</div>
	</section>
</div>
@endsection