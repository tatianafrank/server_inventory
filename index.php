<?php
include 'api.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Servers</title>
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>

	<body>
		<center>
			<div id="header">
			</div>
			<br />
			<div class="createMessage">
			</div>
			<div id="tableWrapper">

			</div>
			<br><br>
			<!-- <div class="actions">
				<select class="actionDropdown">
					<option>
						Create
					</option>
				</select>
			</div>
			<div class="resources">
				<select class="resourceDropdown">
					<option>
						Server
					</option>
				</select>
			</div> -->
	<p>
    <form class="actionResource">
      <select id="resourceSelect" class="resourceSelect">
        <option>Resource...</option>
        <option value="client">Client</option>
        <option value="project">Project</option>
        <option value="server">Server</option>
      </select>

      <select id="actionSelect" class="actionSelect">      
        <option>Action...</option>
        <option value="selectAll">Show</option>
        <option value ="getForm">Create</option>
      </select> 
    </form>
  </p>
  <p>
  	<div class="formWrapper">
  		<form class="form">
  		</form>
  	</div>
  </p>
		</center>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script type="text/javascript" src="crud.js"></script>
		<script type="text/javascript" src="jquery.tablesorter.js"></script>

	</body>
</html>