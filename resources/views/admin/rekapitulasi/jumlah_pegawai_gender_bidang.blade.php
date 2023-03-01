@extends('admin.layout')
@section('konten')

<style>
#chartdiv {
  width: 100%;
  height: 700px;
}
</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
am4core.addLicense("ch-custom-attribution");
// Themes end



// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);
// chart.numberFormatter.numberFormat = "#.0";

// Add data
chart.data = [ 
@foreach($bidang as $v)
	{
	   "year": '{{ $v->nama_bidang }}',
        "pria": {{ $pria[$loop->index + 1] }},
        "wanita": {{ $wanita[$loop->index + 1] }},
    	},
@endforeach
];

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "year";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 20;
categoryAxis.renderer.inside = true;
categoryAxis.renderer.labels.template.valign = "top";
categoryAxis.renderer.labels.template.fontSize = 20;
categoryAxis.renderer.cellStartLocation = 0.1;
categoryAxis.renderer.cellEndLocation = 0.9;

var label = categoryAxis.renderer.labels.template;
label.wrap = true;
label.maxWidth = 100;
label.fontSize = 10;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.min = 0;
valueAxis.max = 30;
valueAxis.title.text = "Jumlah ASN";

// Create series
function createSeries(field, name) {
  var series = chart.series.push(new am4charts.ColumnSeries());
  series.sequencedInterpolation = true;
  series.dataFields.valueY = field;
  series.dataFields.categoryX = "year";
  series.name = name;
  series.columns.template.tooltipText = "{name}: [bold]{valueY}[/] Orang";
//   series.columns.template.width = am4core.percent(70);
  
  var bullet = series.bullets.push(new am4charts.LabelBullet);
  bullet.label.text = "{name}";
  bullet.label.truncate = false;
  bullet.label.hideOversized = false;
  bullet.label.horizontalCenter = "left";
  bullet.locationY = 1;
  bullet.dy = 10;
  
series.columns.template.column.cornerRadiusTopLeft = 4;
series.columns.template.column.cornerRadiusTopRight = 4;
series.columns.template.column.fillOpacity = 0.8;
// series.columns.template.width = am4core.percent(50);

var labelBullet = series.bullets.push(new am4charts.LabelBullet());
labelBullet.label.verticalCenter = "bottom";
labelBullet.label.dy =0;
labelBullet.label.text = "{values.valueY.workingValue.formatNumber('#.')}";

// on hover, make corner radiuses bigger
var hoverState = series.columns.template.column.states.create("hover");
hoverState.properties.cornerRadiusTopLeft = 0;
hoverState.properties.cornerRadiusTopRight = 0;
hoverState.properties.fillOpacity = 1;

// series.columns.template.adapter.add("fill", function(fill, target) {
//   return chart.colors.getIndex(target.dataItem.index);
// });

// // Cursor
// chart.cursor = new am4charts.XYCursor();

}

chart.colors.list = [
  am4core.color("#3c8dbc"),
  am4core.color("#fe4383")
];

chart.paddingBottom = 150;
chart.maskBullets = false;

createSeries("pria", "L", false);
createSeries("wanita", "P", true);

chart.legend = new am4charts.Legend();
chart.legend.marginTop = 20;
}); // end am4core.ready()
</script>

<div class="content-wrapper">
	<section class="content-header">
	<h1 class="fontPoppins">{{ __('GENDER PER BIDANG') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('GENDER PER BIDANG') }}</a></li>
	</ol>
	</section>
	<section class="content">
	<div class="row">
        <div class="col-md-4">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tabel Jumlah Pegawai Berdasarkan Gender</h3>
            </div>
            	<div class="table-responsive box-body">

			  <table class="table table-bordered">
					<tr style="background-color: gray;color:white">
						<th style="width: 60px"><center>No</th>
						<th><center>Jabatan</th>
						<th><center>Pria</th>
						<th><center>Wanita</th>
						<th><center>Jumlah</th>
					</tr>
					@php 
						$i=0;
						$j=0; 
						$k=0; 
					@endphp
					@foreach($bidang as $v)
					@php
						$i = $i +  $pria[$loop->index + 1];
						$j = $j +  $wanita[$loop->index + 1];
						$k = $k +  $jumlah[$loop->index + 1];
					@endphp
					<tr>
						<td>{{ $loop->index + 1 }}</td>
						<td>{{ $v->nama_bidang }}</td>
						<td><center>{{ $pria[$loop->index + 1] }}</center></td>
						<td><center>{{ $wanita[$loop->index + 1] }}</center></td>
						<td><center>{{ $jumlah[$loop->index + 1] }}</center></td>
					</tr>
					@endforeach
					<tr style="background-color: #00bcd4;color:white">
						<th colspan=2>Total Pegawai</th>
						<td><center>{{ $i }}</center></td>
						<td><center>{{ $j }}</center></td>
						<td><center>{{ $k }}</center></td>
					</tr>
				</table>

			</div>
          </div>
        </div>

        <div class="col-md-8">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Jumlah Pegawai Berdasarkan Gender</h3>
            </div>
            <center><div id="chartdiv"></div></center>
          </div>
        </div>

      </div>
	</section>

</div>
@endsection