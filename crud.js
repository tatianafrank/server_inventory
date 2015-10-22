
$(document).ready(function(){
	selectAll('server');
	//on load show whole database
	//listresource($server) join on client ids and domain ids 

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
			});
	    // xmlhttp.open("GET","api.php?resource="+resource+"&action=listAll",true);
	    // xmlhttp.send();
		}
	}
});