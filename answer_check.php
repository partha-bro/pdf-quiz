<html>
	<head>
		<link type="text/css" rel="stylesheet" href="css/materialize/css/materialize.min.css"  media="screen,projection"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<script type="text/javascript" src="css/materialize/js/materialize.min.js"></script>
		<script type="text/javascript" src="css/materialize/js/jquery.js"></script>
		<title>PDF Quiz</title>
		<link rel="stylesheet" href="css/style.css" />
		<script>
			$(window).on('mouseover', (function () {											//changes code
					window.onbeforeunload = null;
				}));
				$(window).on('mouseout', (function () {
					window.onbeforeunload = ConfirmLeave;
				}));
				function ConfirmLeave() {
					return "";
				}
				var prevKey="";
				$(document).keydown(function (e) {
					if (e.key=="F5") {
						window.onbeforeunload = ConfirmLeave;
					}
					else if (e.key.toUpperCase() == "W" && prevKey == "CONTROL") {
						window.onbeforeunload = ConfirmLeave;
					}
					else if (e.key.toUpperCase() == "R" && prevKey == "CONTROL") {
						window.onbeforeunload = ConfirmLeave;
					}
					else if (e.key.toUpperCase() == "F4" && (prevKey == "ALT" || prevKey == "CONTROL")) {
						window.onbeforeunload = ConfirmLeave;
					}
					prevKey = e.key.toUpperCase();
				});
		</script>
	</head>
	<body>
		<div id="bodydiv" class="container" align="center">
			<div class="row">
				<div class="col s12">
					<?php
						if(isset($_GET["id"]) && isset($_GET["userid"]) ){
							$path = "json/".$_GET["id"].".json";
							$timetaken = $_POST["time_taken"];
							$userid = $_GET["userid"];
							$str = file_get_contents($path);
							$json = json_decode($str, true); 				// decode the JSON into an associative array
							$count = count($json)-1;
							
							$ans = 0;
							$check_op = 0;
							$show_ans = $json[0]['show_ans'];
							for($i=1;$i<=$count;$i++){
								if(substr($json[$i]['qType'],0,8) == 'multiple'){
									if($i<=$count){
										if(!empty($_POST['newCheckboxName_'.$i])){
											$item = $_POST['newCheckboxName_'.$i];
											$count1 = count($item);
											$g = $json[$i]['option'];
											$count2 = count($g);							//changes code 26-02
											if($count1 == $count2){							//changes code 26-02
												$check_op = 0;
												for($j=0;$j<$count2;$j++){
													if($item[$j] == $g[$j]){
														$check_op++;
													}
												}
											}else{											//changes code 26-02
												$check_op = 0;
											}
										}else{
											continue;
										}
									}
									if(!empty($g)){
										if($check_op == count($g)){
											$ans++;
										}
									}
								}else{
									if($i<=$count){
										if(!empty($_POST['check_'.$i])){
											if($json[$i]['option'] == $_POST['check_'.$i]){
												$ans++;
											}
										}
									}
								}
							}
							echo "number of question= ".$count." mark=".$ans;
							/*$con=mysqli_connect("localhost","root","","etest");
							// Check connection
							if (mysqli_connect_errno()) {
							  echo "Failed to connect to MySQL: " . mysqli_connect_error();
							}

							// escape variables for security
							$userid = mysqli_real_escape_string($con, $userid);
							$testid = mysqli_real_escape_string($con, $_GET["id"]);
							$marks = mysqli_real_escape_string($con, $ans);
							$timetaken = mysqli_real_escape_string($con, $timetaken);
							$totalmarks = mysqli_real_escape_string($con, $count);
							$date = date("Y/m/d");

							
							/*$sql="INSERT INTO testresult (userid, testid, marks, totalmarks, timetaken, date)
							VALUES ('$userid', '$testid', '$marks', '$totalmarks','$timetaken', '$date')";

							if (!mysqli_query($con,$sql)) {
							  die('Error: ' . mysqli_error($con));
							}
							//echo "success";
							if($show_ans == 1){
								echo "<h5>Your score is ",$ans," out of ",$count,".</h5><br/>";
							}else{
								echo "<h5>Your answer is submitted successfully.</h5><br/>";
							}
							mysqli_close($con);*/
						}else echo '<h5>URL must have contain id parameter.</h5>';

					?>
					<a class="waves-effect waves-light btn" type="button" id="btnback" href="index.php">Close</a>
				</div>
			</div>
		</div>
	</body>
</html>
