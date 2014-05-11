<?php
@include("config.php");
@include("functions.php");
@include("header.php");
?>
<div style="min-height: 500px;
margin: 0 auto;
width: 1100px;">
<?php if (isset($_COOKIE["email"])) { ?> 

	<div >
		<div style="float: left;">
			<div style="width: 250px; margin-right: 10px; border: 1px solid #D6D6D6; padding: 5px; margin-bottom: 5px;">
				Add a few movies to your Basket<br /><br />
				<input type="text" placeholder="Start typing a movie name..." name="movieName" id="movieName" style="width: 200px;" />
			</div>
			<div style="width: 250px; margin-right: 10px; border: 1px solid #D6D6D6; padding: 5px; margin-bottom: 5px;">
				Your Basket<br /><br />
				<div id="b1" style="display: none;">
					<br />
					<img src="images/18-0.gif" />
					<br />
				</div>	
				<div id="b1data" style="font-size: 11px;"></div>
				<br /><em><span style="font-size: 12px;">Click on a movie title to find about the people behind it</span></em>
			</div>
			<div style="width: 250px; margin-right: 10px; border: 1px solid #D6D6D6; padding: 5px; margin-bottom: 5px;">
				Movie Recommendations
				<br />
				<span style="font-size: 11px;">Rate all movies on a scale of 1 to 9 in your basket to get correct recommendations</span>
				<div id="b2" style="display: none;">
					<br />
					<img src="images/18-0.gif" />
					<br />
				</div>
				<div><br /><input type="submit" id="movieReco" value="Get Recommendations"/><br /></div>
				<div id="b2data" style="font-size: 11px; padding-top: 10px;"></div>
			</div>
			<div style="clear: both;"></div>
			
			<input type="hidden" id="movieTyped" />
			<input type="hidden" id="actorTyped" />
		</div>

		<div style="float: left; width: 500px;">
			<span style="font-size: 20px; margin-left: 20px;">Charts</span>
			<canvas id="myChart" width="500" height="250" style="margin-top: 20px;"></canvas>
			<br />
			<div id="movieInfo" style="width: 470px; margin-top: 20px; padding: 10px; border: 1px solid #D6D6D6; display: none;">
				
			</div>

		</div>

		<div style="float: left; ">
	

			<div style="width: 250px; margin-right: 10px; border: 1px solid #D6D6D6; padding: 5px;  margin-bottom: 5px;">
				Add a few Actors to your Basket<br /><br />
				<input type="text" placeholder="Start typing a actor name..." name="actorName" id="actorName" style="width: 200px;" />
			</div>
			<div style="width: 250px; margin-right: 10px; border: 1px solid #D6D6D6; padding: 5px;  margin-bottom: 5px;">
				Your Actor Basket<br /><br />
				<div id="b3" style="display: none;">
					<br />
					<img src="images/18-0.gif" />
					<br />
				</div>
				<div id="b3data" style="font-size: 11px;"></div>		
				
			</div>
			<div style="width: 250px; margin-right: 10px; border: 1px solid #D6D6D6; padding: 5px;">
				Actor Recommendations
				<br />
				<span style="font-size: 11px;">Rate all actors in your basket to get correct recommendations for Actors to follow</span>
				<div id="b4" style="display: none;">
					<br />
					<img src="images/18-0.gif" />
					<br />
				</div>
				<div><br /><input type="submit" id="actorReco" value="Get Recommendations"/><br /></div>
				<div id="b4data" style="font-size: 11px; padding-top: 10px;"></div>				
			</div>

			<div style="width: 250px; margin-right: 10px; border: 1px solid #D6D6D6; padding: 5px; margin-top: 10px; font-size: 12px;">
				<span style="font-size: 16px;">Users</span>
				<br />			
				<?php
					$q = "SELECT distinct(username) FROM usertable";
					$r = mysql_query($q);
					while ($row = mysql_fetch_array($r)) {
						echo "<a href='switch.php?user=".$row["username"]."'>".$row["username"]."</a>         ";
					}
				?>
			</div>			

		</div>		

		<div style="clear: both;"></div>

	</div>

	<div id="loading" style="color: white; background: red; padding: 3px 10px; position: fixed; top: 0; right: 0; border-radius: 0;">
		loading...
	</div>

<?php } else { ?>
	Sign In to continue
<?php } ?>	
</div>
<?php if (isset($_COOKIE["email"])) { ?> 
	<script>
		$(function() {

			var dataf = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
			var datal = ["Documentary","Reality-TV","Comedy","Drama","Mystery","News","Sport","Sci-Fi","Family","Biography","Talk-Show","Game-Show","Music","Short","Adventure","War","Romance","Crime","Musical","Fantasy","Thriller","Horror","Animation","Action","History","Western","Adult","Lifestyle","Film-Noir","Experimental","Commercial"];
			loadChart(dataf,datal);

			$( document ).ajaxStart(function() {
				$("#loading").show();
			});

			$( document ).ajaxComplete(function() {
			 	$("#loading").hide();
			});			

			updateBaskets("movie");
			updateBaskets("actor");

			$( "#movieName" ).autocomplete({
			  source: "aj_search.php?datasource=movie",
			  minLength: 4,
			  change: function( event, ui ) {
				$("#movieTyped").val(this.value);
			  },
			  select: function( event, ui ) {
			    ui.item ? addToBasket("movie", ui.item.value, ui.item.id) :
			      console.log("Nothing selected, input was " + this.value) ;
			  }

			});

			$( "#actorName" ).autocomplete({
			  source: "aj_search.php?datasource=actor",
			  minLength: 4,
			  change: function( event, ui ) {
				$("#actorTyped").val(this.value);
			  },
			  select: function( event, ui ) {
			    
			    	ui.item ? addToBasket("actor", ui.item.value, ui.item.id) :
			      console.log("Nothing selected, input was " + this.value) ;
			  
				}
			});

			$(document).on('click', ".rateBtn1", function(){
				var id = $(this).attr("id").replace("basket-","");
				var rating = $("#basketval-"+id).val();
				if (rating != "") {
					$.post("aj_saverating.php", {id:id, rating:rating}, function(data){

						updateBaskets("movie");
					});					
				}
			});

			$(document).on('click', ".rateBtn2", function(){
				var id = $(this).attr("id").replace("basket-","");
				var rating = $("#basketval-"+id).val();
				if (rating != "") {
					$.post("aj_saverating.php", {id:id, rating:rating}, function(data){

						updateBaskets("actor");
					});					
				}
				
			});			

			$(document).on('click', ".movieBox", function(){
				var itemid = $(this).attr("id").replace("item-","");

				loadMovie(itemid);			

			});

			$(document).on('click', ".actorBox", function(){
				var itemid = $(this).attr("id").replace("item-","");

				loadActor(itemid);			

			});

			$(document).on('click', "#movieReco", function(){
				$("#b2").show();
				var movieList = [];			
				$.post("aj_getreco.php", {type:"movies"}, function(data){
				
					if (data == "[]") {
						alert ("Please add a few more movies to the basket");
					}
					datar = JSON.parse(data);
					out = '';
					$.each(datar, function(i, item) {
					    out += '<div><div style="width: 160px; margin-bottom: 5px; float:left; cursor: pointer;" class="movieBox" id="item-'+item.itemid+'">' + item.movie + '</div>';
						out += '<div style="width: 65px; float: right;">Score: ' + item.score + '</div>';
					    out += '<div style="clear: both"></div></div>';
					    movieList.push(item.itemid);

					});

					$.post("aj_getgenre.php", {list:movieList}, function(data){
					
						var dataf = [];
						var datal = [];

						dataj = JSON.parse(data);

						$.each(dataj, function(i, item) {
							dataf.push(item.value);
							datal.push(item.genre);
						});
						
						loadChart(dataf,datal);

						
					});

					$("#b2data").html(out);
					$("#b2").hide();
				});
			});

			$(document).on('click', "#actorReco", function(){
				$("#b4").show();
				var movieList = [];				
				$.post("aj_getreco.php", {type:"actor"}, function(data){
				
					if (data == "[]") {
						alert ("Please add a few more actors to the basket");
					}					
					datar = JSON.parse(data);
					out = '';

					$.each(datar, function(i, item) {
					    out += '<div><div style="width: 160px; margin-bottom: 5px; float:left; cursor: pointer;" class="actorBox" id="item-'+item.itemid+'">' + item.movie + '</div>';
						out += '<div style="width: 65px; float: right;">Score: ' + item.score + '</div>';
					    out += '<div style="clear: both"></div></div>';
					    movieList.push(item.itemid);
					});

					$("#b4data").html(out);
					$("#b4").hide();					

				});
			});	

		});

		function loadChart(dataFinal,dataLabel) {
			var ctx = document.getElementById("myChart").getContext("2d");
			var data = {
				labels : dataLabel,
				datasets : [
					{
						fillColor : "rgba(151,187,205,0.5)",
						strokeColor : "rgba(151,187,205,1)",
						data : dataFinal
					}
				]
			}	
			new Chart(ctx).Bar(data);		
		}

		function addToBasket(type, value, id) {
			$.post("aj_savetobasket.php", {type: type, value: value, id:id}, function(data){
			
				$("#actorName").val("");
				$("#movieName").val("");
				updateBaskets(type);
				if (type == "movie")
					loadMovie(id);
				else 
					loadActor(id);
			});
		}

		function loadMovie(itemid) {
				$.post("aj_getmovie.php", {id:itemid}, function(data){
					console.log(data);
					datar = JSON.parse(data);
					actorSnap = "";
					$.each(datar.actors,function(i, item) {
						actorSnap += '<div id="item-' + item.pid + '" class="actorBox actorContain">'+
							item.name + ' - ' + item.role 
						+'</div>';
					});

					out = '<div>'+
						'<div>'+
							'<span style="font-size: 25px;">'+datar.title+' (' + datar.production_year + ')</span><br />'+
							'<br /><b>'+datar.tagline+'</b><br />'+
							'<br />Genres: '+datar.genres+'<br />'+
							'<br /><span>Budget: '+datar.budget+'</span><br /><br /><b>Crew</b>'+
						'</div>'+
						'<div style="overflow-y: auto; margin-top: 20px;">' + actorSnap + 
						'<div style="clear: both"></div></div>'+
					'</div>';

					$("#movieInfo").html(out);
					$("#movieInfo").show();
				});				
		}

		function loadActor(itemid) {

				$.post("aj_getactor.php", {id:itemid}, function(data){

					datar = JSON.parse(data);
					actorSnap = "";
					$.each(datar.movies,function(i, item) {
						actorSnap += '<div id="item-' + item.itemid + '" class="movieBox actorContain">'+
							item.title + ' (' + item.production_year + ')' 
						+'</div>';
					});

					out = '<div>'+
						'<div>'+
							'<span style="font-size: 25px;">'+datar.name+' (Gender: ' + datar.gender + ')</span><br />'+
							'<br /><b>Roles: '+datar.roles+'</b><br />'+
							'<br /><span style="font-size: 13px;"><b>Bio:</b> '+datar.bio+'</span><br /><br /><b>Movies</b>'+
						'</div>'+
						'<div style="overflow-y: auto; margin-top: 20px;">' + actorSnap + 
						'<div style="clear: both"></div></div>'+
					'</div>';

					$("#movieInfo").html(out);
					$("#movieInfo").show();
				});				
		}		

		function updateBaskets(type) {
			if (type == "movie") {
				$("#b1").show();
				$.post("aj_getbasket.php", {type: type}, function(data){
					var movieList = [];	
					datar = JSON.parse(data);
					out = '';
					$.each(datar, function(i, item) {
					    out += '<div><div style="width: 160px; margin-bottom: 5px; float:left; cursor: pointer;" class="movieBox" id="item-'+item.itemid+'">' + item.value + '</div>';
					    if (parseInt(item.rating) == 0) {
					    	out += '<div style="width: 80px; float: right;">'+
					    			'<input type="text" id="basketval-'+item.id+'" placeholder="Rating" style="font-size: 11px; width: 40px; margin-right: 1px;" />' +
					    			'<input type="submit" class="rateBtn1" id="basket-'+item.id+'" value="Go" style="font-size: 11px; width: 30px;" />' +
					    			'</div>';	
					    }  else {
					    	out += '<div style="width: 65px; float: right;">You Rated: ' + item.rating + '</div>';
					    }
					    out += '<div style="clear: both"></div></div>';
					    movieList.push(item.itemid);

					});

					$.post("aj_getgenre.php", {list:movieList}, function(data){
					
						var dataf = [];
						var datal = [];

						console.log(data);

						dataj = JSON.parse(data);

						$.each(dataj, function(i, item) {
							dataf.push(item.value);
							datal.push(item.genre);
						});
						
						loadChart(dataf,datal);

						
					});

					$("#b1data").html(out);					
					$("#b1").hide();					
				});
			} else if (type == "actor") {
				$("#b3").show();
					$.post("aj_getbasket.php", {type: type}, function(data){
					datar = JSON.parse(data);
					out = '';
					$.each(datar, function(i, item) {
					    out += '<div><div style="width: 160px; margin-bottom: 5px; float:left; cursor: pointer;" class="actorBox" id="item-'+item.itemid+'">' + item.value + '</div>';
					    if (parseInt(item.rating) == 0) {
					    	out += '<div style="width: 80px; float: right;">'+
					    			'<input type="text" id="basketval-'+item.id+'" placeholder="Rating" style="font-size: 11px; width: 40px; margin-right: 1px;" />' +
					    			'<input type="submit" class="rateBtn2" id="basket-'+item.id+'" value="Go" style="font-size: 11px; width: 30px;" />' +
					    			'</div>';	
					    }  else {
					    	out += '<div style="width: 65px; float: right;">You Rated: ' + item.rating + '</div>';
					    }
					    out += '<div style="clear: both"></div></div>';

					});
					$("#b3data").html(out);	
					$("#b3").hide();					
				});				
			}
		}

	</script>		
<?php } ?>
<?php
@include("footer.php");