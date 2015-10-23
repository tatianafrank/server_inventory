<?php 
include 'crud.php';

// if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' )
// {

//   // THIS ISNT WORKING BUT EVENTUALLY MOVE ALL CODE INTO THIS IF STATEMENT
// }
	if (!empty($_POST['action']) &&!empty($_POST['resource'])) {
		if ($_POST['action'] == 'selectAll') {
			$tbl = $_REQUEST['resource'];
			$crud = new Crud();
			$crud->selectAll($tbl);
		}


		if ($_REQUEST['action'] == 'show'){
			$tbl = $_REQUEST['tbl'];
			$id = intval($_REQUEST['id']);
			$crud = new Crud();
			$crud->show($tbl, $id);
		} 

		if ($_REQUEST['action']=='addNew') {
			$tbl = $_REQUEST['tbl'];
			$crud = new Crud();
			$crud->addNew($tbl);
		}

		// if ($_REQUEST['action']=='listResource') {
		// 	$tbl = $_REQUEST['resource'];
		// 	$crud = new Crud();
		// 	$crud->listResource($tbl);
		// }
	}
	else if (!empty($_POST['action'])) {
		if ($_POST['action'] == 'showAllData') {
			// $tbl = $_REQUEST['resource'];
			$crud = new Crud();
			$crud->showAllData();
		}
	}
