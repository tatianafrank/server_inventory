<?php 
include 'crud.php';

// if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' )
// {

//   // THIS ISNT WORKING BUT EVENTUALLY MOVE ALL CODE INTO THIS IF STATEMENT
// }

	if (!empty($_REQUEST['action']) && !empty($_REQUEST['resource'])) {
		if ($_REQUEST['action'] == 'selectAll') {
			$tbl = $_REQUEST['resource'];
			$crud = new Crud();
			$crud->selectAll($tbl);
		}

		elseif ($_REQUEST['action'] == 'getForm') {
			$tbl = $_REQUEST['resource'];
			$crud = new Crud();
			$crud->getForm($tbl);
		}

		elseif ($_REQUEST['action'] == 'show'){
			$tbl = $_REQUEST['tbl'];
			$id = intval($_REQUEST['id']);
			$crud = new Crud();
			$crud->show($tbl, $id);
		} 

		elseif ($_REQUEST['action'] == 'addNew') {
			$tbl = $_REQUEST['tbl'];
			$crud = new Crud();
			$crud->addNew($tbl);
		}

		elseif ($_REQUEST['action'] == 'create'){
	  	$formData = $_REQUEST['data'];
	  	$rsc = substr($_REQUEST['resource'], 0, -4);
			$crud = new Crud();
			$crud->create($formData, $rsc);
		}
	}
	else if (!empty($_REQUEST['action'])) {
		if ($_REQUEST['action'] == 'showAllData') {
			// $tbl = $_REQUEST['resource'];
			$crud = new Crud();
			$crud->showAllData();
		}
	}
