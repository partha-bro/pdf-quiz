<html>
	<head>
		<link type="text/css" rel="stylesheet" href="css/materialize/css/materialize.min.css"  media="screen,projection"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<script type="text/javascript" src="css/materialize/js/materialize.min.js"></script>
		<script type="text/javascript" src="css/materialize/js/jquery.js"></script>

		<!--alert design-->
		<link type="text/css" rel="stylesheet" href="css/sweatalert/sweetalert.css"  media="screen,projection"/>
		<script type="text/javascript" src="css/sweatalert/sweetalert.min.js"></script>
		<script type="text/javascript" src="css/sweatalert/sweetalert-dev.js"></script>

		<link rel="stylesheet" href="css/style_answer.css">
		<title>PDF Quiz</title>
		<script>
			$(window).on('mouseover', (function () {																	//changes code
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
		<div class="bodydiv container-fluid">
			<div>
				<h5 class="center-align">Configure answer sheet</h5>
			</div>
			<div class="row">
				<div class="col s6">
				<?php
					if(isset($_GET["uid"])){
						echo "<form id='form' action='save_json.php?uid=".$_GET['uid']."' method='post' onsubmit='return validateForm();'>";
					}
				?>
						<input type='hidden' id='count' name='count_no' value='' /> 		<!--this hidden input store the number of total question-->
						<input type='hidden' id='time_q' name='time_q' value='' /> 			<!--this hidden input store the number of total question-->
						<input type='hidden' id='check_q' name='check_q' value='' /> 		<!--this hidden input store the number of total question-->
						<div class="tablediv" style="overflow-y:auto;"> 								<!--make all quiz in table manner-->
							<?php

								if(isset($_POST["submit"])){
								if(empty($_POST["time_period"])){
									$no_time=0;
								}else{
									$no_time=$_POST["time_period"];  													//time in seconds
								}
								$no_question=$_POST["question"];  													//number of question
								$no_option=4; 																							//always option number is 4
								$chk_answer=$_POST["check_result"];													//store check value
								$uid = $_GET["uid"];
									//pdf uploads
										$file_name = $_FILES["fileToUpload"]["name"];
										$new_file_name = $uid."_".$file_name;
										$target_dir = "uploads/"; 															//target folder for uploaded pdf
										$target_file = $target_dir.$new_file_name;
										$uploadOk = 1; 																					//this value for upload status
										$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
											if($imageFileType == "pdf") {
													if($_FILES["fileToUpload"]["size"] <= 3000000){		// Check if pdf file is a actual pdf or not
														$uploadOk = 1;
													}else{
														$uploadOk = 2;
													}
											}else {
												$uploadOk = 0;
											}
										if ($uploadOk == 0) {																		// Check if $uploadOk is set to 0 by an error
											echo "<script>swal({title: 'error!',
												text: 'Sorry, your file was not uploaded.',
												type: 'error',
												confirmButtonText: 'OK'},function(){
														window.history.go(-1);
													});
												</script>";
										}else if ($uploadOk == 2) {															// if everything is ok, try to upload file
											echo "<script>swal({title: 'error!',
												text: 'your file size is not less than 3MB.',
												type: 'error',
												confirmButtonText: 'OK'},function(){
														window.history.go(-1);
													});
												</script>";
										}else{
											if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {	// if everything is ok, try to upload file
												/*echo "<script>swal({title: 'Upload!',
												text: 'The file has been uploaded.',
												type: 'success',
												confirmButtonText: 'OK'});
												</script>";*/
											} else {
												echo "<script>swal({title: 'error!',
												text: 'Sorry, there was an error uploading your file.',
												type: 'error',
												confirmButtonText: 'OK'},function(){
														window.history.go(-1);
													});
												</script>";
											}
										}

									if($no_question!=NULL){  																				//check question is not empty
										echo "<table class='striped' border='1px'>","<tr>";
										echo "<td align='center' colspan=",$no_option+1," class='tab_head'><b>Question's</b>","</td>";
										echo ("<td align='center' class='teal lighten-5'><b>SCQ</b></td>");
										echo ("<td align='center' class='teal lighten-5'><b>MCQ</b></td>");
										echo ("<td align='center' class='teal lighten-5'><b>T/F</b></td></tr>");
										for($num_q='1';$num_q<=$no_question;$num_q++){  							//make the question numbers
											echo "<tr>","<td align='center'><p id='q_no_",$num_q,"'><b>",$num_q,"</b></p></td>";
											$cap='A';  																									//option name
											for($num_o='1';$num_o<=$no_option;$num_o++){  							//make the options with increased name
												echo ("<td align='center'>");
												echo "<label><input class='classoption' type='radio' id='radio_btn_",$num_q,$num_o,"' name='check_",$num_q,"' value='",$num_o,"'>"."<span id='true_",$num_q,$num_o,"'>",$cap,"</span></label>";
												echo ("</td>");
												$cap++;
											}
											echo ("<td align='center' class='teal lighten-5'>");  			//make the different type of questions
											echo "<label><input type='radio' onclick='showText(this)' id='q_type_",$num_q,"' name='type_",$num_q,"' value='single_",$num_q,"' checked='checked'><span/></label></td>";
											echo "<td align='center' class='teal lighten-5'><label><input type='radio' onclick='showText(this)' id='q_type_",$num_q,"' name='type_",$num_q,"' value='multiple_",$num_q,"'><span/></label></td>";
											echo "<td align='center' class='teal lighten-5'><label><input type='radio' onclick='showText(this)' id='q_type_",$num_q,"' name='type_",$num_q,"' value='tf_",$num_q,"'><span/></label></td>","</tr>";
										}
										echo "</table>";
									}else{
										echo ("Please enter the number of questions and options");
										header('Location: index.php');
									}
								}
							?>
						</div>
						<script type="text/javascript">
							function showText(obj){
								var qus = obj.value;  																						//store the string of question type
								var str = qus.substring(0, 6); 																		//store the number of that string
								if(str == 'single'){																							//check that question single or multiple or true/false
									var no = qus.substring(7, 100);
								}else if(str == 'multip'){
									var no = qus.substring(9, 100);
								}else{
									var no = qus.substring(3, 100);
								}
										if(obj.value=='multiple_'+no)
										{
											for(var i=1;i<5;i++){
												document.getElementById('radio_btn_'+no+i).type = 'checkbox';
												document.getElementById('radio_btn_'+no+i).name = 'newCheckboxName_'+no+'[]';
												$('#radio_btn_'+no+i).show();
											}
												$('#true_'+no+'1').html('A');
												$('#true_'+no+'2').html('B');
												$('#true_'+no+'3').show();
												$('#true_'+no+'4').show();
										}
										else if(obj.value=='single_'+no)
										{
											for(var i=1;i<5;i++){
												document.getElementById('radio_btn_'+no+i).type = 'radio';
												$('#radio_btn_'+no+i).show();
											}
												$('#true_'+no+'1').html('A');
												$('#true_'+no+'2').html('B');
												$('#true_'+no+'3').show();
												$('#true_'+no+'4').show();
										}else{
											for(var i=1;i<5;i++){
												document.getElementById('radio_btn_'+no+i).type = 'radio';
											}
												if(!document.getElementById('radio_btn_'+no+'1').checked && !document.getElementById('radio_btn_'+no+'2').checked){
													document.getElementById('radio_btn_'+no+'2').checked = true;
												}
												$('#radio_btn_'+no+'1').show();
												$('#radio_btn_'+no+'2').show();

												$('#radio_btn_'+no+'3').hide();
												$('#radio_btn_'+no+'4').hide();
												$('#true_'+no+'1').html('T');
												$('#true_'+no+'2').html('F');
												$('#true_'+no+'3').hide();
												$('#true_'+no+'4').hide();
										}
								return;
							}
							function countQuestion(){
								var con = <?php echo $no_question; ?>;
								var tim = <?php echo $no_time; ?>;
								var chk_q = <?php echo $chk_answer; ?>;

								$('#count').val(con);																							//store the total number of question in hidden input
								$('#time_q').val(tim);																						//store the total time in hidden input
								$('#check_q').val(chk_q);																					//store the total time in hidden input

							}
							function validateForm(){																						//check all the inputs are clicked
								var no_q = <?php echo $no_question; ?>;
								for(var i=1;i<=no_q;i++){
									if (!document.getElementById('radio_btn_'+i+'1').checked && !document.getElementById('radio_btn_'+i+'2').checked && !document.getElementById('radio_btn_'+i+'3').checked && !document.getElementById('radio_btn_'+i+'4').checked) {
										// no radio button is selected
										swal({
											title: "Incomplete!",
											text: "Please select those answers,\n which color has RED.",
											type: "warning",
											confirmButtonText: "OK"
										},function(){
											highlightRadio();
										});
									return false;
									}
								}
							return true;
							}
							function highlightRadio(){
							var no_q = <?php echo $no_question; ?>;
								for(var i=1;i<=no_q;i++){
									if(!document.getElementById('radio_btn_'+i+'1').checked && !document.getElementById('radio_btn_'+i+'2').checked && !document.getElementById('radio_btn_'+i+'3').checked && !document.getElementById('radio_btn_'+i+'4').checked){
										$('#q_no_'+i).css('color', 'red');
									}else{
										$('#q_no_'+i).css('color', 'black');
									}
								}
							}
							function back(){
								window.history.go(-1);																						//changes code
							}

						</script>
						<div class="buttondiv col s12">
							<button class="waves-effect waves-light btn" type="submit" id="btnsave" name="submit" onclick="countQuestion();">Save</button>
							<?php
							if(isset($target_file)){
								echo "<input type='hidden' id='file_path' name='file_path' value='".$target_file."' />"; //pdf file path
							}
							?>
							<button class="waves-effect waves-light btn" type="button" id="btncancel" onclick="back();">Cancel</button>
						</div>
					</form>
				</div>
				<div class="framediv col s6">
					<?php
					if(isset($target_file)){
						echo "<embed id='pdf_view' src='".$target_file."#toolbar=0'>";
					}
					?>
				</div>
			</div>
		</div>
	</body>
</html>
