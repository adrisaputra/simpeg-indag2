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
			<h3 class="box-title">Detail {{ $title }}</h3>
		</div>
		
		<div class="box-body">
			<div class="col-lg-1"></div>
			<div class="col-lg-10">
				
				<p style="text-align:center;font-size:24px;font-weight:bold;">{{ $peraturan_kepegawaian->judul }}</p>

				<p>
				{!! $peraturan_kepegawaian->isi !!}
				</p><br><br>

				<div>
					<a href="{{ url('/peraturan_kepegawaian') }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
				</div>

			</div>
		</div>
	</div>
	</section>
</div>

<script src="{{asset('assets/ckeditor/ckeditor.js')}}"></script>
<script>
  var konten = document.getElementById("konten");
    CKEDITOR.replace(konten,{
    language:'en-gb'
  });
  CKEDITOR.config.allowedContent = true;
</script>

@endsection