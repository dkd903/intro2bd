<?php
@include("config.php");
@include("functions.php");
@include("header.php");
?>
<div style="min-height: 500px;">
<?php if (isset($_COOKIE["email"])) { ?> 

	<div style="float: left; width: 250px; margin-right: 10px; border: 1px solid grey; padding: 5px;">
		Add a few movies to your Basket<br /><br />
		<input type="text" placeholder="Start typing a movie name..." name="movieName" id="movieName" style="width: 200px;" />
	</div>
	<div style="float: left; width: 250px; margin-right: 10px; border: 1px solid grey; padding: 5px;">
		Your Basket<br /><br />
		<div id="b1" style="display: none;">
			<br />
			<img src="images/18-0.gif" />
			<br />
		</div>	
		<div id="b1data" style="font-size: 11px;"></div>	
	</div>
	<div style="float: left; width: 250px; margin-right: 10px; border: 1px solid grey; padding: 5px;">
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

	<br /><br />

	<div style="float: left; width: 250px; margin-right: 10px; border: 1px solid grey; padding: 5px;">
		Add a few Actors to your Basket<br /><br />
		<input type="text" placeholder="Start typing a actor name..." name="actorName" id="actorName" style="width: 200px;" />
	</div>
	<div style="float: left; width: 250px; margin-right: 10px; border: 1px solid grey; padding: 5px;">
		Your Actor Basket<br /><br />
		<div id="b3" style="display: none;">
			<br />
			<img src="images/18-0.gif" />
			<br />
		</div>
		<div id="b3data" style="font-size: 11px;"></div>		
		
	</div>
	<div style="float: left; width: 250px; margin-right: 10px; border: 1px solid grey; padding: 5px;">
		Movie Recommendations by Actor
		<br />
		<span style="font-size: 11px;">Rate all actors in your basket to get correct recommendations</span>
		<div id="b4" style="display: none;">
			<br />
			<img src="images/18-0.gif" />
			<br />
		</div>
		<div><br /><input type="submit" id="actorReco" value="Get Recommendations"/><br /></div>
		<div id="b4data" style="font-size: 11px;"></div>				
	</div>
	<div style="clear: both;"></div>	
	<input type="hidden" id="movieTyped" />
	<input type="hidden" id="actorTyped" />

<?php } else { ?>
	Sign In to continue
<?php } ?>	
</div>
<?php if (isset($_COOKIE["email"])) { ?> 
	<script>
		$(function() {

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
						console.log(data);
						updateBaskets("movie");
					});					
				}
			});

			$(document).on('click', ".rateBtn2", function(){
				var id = $(this).attr("id").replace("basket-","");
				var rating = $("#basketval-"+id).val();
				if (rating != "") {
					$.post("aj_saverating.php", {id:id, rating:rating}, function(data){
						console.log(data);
						updateBaskets("actor");
					});					
				}
				
			});			

			$(document).on('click', ".movieBox", function(){
				console.log($(this).attr("id").replace("item-",""));
			});

			$(document).on('click', "#movieReco", function(){
				$("#b2").show();
				$.post("aj_getreco.php", {type:"movies"}, function(data){
					console.log(data);
					datar = JSON.parse(data);
					out = '';
					$.each(datar, function(i, item) {
					    out += '<div><div style="width: 160px; margin-bottom: 5px; float:left; cursor: pointer;" class="movieBox" id="item-'+item.itemid+'">' + item.movie + '</div>';
						out += '<div style="width: 65px; float: right;">Score: ' + item.score + '</div>';
					    out += '<div style="clear: both"></div></div>';

					});
					$("#b2data").html(out);
					$("#b2").hide();
				});
			});

			$(document).on('click', "#actorReco", function(){
				$("#b4").show();
				$.post("aj_getreco.php", {type:"actor"}, function(data){
					console.log(data);
					$("#b4").hide();
				});
			});	

		});

		function addToBasket(type, value, id) {
			$.post("aj_savetobasket.php", {type: type, value: value, id:id}, function(data){
				console.log(data);
				$("#actorName").val("");
				$("#movieName").val("");
				updateBaskets(type);
			});
		}

		function updateBaskets(type) {
			if (type == "movie") {
				$("#b1").show();
				$.post("aj_getbasket.php", {type: type}, function(data){
					console.log(data);
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
					    out += '<div><div style="width: 160px; margin-bottom: 5px; float:left; cursor: pointer;" class="movieBox" id="item-'+item.itemid+'">' + item.value + '</div>';
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