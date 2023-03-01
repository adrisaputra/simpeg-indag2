@extends('admin.layout')
@section('konten')

<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 600px;
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
chart.fontSize = 10;

// Add data
chart.data = [ 
@foreach($bidang as $v)
	{
	"country": "{{ $v->nama_bidang }}",
	"visits": {{ $jumlah_pegawai_bidang[$loop->index + 1] }}
	},
@endforeach
];

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "country";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;
categoryAxis.renderer.labels.template.horizontalCenter = "middle";
categoryAxis.renderer.labels.template.verticalCenter = "top";
categoryAxis.renderer.labels.template.rotation = 0;
categoryAxis.tooltip.disabled = true;

var label = categoryAxis.renderer.labels.template;
label.wrap = true;
label.maxWidth = 80;
label.fontSize = 8;
// categoryAxis.renderer.minHeight = 110;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.renderer.minWidth = 50;
valueAxis.title.text = "Jumlah ASN";
valueAxis.title.fontWeight = 400;
valueAxis.min = 0;

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
labelBullet.label.dy =0;
labelBullet.label.text = "{values.valueY.workingValue.formatNumber('#.')}";


// on hover, make corner radiuses bigger
var hoverState = series.columns.template.column.states.create("hover");
hoverState.properties.cornerRadiusTopLeft = 0;
hoverState.properties.cornerRadiusTopRight = 0;
hoverState.properties.fillOpacity = 1;

series.columns.template.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
});

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
	<h1 class="fontPoppins">{{ __('JUMLAH PEGAWAI PER BIDANG') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('JUMLAH PEGAWAI PER BIDANG') }}</a></li>
	</ol>
	</section>
	<section class="content">
	<div class="row">
        <div class="col-md-4">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Tabel Jumlah Pegawai Per Bidang</h3>
            </div>
            	<div class="table-responsive box-body">

				<table class="table table-bordered">
					<tr style="background-color: gray;color:white">
						<th style="width: 60px"><center>No</th>
						<th><center>Jabatan</th>
						<th><center>Jumlah</th>
					</tr>
					@php $i=0; @endphp
					@foreach($bidang as $v)
					@php $i = $i +  $jumlah_pegawai_bidang[$loop->index + 1]; @endphp
					<tr>
						<td>{{ $loop->index + 1 }}</td>
						<td>{{ $v->nama_bidang }}</td>
						<td><center>{{ $jumlah_pegawai_bidang[$loop->index + 1] }}</center></td>
					</tr>
					@endforeach
					<tr style="background-color: #00bcd4;color:white">
						<th colspan=2>Total Pegawai</th>
						<td><center>{{ $i }}</center></td>
					</tr>
				</table>

			</div>
          </div>
        </div>

        <div class="col-md-8">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Jumlah Pegawai Per Bidang</h3>
            </div>
            <center><div id="chartdiv"></div></center>
          </div>
        </div>

      </div>
	</section>
	
</div>
@endsection