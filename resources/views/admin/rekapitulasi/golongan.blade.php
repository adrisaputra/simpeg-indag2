@extends('admin.layout')
@section('konten')

<!-- Styles -->
<style>
#chartdiv {
  width: 40%;
  height: 400px;
}

</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_material);
am4core.useTheme(am4themes_animated);
am4core.addLicense("ch-custom-attribution");
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);

// Add data
chart.data = [ 
	{
	"country": "Gol. IV",
	"visits": {{ $jumlah_gol_4 }}
	},
	{
	"country": "Gol. III",
	"visits": {{ $jumlah_gol_3 }}
	},
	{
	"country": "Gol. II",
	"visits": {{ $jumlah_gol_2 }}
	},
	{
	"country": "Gol. I",
	"visits": {{ $jumlah_gol_1 }}
	},
];

// var label = chart.createChild(am4core.Label);
// label.x = am4core.percent(50);
// label.text = "Jumlah ASN";
// label.fontSize = 16;
// label.align = "center";
// label.isMeasured = false;
// label.x = -20;
// label.y = 200;
// label.rotation = -90;

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "country";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;
categoryAxis.renderer.labels.template.horizontalCenter = "middle";
categoryAxis.renderer.labels.template.verticalCenter = "middle";
categoryAxis.renderer.labels.template.rotation = 0;
categoryAxis.tooltip.disabled = true;
// categoryAxis.renderer.minHeight = 110;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.renderer.minWidth = 50;
valueAxis.title.text = "Jumlah ASN";
valueAxis.title.fontWeight = 400;
valueAxis.min = 0;
valueAxis.max = 100;

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "visits";
series.dataFields.categoryX = "country";
series.tooltipText = "[bold]{valueY}[/] Orang";
series.columns.template.strokeWidth = 0;
series.tooltip.pointerOrientation = "vertical";

series.columns.template.column.cornerRadiusTopLeft = 10;
series.columns.template.column.cornerRadiusTopRight = 10;
series.columns.template.column.fillOpacity = 0.8;
// series.columns.template.width = am4core.percent(50);

var labelBullet = series.bullets.push(new am4charts.LabelBullet());
labelBullet.label.verticalCenter = "bottom";
labelBullet.label.dy = 0;
labelBullet.label.text = "{values.valueY.workingValue.formatNumber('#.')}";


// on hover, make corner radiuses bigger
var hoverState = series.columns.template.column.states.create("hover");
hoverState.properties.cornerRadiusTopLeft = 0;
hoverState.properties.cornerRadiusTopRight = 0;
hoverState.properties.fillOpacity = 1;

series.columns.template.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
});

chart.colors.list = [
  am4core.color("#3c8dbc"),
  am4core.color("#00a65a"),
  am4core.color("#dd4b39"),
  am4core.color("#f39c12")
];
// Cursor
chart.cursor = new am4charts.XYCursor();


var legend = new am4charts.Legend();
legend.parent = chart.chartContainer;
//legend.itemContainers.template.togglable = false;
legend.marginTop = 10;
legend.maxWidth = 10;

series.events.on("ready", function(ev) {
  var legenddata = [];
  series.columns.each(function(column) {
    legenddata.push({
      name: column.dataItem.categoryX,
      fill: column.fill,
      columnDataItem: column.dataItem
    });
  });
  legend.data = legenddata;
});

legend.itemContainers.template.events.on("hit", function(ev) {
  //console.log("Clicked on ", ev.target.dataItem.className);
  if (!ev.target.isActive) {
    ev.target.dataItem.dataContext.columnDataItem.hide();
  }
  else {
    ev.target.dataItem.dataContext.columnDataItem.show();
  }
});

legend.itemContainers.template.events.on("over", function(ev) {
  ev.target.dataItem.dataContext.columnDataItem.column.isHover = true;
  ev.target.dataItem.dataContext.columnDataItem.column.showTooltip();
});

legend.itemContainers.template.events.on("out", function(ev) {
  ev.target.dataItem.dataContext.columnDataItem.column.isHover = false;
  ev.target.dataItem.dataContext.columnDataItem.column.hideTooltip();
});


}); // end am4core.ready()
</script>

<div class="content-wrapper">
	<section class="content-header">
	<h1 class="fontPoppins">{{ __('PANGKAT/GOLONGAN') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('PANGKAT/GOLONGAN') }}</a></li>
	</ol>
	</section>
	
	<section class="content">
	<div class="box">   
		<center><div id="chartdiv"></div></center>
			<div class="table-responsive box-body">

				@if ($message = Session::get('status'))
					<div class="alert alert-info alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i>Berhasil !</h4>
						{{ $message }}
					</div>
				@endif

				<table class="table table-bordered">
					<tr style="background-color: gray;color:white">
						<th style="width: 10px" rowspan=3>No</th>
						<th style="width: 40px" rowspan=3>Jabatan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
						<th style="width: 10px" rowspan=3>Jumlah ASN</th>
						<th style="width: 10px" rowspan=2 colspan=2>Jenis kelamin</th>
						<th style="width: 10px" colspan=12>Golongan IV</th>
						<th style="width: 10px" colspan=10>Golongan III</th>
						<th style="width: 10px" colspan=10>Golongan II</th>
						<th style="width: 10px" colspan=10>Golongan I</th>
					</tr>
					<tr style="background-color: gray;color:white">
						<th colspan=2>E</th>
						<th colspan=2>D</th>
						<th colspan=2>C</th>
						<th colspan=2>B</th>
						<th colspan=2>A</th>
						<th colspan=2>JML. GOL</th>
						<th colspan=2>D</th>
						<th colspan=2>C</th>
						<th colspan=2>B</th>
						<th colspan=2>A</th>
						<th colspan=2>JML. GOL</th>
						<th colspan=2>D</th>
						<th colspan=2>C</th>
						<th colspan=2>B</th>
						<th colspan=2>A</th>
						<th colspan=2>JML. GOL</th>
						<th colspan=2>D</th>
						<th colspan=2>C</th>
						<th colspan=2>B</th>
						<th colspan=2>A</th>
						<th colspan=2>JML. GOL</th>
					</tr>
					<tr style="background-color: gray;color:white">
						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>

						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>
						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>
						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>
						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>
						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>
						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>

						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>
						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>
						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>
						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>
						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>

						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>
						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>
						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>
						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>
						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>

						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>
						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>
						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>
						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>
						<th style="text-align: center;">L</th>
						<th style="text-align: center;">P</th>
					</tr>
					</center>
					@foreach($bidang as $v)
					<tr>
						<td rowspan=2>{{ $loop->index + 1 }}</td>
						<td rowspan=2>{{ $v->nama_bidang }}</td>
						<td rowspan=2><center>{{ $jumlah_pegawai_bidang[$loop->index + 1] }}</center></td>
						<td rowspan=2><center>{{ $pria[$loop->index + 1] }}</center></td>
						<td rowspan=2><center>{{ $wanita[$loop->index + 1] }}</center></td>
						<td colspan=2><center><b>{{ $total17[$loop->index + 1] }}</td>
						<td colspan=2><center><b>{{ $total16[$loop->index + 1] }}</td>
						<td colspan=2><center><b>{{ $total15[$loop->index + 1] }}</td>
						<td colspan=2><center><b>{{ $total14[$loop->index + 1] }}</td>
						<td colspan=2><center><b>{{ $total13[$loop->index + 1] }}</td>
						<td colspan=2 style="background-color: #4caf50;color:white"><center><b>{{ $total_semua_gol_4[$loop->index + 1] }}</td>
						<td colspan=2><center><b>{{ $total12[$loop->index + 1] }}</td>
						<td colspan=2><center><b>{{ $total11[$loop->index + 1] }}</td>
						<td colspan=2><center><b>{{ $total10[$loop->index + 1] }}</td>
						<td colspan=2><center><b>{{ $total9[$loop->index + 1] }}</td>
						<td colspan=2 style="background-color: #4caf50;color:white"><center><b>{{ $total_semua_gol_3[$loop->index + 1] }}</td>
						<td colspan=2><center><b>{{ $total8[$loop->index + 1] }}</td>
						<td colspan=2><center><b>{{ $total7[$loop->index + 1] }}</td>
						<td colspan=2><center><b>{{ $total6[$loop->index + 1] }}</td>
						<td colspan=2><center><b>{{ $total5[$loop->index + 1] }}</td>
						<td colspan=2 style="background-color: #4caf50;color:white"><center><b>{{ $total_semua_gol_2[$loop->index + 1] }}</td>
						<td colspan=2><center><b>{{ $total4[$loop->index + 1] }}</td>
						<td colspan=2><center><b>{{ $total3[$loop->index + 1] }}</td>
						<td colspan=2><center><b>{{ $total2[$loop->index + 1] }}</td>
						<td colspan=2><center><b>{{ $total1[$loop->index + 1] }}</td>
						<td colspan=2 style="background-color: #4caf50;color:white"><center><b>{{ $total_semua_gol_1[$loop->index + 1] }}</td>
					</tr>
					
					<tr>
						<td>{{ $pria17[$loop->index + 1] }}</td>
						<td>{{ $wanita17[$loop->index + 1] }}</td>
						<td>{{ $pria16[$loop->index + 1] }}</td>
						<td>{{ $wanita16[$loop->index + 1] }}</td>
						<td>{{ $pria15[$loop->index + 1] }}</td>
						<td>{{ $wanita15[$loop->index + 1] }}</td>
						<td>{{ $pria14[$loop->index + 1] }}</td>
						<td>{{ $wanita14[$loop->index + 1] }}</td>
						<td>{{ $pria13[$loop->index + 1] }}</td>
						<td>{{ $wanita13[$loop->index + 1] }}</td>
						<td style="background-color: #4caf50;color:white">{{ $jumlah_pria_gol_4[$loop->index + 1] }}</td>
                              <td style="background-color: #4caf50;color:white">{{ $jumlah_wanita_gol_4[$loop->index + 1] }}</td>
						<td>{{ $pria12[$loop->index + 1] }}</td>
						<td>{{ $wanita12[$loop->index + 1] }}</td>
						<td>{{ $pria11[$loop->index + 1] }}</td>
						<td>{{ $wanita11[$loop->index + 1] }}</td>
						<td>{{ $pria10[$loop->index + 1] }}</td>
						<td>{{ $wanita10[$loop->index + 1] }}</td>
						<td>{{ $pria9[$loop->index + 1] }}</td>
						<td>{{ $wanita9[$loop->index + 1] }}</td>
						<td style="background-color: #4caf50;color:white">{{ $jumlah_pria_gol_3[$loop->index + 1] }}</td>
                              <td style="background-color: #4caf50;color:white">{{ $jumlah_wanita_gol_3[$loop->index + 1] }}</td>
						<td>{{ $pria8[$loop->index + 1] }}</td>
						<td>{{ $wanita8[$loop->index + 1] }}</td>
						<td>{{ $pria7[$loop->index + 1] }}</td>
						<td>{{ $wanita7[$loop->index + 1] }}</td>
						<td>{{ $pria6[$loop->index + 1] }}</td>
						<td>{{ $wanita6[$loop->index + 1] }}</td>
						<td>{{ $pria5[$loop->index + 1] }}</td>
						<td>{{ $wanita5[$loop->index + 1] }}</td>
						<td style="background-color: #4caf50;color:white">{{ $jumlah_pria_gol_2[$loop->index + 1] }}</td>
                              <td style="background-color: #4caf50;color:white">{{ $jumlah_wanita_gol_2[$loop->index + 1] }}</td>
						<td>{{ $pria4[$loop->index + 1] }}</td>
						<td>{{ $wanita4[$loop->index + 1] }}</td>
						<td>{{ $pria3[$loop->index + 1] }}</td>
						<td>{{ $wanita3[$loop->index + 1] }}</td>
						<td>{{ $pria2[$loop->index + 1] }}</td>
						<td>{{ $wanita2[$loop->index + 1] }}</td>
						<td>{{ $pria1[$loop->index + 1] }}</td>
						<td>{{ $wanita1[$loop->index + 1] }}</td>
						<td style="background-color: #4caf50;color:white">{{ $jumlah_pria_gol_1[$loop->index + 1] }}</td>
                              <td style="background-color: #4caf50;color:white">{{ $jumlah_wanita_gol_1[$loop->index + 1] }}</td>

					</tr>
					@endforeach
				</table>

			</div>
		<div class="box-footer">
			<!-- PAGINATION -->
		</div>
	</div>
	</section>
</div>
@endsection