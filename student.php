<html>
	<head>
		<link type="text/css" rel="stylesheet" href="css/materialize/css/materialize.min.css"  media="screen,projection"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<script type="text/javascript" src="css/materialize/js/materialize.min.js"></script>
		<script type="text/javascript" src="css/materialize/js/jquery.js"></script>

		<!--alert design-->
		<link type="text/css" rel="stylesheet" href="css/sweatalert/sweetalert.css" />
		<script type="text/javascript" src="css/sweatalert/sweetalert.min.js"></script>
		<script type="text/javascript" src="css/sweatalert/sweetalert-dev.js"></script>

		<link rel="stylesheet" href="css/style_answer.css" />
		<title>PDF Quiz</title>
		<script>
			$(window).on('mouseover', (function () {								//changes code
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
	<body oncontextmenu="return false;">
		<div class="bodydiv container-fluid">
			<div>
				<h5 class="center-align">PDF Based Assessment</h5>
			</div>
			<div class="row">
				<div class="col s6">
				<?php
				$view = 0;													//changes code 26-02
				if(isset($_GET["id"]) && isset($_GET["view"]))				//changes code 26-02
				{															//preview mode   
					$view = $_GET["view"];
					if($view == 'preview')
					{
						echo "<div class='tablediv' id='testPage' style='overflow-y:auto;'>";
						echo "<script>$('#testPage').on( 'click',  function(e){																e.preventDefault();
							});</script>";
						$path = "json/".$_GET["id"].".json";
						if(@file_get_contents($path))
						{
							$str = file_get_contents($path);
							$json = json_decode($str, true); 				// decode the JSON into an associative array
							$count = count($json)-1;						//total number of question in json data
							$time = $json[0]['time'];
							$path_pdf = $json[0]['path'];
							$show_ans = $json[0]['show_ans'];

							if($count!=NULL )
							{
								echo "<table class='striped' border='1px'>","<tr>";
								echo "<td align='center' colspan=",4," class='tab_head'><b>Question paper</b>","</td>";
								echo "<td align='center' id='tab_head2' class='tab_head2'><b><p id='time_p'>Time remains:<input type='hidden' id='time' name='time' value=''><p id='timep'>00:00</p></b></p>","</td>";
								for($num_q='1';$num_q<=$count;$num_q++)
								{
									echo "<tr>","<td align='center'>",$num_q,"</td>";
									$cap='A';
										if(substr($json[$num_q]['qType'],0,8) == 'multiple'){
											for($num_o='1';$num_o<=4;$num_o++){
												echo ("<td align='center'>");
												echo "<label><input type='check' id='radio_btn_",$num_q,$num_o,"' name='check_",$num_q,"' value='",$num_o,"' disabled>"."<span id='true_",$num_q,$num_o,"'>",$cap,"</span></label>";
												echo ("</td>");
												$cap++;
											}
										}	
										else {
											for($num_o='1';$num_o<=4;$num_o++){
												echo ("<td align='center'>");
												echo "<label><input type='radio' id='radio_btn_",$num_q,$num_o,"' name='check_",$num_q,"' value='",$num_o,"' disabled>"."<span id='true_",$num_q,$num_o,"'>",$cap,"</span></label>";
												echo ("</td>");
												$cap++;
											}
										}
									echo "</tr>";
								}
								echo "</table>";
							}

							//check the answers
							echo "<script>";
							for($i=1;$i<=$count;$i++){
								if(substr($json[$i]['qType'],0,8) == 'multiple'){
									if($i<=$count){
										$g = $json[$i]['option'];
										$count1 = count($json[$i]['option']);
										for($j=0;$j<$count1;$j++){
											$opt = $g[$j];	
											echo "$('#radio_btn_".$i.$opt."').prop('checked', true);";				
										}
									}
								}else{
									if($i<=$count){
										$opt = $json[$i]['option'];
										echo "$('#radio_btn_".$i.$opt."').prop('checked', true);";
									}
								}
							}
							echo "</script>";
						}
					}
				}else if( isset($_GET["id"]) ){											//testing mode
					echo "<form action='answer_check.php?id=".$_GET["id"]."&userid=".$_GET["userid"]."' method='post' id='form_answer'>";
					echo "<div class='tablediv' id='testPage' style='overflow-y:auto;'>";			//changes code

						$path = "json/".$_GET["id"].".json";
						if(@file_get_contents($path)){
							$str = file_get_contents($path);
							$json = json_decode($str, true); 				// decode the JSON into an associative array
							$count = count($json)-1;						//total number of question in json data
							$time = $json[0]['time'];
							$path_pdf = $json[0]['path'];
							$show_ans = $json[0]['show_ans'];

							if($count!=NULL ){
								echo "<table class='striped' border='1px'>","<tr>";
								echo "<td align='center' colspan=",4," class='tab_head'><b>Question paper</b>","</td>";
								echo "<td align='center' id='tab_head2' class='tab_head2'><b><p id='time_p'>Time remains:<input type='hidden' id='time' name='time' value=''><p id='timep'>00:00</p></b></p>","</td>";
								for($num_q='1';$num_q<=$count;$num_q++){
									echo "<tr>","<td align='center'>",$num_q,"</td>";
									$cap='A';
									for($num_o='1';$num_o<=4;$num_o++){
										echo ("<td align='center'>");
										echo "<label><input type='radio' id='radio_btn_",$num_q,$num_o,"' name='check_",$num_q,"' value='",$num_o,"' disabled>"."<span id='true_",$num_q,$num_o,"'>",$cap,"</span></label>";
										echo ("</td>");
										$cap++;
									}
									echo "</tr>";
								}
								echo "</table>";
							}
						}else echo '<h5>File not founded.</h5>';
					}else echo '<h5>URL must have contain id parameter.</h5>';
				?>
						</div>
						<script type="text/javascript">
							var myVar;		  									//start the timer with this variable
							var totalTimeTakenInterval;
							var no_time = <?php echo $time; ?>;  				//time that input by teacher on 1st page
							var min;											//changes code
							var sec;
							var no = <?php echo $count; ?>;					//total number of question in json data
							var obj = <?php echo json_encode($str); ?>;  	//take the json data and store in variable
							var obj1 = JSON.parse(obj);  					//convert array to string
							
								for(var i=1;i<=no;i++){						//configure the questions for student
									var str = obj1[i].qType.substring(0, 6);
									if(str == 'single'){
										var no1 = obj1[i].qType.substring(7, 100);
										for(var j=1;j<5;j++){
											document.getElementById('radio_btn_'+no1+j).type='radio';

										}
									}else if(str == 'multip'){
										var no1 = obj1[i].qType.substring(9, 100);
										for(var j=1;j<5;j++){
											document.getElementById('radio_btn_'+no1+j).type='checkbox';
											document.getElementById('radio_btn_'+no1+j).name = 'newCheckboxName_'+no1+'[]';
										}
									}else{
										var no1 = obj1[i].qType.substring(3, 100);
										for(var j=1;j<5;j++){
											document.getElementById('radio_btn_'+no1+j).type='radio';
											$('#radio_btn_'+no1+j).hide();
										}
											$('#true_'+no1+'1').html('T');
											$('#true_'+no1+'2').html('F');
											$('#true_'+no1+'3').hide();
											$('#true_'+no1+'4').hide();
									}
								}
							var view_ans = "<?php echo $view; ?>";						//change code 26-02
							if(view_ans == 'preview'){									//change code 27-02
								min_view = Math.floor(no_time / 60);
								sec_view = Math.floor(no_time % 60);
								$("#timep").html(min_view+":"+formatSec(sec_view));
								for(var i=1;i<=no;i++){
									for(var j=1;j<5;j++){
										document.getElementById('radio_btn_'+i+j).disabled = false;
									}
								}
							}else{
								
							}
							function start(){ //start the timer							//changes code
								
								min = Math.floor(no_time / 60);
								sec = Math.floor(no_time % 60);
								if(no_time != 0){
									swal({
											title: "Time!",
											text: 'minute:'+min+' second:'+sec,
											confirmButtonText: "OK"
										},function(){
											myTimer();
											document.getElementById('btnsave_std').disabled = false;
											$('#btnstart_std').hide();
											$('#pdf_view').show();
											for(var i=1;i<=no;i++){
												for(var j=1;j<5;j++){
													document.getElementById('radio_btn_'+i+j).disabled = false;
												}
											}
										}
									);
								}else{
									swal({
											title: "Time!",
											text: "No time limits.",
											confirmButtonText: "OK"
										},function(){
											myTimer();
											document.getElementById('btnsave_std').disabled = false;
											$('#btnstart_std').hide();
											$('#pdf_view').show();
											for(var i=1;i<=no;i++){
												for(var j=1;j<5;j++){
													document.getElementById('radio_btn_'+i+j).disabled = false;
												}
											}
										}
									);
								}
							}
							//global variable
							var intervalTimer;
							var timetaken = 0;
							function myTimer(){
								if(no_time != 0){
									var timer = no_time;										//changes code
									timer = parseInt(timer);
									min = Math.floor(timer/60);
									sec = Math.floor(timer%60);
									$("#timep").html(min+":"+formatSec(sec));
									intervalTimer = setInterval(function(){
									timer--;
									timetaken++;
									min = Math.floor(timer / 60);
									sec = Math.floor(timer % 60);
									$("#timep").html(min+":"+formatSec(sec));
										if(timer<=10){
											$("#timep").css('color', 'red');
										}
										if(timer<=0){

											clearInterval(intervalTimer);
											$("#testPage").on( "click",  function(e){			//changes code
												e.preventDefault();
											});
											swal({
											  title: "Time Up!",
											  text: "Your test has been submitted.",
											  type: "warning",
											  confirmButtonText: "OK"
											},function(){
												if (timeUp()) 								// Calling timeUp function
												{
													document.getElementById("time_taken").value = timetaken;
													document.getElementById("form_answer").submit(); 	//form submission
												}
											});
										}
									}, 1000);
								}else{
									$("#time_p").hide();
									$("#timep").hide();
									totalTimeTakenInterval = setInterval(function(){
										timetaken++;
										}, 1000);
								}
							}
							function formatSec(s){
								var st = "";
								if(s<10){
									st = "0"+s;
								}else{
									st = s;
								}
								return st;
							}
							function myStopFunction(){								//stop the timer
								if(no_time != 0){
									clearInterval(myVar);
								}else{
									clearInterval(totalTimeTakenInterval);
								}
								document.getElementById("time_taken").value = timetaken;
								document.getElementById('time').value = document.getElementById('timep').innerHTML;
							}
							function timeUp(){										//check the time is finish
								myStopFunction();
							return true;
							}
						</script>
						<div class="buttondiv_std col s12">
							<?php																	//changes code 27-02
								if($view == '0'){
									echo "<button class='waves-effect waves-light btn' type='submit' id='btnsave_std' name='submit_btn' disabled='true' onclick='myStopFunction();'>Submit</button>";
									echo "<button class='waves-effect waves-light btn' type='button' id='btnstart_std' onclick='start();'>Start</button>";
								}else{
									echo "<button class='waves-effect waves-light btn' type='submit' id='btnsave_std' name='submit_btn'  onclick='closeWin();'>Close</button>";
									echo "<button class='waves-effect waves-light btn' type='button' id='btnstart_std' style='display:none;' onclick='start();'>Start</button>";
								}
							?>
							<input type='hidden' id='time_taken' name='time_taken' value='' />
						</div>
					</form>
				</div>
				<div class="framediv col s6">
					<?php
						if(isset($path_pdf)){
							if($view == '0'){															//changes code 27-02
								echo "<embed id='pdf_view' src='".$path_pdf."#toolbar=0' style='display:none;' />";
							}else{
								echo "<embed id='pdf_view' src='".$path_pdf."#toolbar=0' />"; 	//changes code
							}
							
						}
					?>
				</div>
			</div>
		</div>
	</body>
</html>