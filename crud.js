window.server = {
	ready : function(){
		crudAction = '';
		crudResource = '';
		$('#resourceSelect').on("change", this.crud.setResource.bind(this.crud));
		$('#actionSelect').on("change", this.crud.setAction.bind(this.crud));
		this.crud.selectAll('server');
		$('.form').on("submit", this.crud.submitForm.bind(this.crud));
	},
	status: false,
	crud : {
		setResource: function(e){
			crudResource = $(e.currentTarget).val();
			if (crudAction !== ''){
				this[crudAction](crudResource);
			}
		},
		setAction: function (e){
			crudAction = $(e.currentTarget).val();
			var funcSelect = this[crudAction](crudResource);			
		},

		getForm: function(rsc) {
			if (rsc !== "") {
				var post = $.post( "api.php", { resource: rsc, action: 'getForm' }); 
				post.done(function(result){
					$( ".form" ).html( result );

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
			var post = $.post( "api.php", { action: 'create', data: values, resource: $rsc });
			post.done(function(result){
				$( ".createMessage" ).html( result );
			});
		},

		selectAll: function (rsc) { //formerly listresource
			if (rsc == "") {
				$('#mainTable').html("");

	    	return;
	  	} else { 

		    var post = $.post( "api.php", { resource: rsc, action: 'selectAll' }); 
				post.done(function(result){
					$( "#mainTable" ).html( result );

					if($('#mainTable').html() !== ""){
						$("#mainTable").tablesorter();
					}

				});
			}
		}
	},	
	showAllData: function(){
		var post = $.post( "api.php", { action: 'showAllData' }) 
		post.done(function(result){
			$( "#mainTable" ).html( result );
			if($('#mainTable').html() !== ""){
			$("#mainTablee").tablesorter();
			}

		});
	}	
};

$(document).ready(window.server.ready.bind(window.server));