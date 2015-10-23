
$(document).ready(function(){
	// selectAll('server');
	showAllData();


	//on load show whole database
	//listresource($server) join on client ids and domain ids 

	function showAllData(){
		var post = $.post( "api.php", { action: 'showAllData' }) 
			post.done(function(result){
				$( "#mainTable" ).html( result );
				if($('#mainTable').html() !== ""){
				$("#mainTablee").tablesorter();
				}

			});
	}


	function selectAll(rsc) { //formerly listresource
		if (rsc == "") {
			$('#mainTable').html("");
      // document.getElementById("mainTable").innerHTML = "";
      return;
	  } 
	  else { 
	    // var data = { resource: rsc, action: 'selectAll' };
	    var post = $.post( "api.php", { resource: rsc, action: 'selectAll' }) 
			post.done(function(result){
					console.log('done');
				$( "#mainTable" ).html( result );
				if($('#mainTable').html() !== ""){
				console.log('done2'); 
				$("#mainTablee").tablesorter();
				}

			});
	    // xmlhttp.open("GET","api.php?resource="+resource+"&action=listAll",true);
	    // xmlhttp.send();
		}
	}
});