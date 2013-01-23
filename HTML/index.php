<!doctype html>
<html lang="us">
<head>
	<?php
		$dbHost ="localhost";
		$dbUser = "root";
		$dbPass = "usbw"; 
		$dbDatabase = "ig"; 
		$db = mysql_connect("$dbHost", "$dbUser", "$dbPass") or die ("Error connecting to database."); 
		
		mysql_select_db("$dbDatabase", $db) or die ("Couldn't select the database.");
		$mysqli = new mysqli("$dbHost", "$dbUser", "$dbPass", "$dbDatabase");
		
		if ($mysqli->connect_errno) {
			echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}
	?>
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>iGoogle Replacement</title>

	<meta name="author" content="">
	<meta name="description" content="">
	
	<link href="css/smoothness/jquery-ui-1.9.2.custom.css" rel="stylesheet"/>
	
	<!-- Mobile -->
	
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="apple-touch-icon" href="theme/touch-icon-iphone.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="theme/touch-icon-ipad.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="theme/touch-icon-iphone4.png" />
    
    <link rel="apple-touch-startup-image" href="theme/startup.jpg" media="screen and (min-device-width: 200px) and (max-device-width: 480) and (orientation:portrait)"> <!-- iPod/Phone 320 x 460 image -->
    <link rel="apple-touch-startup-image" href="theme/startup-iPad-portrait.jpg" media="(device-width: 768px) and (orientation: portrait)" /> <!--iPad Portrait 768 x 1004 -->
    <link rel="apple-touch-startup-image" href="theme/startup-iPad-landscape.jpg" media="(device-width: 768px) and (orientation: landscape)" /> <!--iPad LandScape 1024 x 748--> 
    
	
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="default" />
	
	<meta name="HandheldFriendly" content="True" />
	<meta id="Viewport" name="viewport" width="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
	
	<!--<link href="css/bootstrap.min.css" rel="stylesheet"/>-->
	<link href="css/style.css" rel="stylesheet/less"/>
	<script src="js/jquery-1.8.3.js"></script>
	<script src="js/jquery-ui-1.9.2.custom.min.js"></script>
	<script src="js/jquery.zrssfeed.min.js"></script>
	<script src="js/jquery.zweatherfeed.min.js"></script>
	<!--<script src="js/bootstrap.min.js"></script>-->
	<script type="text/javascript">
		$(function(){
			jQuery.fn.reverse = [].reverse;
			
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
	var ww = ( $(window).width() < window.screen.width ) ? $(window).width() : window.screen.width; //get proper width
	var mw = 480; // min width of site
	var ratio =  ww / mw; //calculate ratio
	if( ww < mw){ //smaller than minimum size
		$('#Viewport').attr('content', 'initial-scale=' + ratio + ', maximum-scale=' + ratio + ', minimum-scale=' + ratio + ', user-scalable=yes, width=' + ww);
	}else{ //regular size
		$('#Viewport').attr('content', 'initial-scale=1.0, maximum-scale=2, minimum-scale=1.0, user-scalable=yes, width=' + ww);
	}
}
			
			/*
			$('#sortable > li').each(function(index){
			
				if( !$(this).find('.itemProperties').length ){
					$(this).append('<div class="itemProperties"><input class="columnOrder" name="master_column_' + index +'" value="' + index + '"/></div>');
				}
				
				if( $(this).find(' > ul >li').length != 0 ){
					$(this).find(' > ul >li').each(function(ind){
						if( !$(this).find('.itemProperties').length ){
							$(this).append('<div class="itemProperties"><input class="blockId" name="block_item_' + ind +'" value="' + ind + '"/><input class="blockOrder" name="block_item_order_' + ind +'" value="' + ind + '"/><input class="block_parent" name="block_item_parent_' + ind +'" value="' + index + '"/></div>');
						}
					});
				}
				
			});
			
			function reIndexAndSave(){
				 $('#sortable > li').each(function(index){
					if( $(this).find('.itemProperties').length ){
						var o = $(this).find('.itemProperties > .columnOrder').attr('value');
						if( o != index ){
							//console.log("Column " + o + " moved to position " + index );
							//update
						}
					}
				 
					if( $(this).find('> ul > li').length > 0 ){
						
						//parent != block_parent
						//blockOrder != ind
						//blockid = blockId
					}
				 });
			}
			
		
			$('#sortable').sortable({
				placeholder: "ui-state-highlight",
				handle: 'h4',
				 stop: function() {
					reIndexAndSave();
				 }
			});
			
			$('#sortable > li > ul').sortable({
				placeholder: "ui-state-highlight",
				connectWith: "#sortable > li > ul",
				handle: 'div.block',
				 stop: function() {
					reIndexAndSave();
				 }
			});
			
			//$( "#sortable, #sortable > li > ul" ).disableSelection();
			*/
			$('.rssFeed').each(function(index){
				if( $(this).attr('data-feed').length ){
					var feed = $(this).attr('data-feed');
					var count = 5;
					if( $(this).attr('data-count') != undefined ){
						count = parseInt($(this).attr('data-count'));
					}
					$(this).rssfeed(feed, {
						limit: count,
						linktarget: '_blank'
					});
				}
			});
			
			
			// Does this browser support geolocation?
			
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(locationSuccess, locationError);
			}
			else{
				showError("Your browser does not support Geolocation!");
			}

			var geocode = "";
			function locationSuccess(position) {
				var lat = position.coords.latitude;
				var lon = position.coords.longitude;
				var APPID = "12345";
				var geoAPI = 'http://where.yahooapis.com/geocode?location='+lat+','+lon+'&flags=J&gflags=R&appid='+APPID;
			
				$.getJSON(geoAPI, function(r){
					if(r.ResultSet.Found == 1){
						geocode = r.ResultSet.Results[0].woeid;
					}
				});
				// We will make further requests to Yahoo's APIs here
			}

			function locationError(error){
				switch(error.code) {
					case error.TIMEOUT:
						showError("A timeout occured! Please try again!");
						break;
					case error.POSITION_UNAVAILABLE:
						showError('We can\'t detect your location. Sorry!');
						break;
					case error.PERMISSION_DENIED:
						showError('Please allow geolocation access for this to work.');
						break;
					case error.UNKNOWN_ERROR:
						showError('An unknown error occured!');
						break;
				}
			}

			function showError(msg){
				weatherDiv.addClass('error').html(msg);
			}
			
			
			if( geocode == ""){
				$('#weather').weatherfeed(['CAXX0181'],{ /*Your Weather code here!*/
					unit: 'c',
					image: true,
					country: false,
					highlow: true,
					wind: true,
					humidity: true,
					visibility: true,
					sunrise: true,
					sunset: true,
					forecast: false,
					link: false
				});
			}else{
				$('#weather').weatherfeed(geocode,{
					unit: 'c',
					image: true,
					country: false,
					highlow: true,
					wind: true,
					humidity: true,
					visibility: true,
					sunrise: true,
					sunset: true,
					forecast: false,
					link: false
				});
			}
			
			$('#saveNotes').click(function(event){
				event.preventDefault();
				var jsonObj = {note: $('#Notes').attr('value') }
				var postData = JSON.stringify(jsonObj);
				var postArray = { json:postData };
				
				$.ajax({
					type: 'POST',
					url: "saveNote.php",
					data: postArray,
					success: function(data){
						$('#noteMessage').html(data).fadeIn(2500).fadeOut(2500);
					}
				});
			});
			
		});
	</script>
	<script src="js/less-1.3.1.min.js"></script>
</head>
<body class="pageBody">
	<div id="content">
		
		<div id="topLinks">
			<ul>
				<li>
					<a href="https://mail.google.com" target="_blank" >Gmail</a>
				</li>
				
				<li>
					<a href="https://plus.google.com/u/0/" target="_blank" >Google+</a>
				</li>
				<li>
					<a href="https://www.youtube.com" target="_blank" >Youtube</a>
				</li>
				<li>
					<a href="http://www.google.com/imghp?hl=en&tab=mi" target="_blank" >Images</a>
				</li>
				<li>
					<a href="https://maps.google.com/maps?hl=en" target="_blank" >Maps</a>
				</li>
				<li>
					<a href="https://play.google.com/store?hl=en&tab=l8" target="_blank" >Play</a>
				</li>
				<li>
					<a href="https://www.google.com/calendar/render?tab=8c" target="_blank" >Calendar</a>
				</li>
					
			</ul>
		
		</div>
		
	
		<div id="googleSearch">
		
			<form method="get" action="http://www.google.com/search">
				<input type="text" name="q" maxlength="255" value="" />
				<input type="submit" value="Search" />
			</form>
		
		</div>
		
		<ul id="sortable">
			<li class="ui-state-default">
				<h4>News</h4>
				<ul>
				<li>
					<div class="block">
						<div class="blocktitle"><a href="">Gizmodo</a></div>
						<div class="rssFeed" data-feed="http://www.gizmodo.com/index.xml"></div>
					</div>
				</li>
					
				<li>
					<div class="block">
						<div class="blocktitle"><a href="">Life Hacker</a></div>
						<div class="rssFeed" data-feed="http://lifehacker.com/index.xml"></div>
					</div>
				</li>
					
				<li>
					<div class="block">
						<div class="blocktitle"><a href="">Engadget</a></div>
						<div class="rssFeed" data-feed="http://www.engadget.com/rss.xml"></div>
					</div>
				</li>

				<li>
					<div class="block">
						<div class="blocktitle"><a href="">Techdirt</a></div>
						<div class="rssFeed" data-feed="http://feeds.feedburner.com/techdirt/feed"></div>
					</div>
				</li>
				
				
				<li>
					<div class="block">
						<div class="blocktitle"><a href="">Slashdot</a></div>
						<div class="rssFeed" data-feed="http://rss.slashdot.org/Slashdot/slashdot"></div>
					</div>
				</li>
				
				<li>
					<div class="block">
						<div class="blocktitle"><a href="">Inventorspot</a></div>
						<div class="rssFeed" data-feed="http://feeds.feedburner.com/inventorspot/articles"></div>
					</div>
				</li>
				
								<li>
					<div class="block">
						<div class="blocktitle"><a href="">College Humor</a></div>
						<div class="rssFeed" data-feed="http://www.collegehumor.com/originals/rss"></div>
					</div>
				</li>
				
				
				<li>
					<div class="block">
						<div class="blocktitle"><a href="">Onion News</a></div>
						<div class="rssFeed" data-feed="http://www.theonion.com/feeds/onn/"></div>
					</div>
				</li>
				
				
				</ul>
			</li>
			
			<li class="ui-state-default">
				<h4>Comics</h4>
				<ul>
				<li>
					<div class="block">
						<div class="blocktitle"><a href="">Cyanide and Happiness</a></div>
						<div class="rssFeed" data-feed="http://feeds.feedburner.com/Explosm"></div>
					</div>
				</li>
				
				<li>
					<div class="block">
						<div class="blocktitle"><a href="">Dilbert</a></div>
						<div class="rssFeed" data-feed="http://feed.dilbert.com/dilbert/daily_strip"></div>
					</div>
				</li>
				
				
				<li>
					<div class="block">
						<div class="blocktitle"><a href="">XKCD</a></div>
						<div class="rssFeed" data-feed="http://xkcd.com/rss.xml"></div>
					</div>
				</li>
				
				<li>
					<div class="block">
						<div class="blocktitle"><a href="">Bookmarks</a></div>
						<div class="bookmarks">
							<p>Torrents</p>
							<ul>
								<li><a href="http://torrentleech.org/torrents/browse" target="_blank">Torrent Leech</a></li>
								<li><a href="http://kat.ph/" target="_blank">Kick Ass Torrents</a></li>
								<li><a href="http://eztv.it/" target="_blank">EZTV Torrents</a></li>
								<li><a href="http://thepiratebay.se/" target="_blank">The Pirate Bay</a></li>
								<li><a href="http://isohunt.com/" target="_blank">ISO Hunt</a></li>
								<li><a href="http://www.rlslog.net/category/movies/" target="_blank">Release Log</a></li>
							</ul>
							
							<p>Sales</p>
							<ul>
								<li><a href="http://guelph.kijiji.ca/?rtlipmsg=1" target="_blank">Kijiji</a></li>
								<li><a href="http://www.ebay.com/" target="_blank">Ebay</a></li>
								<li><a href="http://www.newegg.ca/" target="_blank">New Egg</a></li>
								<li><a href="http://ncix.com/" target="_blank">NCIX</a></li>
								<li><a href="http://www.ebay.com/" target="_blank">Police Auctions</a></li>
							</ul>
							<p>Development</p>
							<ul>
								<li><a href="http://www.colorzilla.com/gradient-editor/" target="_blank">CSS3 Gradient Generator</a></li>
								<li><a href="http://css3gen.com/box-shadow/" target="_blank">Box Shadow Generator</a></li>
								<li><a href="http://css3gen.com/text-shadow/" target="_blank">Text Shadow Generator</a></li>
								<li><a href="http://border-radius.com/" target="_blank">Border Radius</a></li>
								<li><a href="http://jquery.com/" target="_blank">jQuery</a></li>
								<li><a href="http://jqueryui.com/" target="_blank">jQuery UI</a></li>
								<li><a href="http://lesscss.org/" target="_blank">less css</a></li>
								<li><a href="http://tools.dynamicdrive.com/favicon/" target="_blank">Favicon Generator</a></li>
							</ul>
							
						</div>
					</div>
				</li>
				
				</ul>
				
			</li>
			
			<li class="ui-state-default">
			  <h4>Local</h4>
				<ul>
					
					<li>
						<div class="block">
							<div class="blocktitle">
								<a href="">Weather</a>
							</div>
							<div id="weather"></div>
						</div>
					</li>
					
					<li>
						<div class="block">
							<div class="blocktitle">
								<a href="">Calendar</a>
							</div>
							<p>Put your Calendar embed here</p>
							<!--Put your calendar public url here
							<iframe src="" style=" border-width:0; min-height: 250px; width: 100%; " frameborder="0" scrolling="no"></iframe>
							-->
						</div>
					</li>

					<li>
						<div class="block">
							<div class="blocktitle">
								<a href="">Notes</a>
							</div>
							<form id="theNote">
								<div id="noteMessage"></div>
								<textarea id="Notes" style="width: 95%; min-height: 250px; display: block; overflow-y: auto;"><?php
									$notes  = mysql_query("Select `note` FROM `note` WHERE `note`.`id` = 1;");
									//if($notes){
										 while($note = mysql_fetch_assoc($notes) ){
											echo $note['note'];
										 }
									//}
								?></textarea>
								<p style="text-align: center"><input id="saveNotes" type="submit" value="Save" /></p>
							</form>
						</div>
					</li>
					
				</ul>
				
			</li>
		
		
		
		
		
		</ul>
	</div>
	
	
</body>
</html>