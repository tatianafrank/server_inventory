window.server = {
	ready : function(){
		var self = this;
		crudAction = '';
		crudResource = '';
		$('#resourceSelect').on("change", this.crud.setResource.bind(this.crud));
		$('#actionSelect').on("change", this.crud.setAction.bind(this.crud));
		this.crud.selectAll('server');
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
	},
	status: false,
	crud : {
		setResource: function(e){
			crudResource = $(e.currentTarget).val();
			if (crudAction !== ''){
				this[crudAction](crudResource);
			}
		},
		setAction: function(e){
			crudAction = $(e.currentTarget).val();
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
				id = $(tdd).data('id');
				if (id > 0) {
					var field = $(tdd).data('field');
					var value = $(tdd).html();
					if ($(tdd).html() != '' && field != 'id'){
						if (Number.isInteger(value) === true) {
							params[field] = value;
						}
						else {
							params[field] = '"' + value + '"';
						}
					}
				}
				console.log(id);
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
				$('#tableWrapper').html("");

	    	return;
	  	} else { 

		    var post = $.post( "api.php", { resource: rsc, action: 'selectAll' }); 
				post.done(function(result){
					$( "#tableWrapper" ).html( result );

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