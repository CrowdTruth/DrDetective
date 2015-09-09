@extends('layout')

@section('extraheaders')
	<script>
		//On window size < 480, set the ribbon logo div behind the ribbon button div, so it borders on the lower section properly.
		$(window).resize(function() {
			var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
			if (width <= 480) {
				$("#ribbon").each(function() {
					var detach = $(this).find("#ribimg").detach();
					$(detach).insertAfter($(this).find("#ribbutton"));
				})
			} else if (width > 480) {
				$("#ribbon").each(function() {
					var detach = $(this).find("#ribbutton").detach();
					$(detach).insertAfter($(this).find("#ribimg"));
				})
			}
		});
	
		//Reset logo div in front of button on larger size.
		$(document).ready(function() {
			var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
			if (width <= 480) {
				$("#ribbon").each(function() {
					var detach = $(this).find("#ribimg").detach();
					$(detach).insertAfter($(this).find("#ribbutton"));
				})
			} else if (width > 480) {
				$("#ribbon").each(function() {
					var detach = $(this).find("#ribbutton").detach();
					$(detach).insertAfter($(this).find("#ribimg"));
				})
			}
		});
	</script>
@stop

@section('content')
	<div id="main">
			<div class="section group scrollto" id="ribbon">
				<div class="col span_4_of_8" id="ribimg">
					<img src="img/logo/logo_drexplorer.png" height="300px" id="logo"></img>
				</div>
				<div class="col span_4_of_8" id="ribbutton">
					 	<button onclick="location.href='#'">Start to help advance science</button>
				</div>	

			</div>
			
			<div class="section group scrollto"  id="info">
				<div class="col span_4_of_8">
					<div class="textblock">
					<H1>About {{ Lang::get('gamelabels.gamename') }}</H1>
					<p>BioCrowd is a crowdsourcing platform where biology experts annotate microscopic images. Different annotation tasks 
					are represented in various mini-games, such as counting of cells, localization of colonies and classification of vesicle locations. 
					These are domain specific tasks that require expertise beyond what the general crowd can provide. We employ a variety of gaming 
					elements such as badges, points and levels in order to motivate and optimize the experts effort. BioCrowd is part of our CrowdTruth 
					pipeline where machine processing, paid crowdsourcing and nichesourcing come together. BioCrowd aims to engage an active community 
					of experts, to advance biology and specifically cancer research.</bold></p>
					</div>	
				</div>
				<div class="col span_4_of_8">
					<img src="img/glyphs/image_video.png" width="75%" style="padding-left: 15px;"></img>	
				</div>	
			</div>
		
			<div class="section group scrollto" id="campaigns">
				<div class="col span_4_of_8">
					<H1 class="sectiontitle"><strong>Active Now</strong></H1>
					<div id="campaignProgress">
						<div id="progress"><div class="bar" style="width: 50%;">50%</div></div>
						<div id="progress"><div class="bar" style="width: 30%;">30%</div></div>
						<div id="progress"><div class="bar" style="width: 20%;">20%</div></div>
					</div>
				</div>
				<div class="col span_4_of_8">
				<H1 class="sectiontitle"><strong>Campaigns</strong></H1>
				<div class="textblock">
					<p>Some annotations have a more pressing need to be done. This is where campaigns come in; 
					If you do all the games of a campaign you will get a bonus score for finishing the campaign. 
					Try the tutorial campaign, it entails playing all minigames at least once. </p>
					</div>
				</div>	
			</div>
				<div class="section group scrollto" id="games">
					<div class="col span_8_of_8">
						<h1 class="sectiontitle">
							<strong>Level 1</strong>
						</h1>
						<div align="center">
						<ul id="gameslist ">
							<li><a data-ftrans="slide" href="#"><img
									alt="Cell tagging" src="img/icons/image_games-02.png"
									width="120px" />Cell tagging</a></li>
							<li><a data-ftrans="slide" href="#"><img
									alt="Cell tagging" src="img/icons/image_games-03.png"
									width="120px" />Lorem Ipsum</a></li>
							<li><a data-ftrans="slide" href="#"><img
									alt="Cell tagging" src="img/icons/image_games-03.png"
									width="120px" />Lorem Ipsum</a><img src=""
								alt=""></img></li>
							<li><a data-ftrans="slide" href="#"><img
									alt="Cell tagging" src="img/icons/image_games-03.png"
									width="120px" />Lorem Ipsum</a><img src=""
								alt=""></img></li>
							<li><a data-ftrans="slide" href="#"><img
									alt="Cell tagging" src="img/icons/image_games-03.png"
									width="120px" />Lorem Ipsum</a><img src=""
								alt=""></img></li>
						</ul>
						</div>
					</div>

				</div>


	</div>
@stop
