<html>
	<head>
		<link type="text/css" rel="stylesheet" href="css/materialize/css/materialize.min.css"  media="screen,projection"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<script type="text/javascript" src="css/materialize/js/materialize.min.js"></script>
		<script type="text/javascript" src="css/materialize/js/jquery.js"></script>
		<title>PDF Quiz</title>
		<link rel="stylesheet" href="css/style.css" />
	</head>
	<body>
		<div id="bodydiv" class="container" align="center">
			<?php
				$uid = "formdata_".$_GET['uid'];

				if(isset($_POST["submit"])){
					$count = $_POST['count_no']; 																			//store the total number of question
																																						//save all data in json format
					$formdata[] = array(
							  'id'=> $uid,
							  'path'=> $_POST['file_path'],
							  'time'=> $_POST['time_q'],
							  'show_ans'=>$_POST['check_q']
						  );
					for($i='1';$i<=$count;$i++){
						if(!empty($_POST['type_'.$i])){
							$item['qType'] = $_POST['type_'.$i];
							$mul='multiple_'.$i;
							if($item['qType']==$mul){
								if(!empty($_POST['newCheckboxName_'.$i])){
									$item['option'] = $_POST['newCheckboxName_'.$i];
								}else{
									echo '<h5>Option fields are empty.</h5>';
									break;
								}
							}else{
								if(!empty($_POST['check_'.$i])){
									$item['option'] = $_POST['check_'.$i];
								}else{
									echo '<h5>Option fields are empty.</h5>';
									break;
								}
							}
							$formdata[] = $item;
						}else{
							echo '<h5>Some form fields are empty.</h5>';
							break;
						}
					}
					if(!empty($formdata)){
						$jsondata = json_encode($formdata, JSON_PRETTY_PRINT);
					}
					if(!empty($jsondata)){
						$file_json = 'json/'.$uid.'.json';
						if(file_put_contents($file_json, $jsondata)) echo '<h5>Test is successfully saved.</h5>';			//changes code
						else echo '<h5>Unable to save data in '.$uid.'</h5>';
					}
				}else echo '<h5>Form fields are not submitted.</h5>';
			?>
			<br/>
			<button class="waves-effect waves-light btn" type="button" id="btnback" onclick="closeWin();">Close</button>
		</div>
	</body>
</html>
