<?php
include_once 'crud.php';

function selectAllBuilder($results, $tbl) {


$fields = '';
$values = '';
$fieldCount = 0;
$valueCount = 0;

while ($result = $results->fetch_assoc()) {
			foreach($result as $field=>$value)
			{
				if ($field == 'id') {
					$id = $value;
				}
				else if ($field !== 'published')  {
					if (strpos($field, "_id")){
						if (strpos($fields, substr($field, 0, -3)) === false) 
						{
							$fields .= '<th>' . substr($field, 0, -3) . '</th>';
						} 
					} else {
							if (strpos($fields, $field) === false) 
							{
								$fields .= '<th>' . $field . '</th>';
								
							}
					}
					
					$fieldCount ++;
				}
			}

			foreach($result as $field=>$value)
			{
				if (($field !== 'published') && ($field !== 'id')) {
					$valueCount++;
					$dropdown = false;
					if (strpos($field, '_id') > 0){
						$dropdown = true;
						if ($value > 0) {
							$fsql = "SELECT name from " . substr($field, 0, -3) . " WHERE id =". $value;
							$nameQuery = crud::fetchQuery($fsql);
							$name='';
							$optionsHtml='';
							while ($row = $nameQuery->fetch_assoc()) {
						    // $value = $row['name'];
						    $name = $row['name'];
							}
							$asql = "SELECT name, id FROM " . substr($field, 0, -3);
							$options = crud::fetchQuery($asql);
							while ($row = $options->fetch_assoc()) {
								$optionsHtml .= '<option value="'. $row['id'] .'">' . $row['name'] . '</option>';
							}
							$value = <<<HTML
							<select>
								<option>$name</option>
								$optionsHtml
							</select>
HTML;
						}

					}

				
					if ($valueCount % $fieldCount == 0)
					{
						$values .= <<<HTML
						<td contenteditable="false" data-dropdown="$dropdown" data-field="$field" data-id="$id">$value</td><td class="edit"><button>EDIT</button></td><td class="save"><button>SAVE</button></td><td class="delete"><button>DELETE</button></td></tr><tr>
HTML;
					} 
					else 
					{
						$values .= <<<HTML
						<td contenteditable="false" data-dropdown="$dropdown" data-field="$field" data-id="$id" >$value</td>
HTML;
					}
				}
			}
		}

$html = <<<EOT
			<table id="mainTable" class="tablesorter" data-table="$tbl">
				<thead>
					<tr>
						$fields
					</tr>
				</thead>
				<tbody>
					<tr>
						$values
					</tr>
				</tbody>
			</table>
			</br>
			</br>
			</br>
			<a href="#getForm" class="addNew" value="$tbl">Add New</a>
EOT;

		echo $html;

}
