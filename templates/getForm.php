<?php 
include_once 'crud.php';
function formBuilder($results, $tbl) {
		$fields='';

		foreach($results as $result){
			$field = $result['Field'];
			$hasId = strpos($field, 'id');
			$has_id = strpos($field, '_id');
			$options = '';
			$shortField = substr($field, 0, -3);

				if ($field == 'we_host') {
					$fields .= 'Hosted by us?: <select class="createInput" name="we_host"><option value="true">True</option><option value="false">False</option></select></br>';
				}

		  	if (($hasId === false) && ($has_id === false) && ($field !=='we_host')&& ($field !== 'published')){
					$fields .= $field .':<input class="createInput" type="text" name="'. $field .'">' . '<br>';
				}
				else if($has_id !== false) {
					$sql = 'SELECT name, id FROM ' . $shortField; 
					$results = crud::fetchQuery($sql);
					foreach($results as $result) {
						$options .= '<option value="'. $result['id'] .'">'. $result['name'] .'</option>';
					}
					$fields .= $shortField .': <select class="createInput" name="'. $field .'">'. $options .'</select><br>';
				}
		}
		$formName = $tbl . "Form";
		$html = <<<EOT
		</br></br></br>
		<p class="createForm">
			<form class='form'>
				$fields
				<input id="$formName" class="formSubmit" type="submit">
			</form>
		</p>
EOT;

	echo $html;
}
