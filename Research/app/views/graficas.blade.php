@extends(Config::get( 'app.main_template' ).'.main')


@section('content')
			<!-- widget grid -->
				<section id="widget-grid" class="">



					<!-- row -->

					<!-- row -->
					<div class="row">

						<!-- NEW WIDGET START -->
						<article class="col-xs-12 col-sm-6 col-md-4 col-lg-6">

							<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget" id="wid-id-5" data-widget-editbutton="false">

								<header>
									<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
									<h2>Registros Total Usuarios</h2>

								</header>
								<div>
									<div class="widget-body no-padding">

										<div id="donut-graph" class="chart no-padding"></div>

									</div>
								</div>
							</div>




						</article>

						
						<!-- NEW WIDGET START -->
						<article class="col-xs-12 col-sm-6 col-md-4 col-lg-6">

							<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget" id="wid-id-5" data-widget-editbutton="false">

								<header>
									<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
									<h2>Redes Sociales</h2>

								</header>

								<!-- widget div-->
								<div>

									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->

									</div>
									<!-- end widget edit box -->

									<!-- widget content -->
									<div class="widget-body no-padding">

										<div id="normal-bar-graph" class="chart no-padding"></div>

									</div>
									<!-- end widget content -->

								</div>
							</div>

						</article>

						<article class="col-xs-12 col-sm-12 col-md-4 col-lg-12">
							<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget" id="wid-id-5" data-widget-editbutton="false">

								<header>
									<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
									<h2>Edades</h2>

								</header>

								<!-- widget div-->
								<div>

									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->

									</div>
									<!-- end widget edit box -->

									<!-- widget content -->
									<div class="widget-body no-padding">

										<div id="normal-bar-graph1" class="chart no-padding"></div>

									</div>
									<!-- end widget content -->

								</div>
							</div>
						</article>



					</div>

					<!-- end row -->

					<!-- row -->
					<div class="row">

					<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							
							<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget" id="wid-id-5" data-widget-colorbutton="false" data-widget-fullscreenbutton="false" data-widget-editbutton="false" data-widget-sortable="false">
								<header>
									
									<h2>Edades</h2>				
									
								</header>

								<!-- widget div-->
								<div>
									
									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->
										<input class="form-control" type="text">	
									</div>
									<!-- end widget edit box -->
									
									<!-- widget content -->
									<div class="widget-body">


										
										<!-- this is what the user will see -->
										<canvas id="lineChart" height="50"></canvas>
									

									</div>
									<!-- end widget content -->
									
								</div>
								<!-- end widget div -->
								
							</div>
							<!-- end widget -->


						</article>

					</div>

					<!-- end row -->

				</section>
				<!-- end widget grid -->

			</div>
			<!-- END MAIN CONTENT -->

		</div>
		<!-- END MAIN PANEL -->
@stop

@section('scripts')
	@parent

			<!-- Morris Chart Dependencies -->
		{{ HTML::script("js/plugin/morris/raphael.min.js") }}
		{{ HTML::script("js/plugin/morris/morris.min.js") }}
		{{ HTML::script("js/plugin/chartjs/chart.min.js") }}


<script>

var x = '<?php print_r($data);?>';
var element = JSON.parse(x);

				if ($('#donut-graph').length) {
					Morris.Donut({
						element : 'donut-graph',
						data : element,
						/*formatter : function(x) {
							return x + "%"
						}*/
					});

				}

var dataSocial = '<?php print_r($dataSocial);?>';
var elementSocial = JSON.parse(dataSocial);

				// Use Morris.Bar
				if ($('#normal-bar-graph').length) {

					Morris.Bar({
						element : 'normal-bar-graph',
						data : elementSocial,
						xkey : 'socialNetwork',
						ykeys : ['socialMale', 'socialFemale'],
						labels : ['Hombre', 'Mujer']
					});

				}

var dataEdad = '<?php print_r($dataEdad);?>';
var elementEdad = JSON.parse(dataEdad);

				// Use Morris.Bar
				if ($('#normal-bar-graph1').length) {

					Morris.Bar({
						element : 'normal-bar-graph1',
						data : elementEdad,
						xkey : 'age',
						ykeys : ['ageMale', 'ageFemale'],
						labels : ['Hombre', 'Mujer']
					});

				}




var Edad = '<?php print_r($Edad);?>';
var elemEdad = JSON.parse(Edad);

					// LINE CHART
				// ref: http://www.chartjs.org/docs/#line-chart-introduction
			    var lineOptions = {
				    ///Boolean - Whether grid lines are shown across the chart
				    scaleShowGridLines : true,
				    //String - Colour of the grid lines
				    scaleGridLineColor : "rgba(0,0,0,.05)",
				    //Number - Width of the grid lines
				    scaleGridLineWidth : 1,
				    //Boolean - Whether the line is curved between points
				    bezierCurve : true,
				    //Number - Tension of the bezier curve between points
				    bezierCurveTension : 0.4,
				    //Boolean - Whether to show a dot for each point
				    pointDot : true,
				    //Number - Radius of each point dot in pixels
				    pointDotRadius : 4,
				    //Number - Pixel width of point dot stroke
				    pointDotStrokeWidth : 1,
				    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
				    pointHitDetectionRadius : 20,
				    //Boolean - Whether to show a stroke for datasets
				    datasetStroke : true,
				    //Number - Pixel width of dataset stroke
				    datasetStrokeWidth : 2,
				    //Boolean - Whether to fill the dataset with a colour
				    datasetFill : true,
				    //Boolean - Re-draw chart on page resize
			        responsive: true,
				    //String - A legend template
				    legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
			    };

			    var lineData = { labels: elemEdad['age'],
			        datasets: [
				        {
				            label: "My First dataset",
				            fillColor: "rgba(220,220,220,0.2)",
				            strokeColor: "rgba(220,220,220,1)",
				            pointColor: "rgba(220,220,220,1)",
				            pointStrokeColor: "#fff",
				            pointHighlightFill: "#fff",
				            pointHighlightStroke: "rgba(220,220,220,1)",
				            data: elemEdad['ageFemale']
				        },
				        {
				            label: "My Second dataset",
				            fillColor: "rgba(151,187,205,0.2)",
				            strokeColor: "rgba(151,187,205,1)",
				            pointColor: "rgba(151,187,205,1)",
				            pointStrokeColor: "#fff",
				            pointHighlightFill: "#fff",
				            pointHighlightStroke: "rgba(151,187,205,1)",
				            data: elemEdad['ageMale']
				        }
				    ]
			    };

			    // render chart
			    var ctx = document.getElementById("lineChart").getContext("2d");
			    var myNewChart = new Chart(ctx).Line(lineData, lineOptions);
				var legendHolder = document.createElement('div');
				legendHolder.innerHTML = myNewChart.generateLegend();

document.getElementById('lineChart').parentNode.parentNode.appendChild(legendHolder.firstChild);


			    

</script>

@stop