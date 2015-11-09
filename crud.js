window.server = {
	ready : function(){
		var self = this;
		lasturl="";	//here we store the current URL hash
		crudAction = '';
		crudResource = '';

		$('.form').on("submit", this.crud.submitForm.bind(this.crud));
		$('#tableWrapper').on("click", '.edit',  function(e){
			self.crud.edit(e);
		});
		$('#tableWrapper').on("click", '.save',  function(e){
			self.crud.update(e);
		});
		$('#tableWrapper').on("click", '.delete',  function(e){
			self.crud.delete(e);
		});

		//new event handlers
	// this.crud.checkURL();	//check if the URL has a reference to a page and load it
	// setInterval("this.crud.checkURL()",250);	//check for a change in the URL every 250 ms to detect if the history buttons have been used
	$('a.selects').click(function (e){	//traverse through all our navigation links..
			self.crud.checkURL(e);	//.. and assign them a new onclick event, using their own hash as a parameter (#page1 for example)	
	});

	$('#tableWrapper').on("click", '.addNew', function(e){
		self.crud.checkURL(e);
	});

	$('#tableWrapper').on("click", '.formSubmit', function(e){
		self.crud.submitForm(e);
	});

		//end of new event handlers

	},

	status: false,
	crud : {

		//NEW functions


		checkURL: function(e){
			var hash = $(event.target).attr('href');
			if(hash != lasturl)	// if the hash value has changed
			{
	  		lasturl=hash.replace('#','');
				this.setResource(e);

			}
		},

		//end of NEW functions


		setResource: function(e){
			crudResource = $(event.target).attr('value');
			crudAction = lasturl;
			if (crudAction !== ''){
				this[crudAction](crudResource);

			}
		},
		setAction: function(e){
			crudAction = lasturl;
			this[crudAction](crudResource);			
		},
		edit: function(e) {

			$(e.currentTarget.parentNode).find('td').each(function(i, td){
				var value = $(td).attr('contenteditable');

		    if (value == 'false') {
		        $(td).attr('contenteditable','true');
		    }
		    else {
		        $(td).attr('contenteditable','false');
		    }
			});
		},
		update: function(e) {
			var params = {};
			var id = 0;
			$(e.currentTarget.parentNode).find('td').each(function(i, tdd){
				if ($(tdd).data('id') > 0) {
					id = $(tdd).data('id');
					var field = $(tdd).data('field');
					var value = $(tdd).html();
					var dropdown = $(tdd).data('dropdown');
					if ($(tdd).html() != '' && field != 'id'){
						if (dropdown > 0) {
							value = $(tdd).find('option:selected').html();
							console.log($(tdd).html());
						}
						else {		
							if (Number.isInteger(value) === true) {
								params[field] = value;
							}
							else {
								params[field] = '"' + value + '"';
							}
						}
					}
				}
			});
			params['published'] = 1;
			
			crudResource = $('#mainTable').data('table');
			crudAction = 'update';

			var post = $.post( "api.php", { resource: crudResource, action: crudAction, params: params, id: id}); 
			post.done(function(result){

				


				$( "#tableWrapper" ).html( result );
				if($('#tableWrapper').html() !== ""){
					$("#mainTable").tablesorter();
				}
			});
		},
		
		delete: function(e) {
			crudResource = $('#mainTable').data('table');
			crudAction = 'delete';
			var td = $(e.currentTarget.parentNode).find('td').first();
			var id = $(td).data('id');

			var post = $.post("api.php", { resource: crudResource, action: crudAction, id: id });
			post.done(function(result){
				$('.form').html(result);
			});
		},

		getForm: function(rsc) {
			if (rsc !== "") {
				var post = $.post( "api.php", { resource: rsc, action: 'getForm' }); 
				post.done(function(result){
					$( "#tableWrapper" ).html( result );

				});
			}
		},

		submitForm: function(e) {
			e.preventDefault();
			e.stopPropagation();
			$rsc = $('.formSubmit').attr('id');
			var values = {};
			$.each($('.form').serializeArray(), function(i, field) {
			    values[field.name] = field.value;
			});
			console.log(values);
			var post = $.post( "api.php", { action: 'create', data: values, resource: $rsc });
			post.done(function(result){
				alert(result);
			});
		},

		selectAll: function (rsc) { 
			if (rsc == "") {
				$('#tableWrapper').html("");
	    	return;
	  	} else { 

		    var post = $.post( "api.php", { resource: rsc, action: 'selectAll' }); 
				post.done(function(result){

					//original
					// $( "#tableWrapper" ).html( result );
					//original

					//new ajax

					if(parseInt(result)!=0)	//if no errors
					{
						$('#tableWrapper').html(result);	//load the returned html into pageContet
					}
					//new ajax

					if($('#tableWrapper').html() !== ""){
						$("#mainTable").tablesorter();
					}

				});
			}
		}
	},	
	showAllData: function(){
		var post = $.post( "api.php", { action: 'showAllData' }) 
		post.done(function(result){
			$( "#tableWrapper" ).html( result );
			if($('#tableWrapper').html() !== ""){
			$("#tableWrapper").tablesorter();
			}

		});
	}	
};

$(document).ready(window.server.ready.bind(window.server));