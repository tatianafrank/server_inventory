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
			<ul id="navigation"> <!-- the navigation menu -->
				<li><a class="selects" href="#selectAll" value="server">Servers</a></li> <!-- a few navigation buttons -->
				<li><a class="selects" href="#selectAll" value="client">Clients</a></li>
				<li><a class="selects" href="#selectAll" value="project">Projects</a></li>
			</ul>
		
			<div id="tableWrapper">

			</div>


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
  	</div>
  </p>
		</center>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script type="text/javascript" src="crud.js"></script>
		<script type="text/javascript" src="jquery.tablesorter.js"></script>

	</body>
</html>