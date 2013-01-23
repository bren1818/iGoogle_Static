<!doctype html>
<html>
<head>
	<?php
		include("db.php");
	?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>iGoogle Replacement</title>

	<meta name="author" content="">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
		
	<link rel="shortcut icon" href="favicon.ico">
	<link href="css/smoothness/jquery-ui-1.9.2.custom.css" rel="stylesheet"/>
	<!--<link href="css/bootstrap.min.css" rel="stylesheet"/>-->
	<link href="css/style.css" rel="stylesheet/less"/>
	<script src="js/jquery-1.8.3.js"></script>
	<script src="js/jquery-ui-1.9.2.custom.min.js"></script>
	<script src="js/jquery.zrssfeed.min.js"></script>
	<script src="js/jquery.zweatherfeed.min.js"></script>
	<!--<script src="js/bootstrap.min.js"></script>-->
	<script type="text/javascript">
	geocode = "";
	$(function(){
			// Does this browser support geolocation?
		
			
		
	
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
							console.log("Column " + o + " moved to position " + index );
							//update
						}
					}
				 
					if( $(this).find('> ul > li').length > 0 ){
						//console.log("has child");
						//parent != block_parent
						//blockOrder != ind
						//blockid = blockId
					}
				 });
			}
			
		
			$('#sortable').sortable({
				placeholder: "ui-state-highlight",
				 stop: function() {
					reIndexAndSave();
				 }
			});
			
			$('#sortable > li > ul').sortable({
				placeholder: "ui-state-highlight",
				connectWith: "#sortable > li > ul",
				 stop: function() {
					reIndexAndSave();
				 }
			});
			
			//$( "#sortable, #sortable > li > ul" ).disableSelection();
			
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
			
			
			
			/*
			if( geocode == ""){
				$('#weather').weatherfeed(['CAXX0181'],{
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
			}*/
			
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(locationSuccess, locationError);
				console.log("has geolocation");
			}
			else{
				showError("Your browser does not support Geolocation!");
			}

			
			function locationSuccess(position) {
				var lat = position.coords.latitude;
				var lon = position.coords.longitude;
				var APPID = "12345";
				var geoAPI = 'http://where.yahooapis.com/geocode?location='+lat+','+lon+'&flags=J&gflags=R&appid='+APPID;
			
				//console.log( geoAPI);
			
				$.getJSON(geoAPI, function(r){
					//console.log("in get");
					if(r.ResultSet.Found == 1){
						//console.log("in result");
						var geocode = r.ResultSet.Results[0].woeid;
						console.log(geocode);
						console.log( r.ResultSet.Results[0] );
						$('#weather_local').weatherfeed(r.ResultSet.Results[0].woeid,{
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
				console.log(msg);
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
			
			
			function updateForm(){
				var option = $('#moduleType').find("option:selected").attr('value');
				$('form#addModule').removeAttr('class');
				switch(option){
					case "Feed":
						$('form#addModule').addClass('showIfFeed');
					break;
					default:
				}
			}
			
			//$('#moduleType').focus(function(){ updateForm(); });	
			$('#moduleType').change(function(){ updateForm(); });
				
				
			$('#saveModule').click(function(event){
				event.preventDefault();
				var postData = JSON.stringify( $('#addModule').serializeArray() );
				var postArray = { json:postData };
				
				$.ajax({
					type: 'POST',
					url: "addModule.php",
					data: postArray,
					success: function(data){
						//$('#noteMessage').html(data).fadeIn(2500).fadeOut(2500);
						if( data == "Ok"){
							saveOk();
						}else{
							window.alert("There was an error saving.");
						}
					}
				});
			});
		});
		
		
		
		function addModule(parent){
			//window.alert("Add a module to " + parent);
			$(function(){
				$("html, body").animate({ scrollTop: "0px" });
				$('input[name="moduleParent"]').attr('value', parent);
				$('#addModule').show();
				$('#addStuff').show();
			});
		}
		
		function addColumn(order){
			//window.alert("Add Column!");
			if( order == ""){ order = 0; }
			var title = prompt("Please enter a title for this column","");
			$(function(){
				var postData = { add: "column", order: order, title: title };
				var postArray = { json:postData };
				
				$.ajax({
					type: 'POST',
					url: "addColumn.php",
					data: postArray,
					success: function(data){
						if( data == "Ok"){
							location.reload(true);
						}else{
							window.alert("There was an error adding a column.");
						}
					}
				});
			});
		}
		
		
		
		function saveOk(){
			//$(function(){
				window.alert("Save Successful");
				location.reload(true);
				//$('#addStuff, #addStuff > form').hide();
				//$('#addStuff > form input').not('#saveModule').attr('value', '');
			//});
		}
		
	</script>
	<script src="js/less-1.3.1.min.js"></script>
</head>
<body>
	<div id="addStuff" style="display: none;">
		<form id="addColumn" style="display: none;">
			
		</form>
		<form id="addModule" style="display: none;">
			<table width="400">
			<tr>
				<td>Type:</td>
				<td>
					<select id ="moduleType" name="moduleType">
						<option value=""></option>
						<option value="Feed">Feed</option>
						<option value="localWeather">local Weather</option>
						<option value="setWeather">set Weather</option>
					</select>
				</td>
			</tr>
			<tr class="showIfFeed">
				<td>Feed Name</td>
				<td><input type="text" name="feedName" value="" /></td>
			</tr>
			<tr class="showIfFeed">
				<td>Feed URL</td>
				<td><input type="text" name="feedURL" value="" /></td>
			</tr>
			<tr class="showIfFeed">
				<td>Num Articles to Show</td>
				<td><input type="number" name="feedCount" value="5" /></td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="hidden" name="moduleParent" value="1"/>
					<input type="submit" id="saveModule" value="Save" />
				</td>
			</tr>
			</table>
		</form>
	</div>
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
			<?php
				function renderWeather($moduleId){
					$feeds  = mysql_query("Select * FROM `weather` WHERE `weather`.`moduleId` = $moduleId");
					while($feed = mysql_fetch_assoc($feeds) ){
						?>
							<li>
							<?php if(  $feed['GeoCode'] != "local" ){ ?>
								<div class="block">
									<div class="blocktitle">
										<a href="">Weather</a>
									</div>
									<div id="weather_<?php echo $moduleId; ?>"></div>
								</div>
								<script type="text/javascript">
									$(function(){
										$('#weather_<?php echo $moduleId; ?>').weatherfeed(['<?php echo $feed['GeoCode']; ?>'],{
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
									});
								</script>	
								<?php }else{ ?>
									<div class="block">
									<div class="blocktitle">
										<a href="">Weather</a>
									</div>
									<div id="weather_local"></div>
								</div>
								<?php } ?>
									
							</li>
						
						<?php
					}
				}
				
				function renderFeeds($moduleId){
					$feeds  = mysql_query("Select * FROM `newsfeed` WHERE `newsfeed`.`id` = $moduleId");
					while($feed = mysql_fetch_assoc($feeds) ){
					?>
						<li>
						<div class="block">
							<div class="blocktitle"><a target="_blank" href="<?php echo $feed['feedUrl']; ?>"><?php echo $feed['feedName']; ?></a></div>
							<div class="rssFeed" data-count="<?php echo $feed['numArticles']; ?>" data-feed="<?php echo $feed['feedUrl']; ?>"></div>
						</div>
						</li>
					<?php
					//INSERT INTO `ig`.`newsfeed` (`id`, `feedName`, `feedUrl`, `numArticles`) VALUES (NULL, 'GizModo', 'http://www.gizmodo.com/index.xml', '10');
					}
			
				}
				
				function renderModules($parent){
					$modules  = mysql_query("Select * FROM `modules` WHERE `modules`.`parent` = $parent order by `modules`.`order`");
					while($module = mysql_fetch_assoc($modules) ){
						//make this a switch
						if( $module['moduleType'] == "1"){
							//newsFeed!
							renderFeeds($module['id']);
						}else if( $module['moduleType'] == "2" || $module['moduleType'] == "3"){
							renderWeather($module['id']);
						}
					}
					//INSERT INTO `ig`.`modules` (`id`, `moduleType`, `parent`, `order`) VALUES ('1', '1', '1', '1');
					echo "<li><a class='addModule' onclick='addModule($parent)'>Add Module</a></li>";
				}
				
				function renderColumns(){
					$columns  = mysql_query("Select * FROM `columnblocks` order by `columnblocks`.`order`");
					while($column = mysql_fetch_assoc($columns) ){
					?>
						<li class="ui-state-default">
							<h4><?php echo $column['Name']; ?></h4>
							<ul>
							<?php
								renderModules($column['id']);
							?>
							</ul>
							<?php
							echo "<a class='addColumn' onclick='addColumn(".$column['order'].")'>Add Column</a>";
							?>
						</li>
					<?php
						//echo "<li class='addColumn'><a class='addColumn' onclick='addColumn(".$column['order'].")'>Add Column</a></li>";
					}
				}
			
			renderColumns();
			
			?>
		</ul>
		</div>
	<div class="clear" style="width: 100%; text-align: center;"><a onclick='$("html, body").animate({ scrollTop: "0px" });'>Scroll top</a></div>
	<div id="weather_local"></div>
</body>
</html>