<!DOCTYPE html>
<html>
	<head>
		<title>PDF Quiz</title>

		<!--meterial design-->
		<link type="text/css" rel="stylesheet" href="css/materialize/css/materialize.min.css"  media="screen,projection"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<script type="text/javascript" src="css/materialize/js/materialize.min.js"></script>
		<script type="text/javascript" src="css/materialize/js/jquery.js"></script>

		<!--alert design-->
		<link type="text/css" rel="stylesheet" href="css/sweatalert/sweetalert.css"  media="screen,projection"/>
		<script type="text/javascript" src="css/sweatalert/sweetalert.min.js"></script>
		<script type="text/javascript" src="css/sweatalert/sweetalert-dev.js"></script>

		<link rel="stylesheet" href="css/style.css" />
		<script type="text/javascript">
			var elem;
			var instance;
			$(document).ready(function(){
				//-------- for drop down this is must [start]--------
				$('select').select();
				elem = document.querySelector('select');
				instance = M.Select.init(elem);

				//-----------[end]-------------------
				$("#p").click(function(){
					//alert("button");
					var instance = M.Select.getInstance(elem);
					alert(instance.getSelectedValues());
				});

				$('form').on('reset', function(e)																					//changes code
				{
					document.getElementById('first_name').disabled = true;
					$("#note").css('color', '#ffcccc');
				});
			});
			function pdfInfo() {
				//show and hide the pdf file
				if($('#btnpreview').val()=='preview') {
					$('#preview').show();
					$('#btnpreview').val('hide');
					$('#btnpreview').html('hide');
				}
				else{
					$('#preview').hide();
					$('#btnpreview').val('preview');
					$('#btnpreview').html('preview');
				}
			}
			function showText(obj){
				if(!document.getElementById('first_name').disabled){
					document.getElementById('first_name').disabled = true;
					$("#note").css('color', '#ffcccc');
				}else{
					document.getElementById('first_name').disabled = false;
					$("#note").css('color', 'red');
				}
			}
			function showCheck(obj){
				var resultOk = document.getElementById('check_result').value;
				if(resultOk == 0){
					document.getElementById('check_result').value = 1;
				}else{
					document.getElementById('check_result').value = 0;
				}
			}
			function validateForm(){

				//check the valid number
					instance = M.Select.init(elem);
					var no = M.Select.getInstance(elem);
					var dpValue = no.getSelectedValues();
					var no_time = $('#first_name').val();
					var fileName = $("#fileToUpload").val();
					var pattern = /[ !@#$%^&*()+\=\[\]{};':"\\|,<>\/?]/;                 		//changes code
					var pdf_name = $('#file_name').val();
					var re = /(?:\.([^.]+))?$/;
					var ext = re.exec(pdf_name)[1];
					if(ext == 'PDF'){
						ext = 'pdf';
					}
					if(!fileName) { 																												// returns true if the string is not empty
						swal({
							title: "Incomplete!",
							text: "No file selected.",
							type: "warning",
							confirmButtonText: "OK"
						});
						return false;
					}
					else if(pattern.test(pdf_name)){																				//changes code
						swal({
							title: "Incomplete!",
							text: "Your file name has special characters, please rename it. ",
							type: "warning",
							confirmButtonText: "OK"
						});
						return false;
					}
					else if(ext != 'pdf'){
						swal({
							title: "Incomplete!",
							text: "Please select PDF file only.",
							type: "warning",
							confirmButtonText: "OK"
						});
						return false;
					}
					else if(dpValue == 0){
						swal({
							title: "Incomplete!",
							text: "Please select question number.",
							type: "warning",
							confirmButtonText: "OK"
						});
						return false;
					}
					else if(no_time == 0 && !document.getElementById('first_name').disabled){
						swal({
							title: "Incomplete!",
							text: "Please input time.",
							type: "warning",
							confirmButtonText: "OK"
						});
						return false;
					}
					else if(no_time < 10 && !document.getElementById('first_name').disabled){
						swal({
							title: "Incomplete!",
							text: "Minimum time limit is 10 seconds.",
							type: "warning",
							confirmButtonText: "OK"
						});
						return false;
					}
					else if(no_time > 1800 && !document.getElementById('first_name').disabled){      //changes code
						swal({
							title: "Incomplete!",
							text: "Maximum time limit is 1800 seconds(30 minutes).",
							type: "warning",
							confirmButtonText: "OK"
						});
						return false;
					}
					else{
						return true;
					}
			}
		</script>
	</head>
	<body>
		<div id="bodydiv" class="container">
			<?php
				$uid = uniqid();
			?>
			<form action="mk_quiz.php?uid=<?php echo $uid; ?>" method="post" onsubmit="return validateForm();" enctype="multipart/form-data">
				<fieldset>
					<legend>Configure answer sheet</legend>
					<div class="file-field input-field">
						<div class="btn">
							<span>File</span> <input type="file" name="fileToUpload" id="fileToUpload" accept="application/pdf"/>
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text" id="file_name" placeholder="Upload PDF File" value="">
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<select name="question" id="question s1" >
								<option value="0" selected disabled hidden>Choose number of questions</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						</div>
						<div class="input-field col s7">
							<input id="first_name" type="number" class="validate" onkeydown="javascript: return event.keyCode == 69 ? false : true" min="0" name="time_period" disabled="disabled" />
							<label for="first_name">Total time duration</label>
<span id="note" class="note">(Note: time is in seconds, minimum time is 10 seconds and maximum time is 30 minutes/1800 seconds.)</span>
						</div>
						<div class="input-field col s2">
							<label>
								<input type="checkbox" name="enable" id="enable" onclick='showText(this)'/>
								<span>Enable timer</span>
							 </label>
						</div><br/>
						<div class="input-field col s3">
							<label>
								<input type='hidden' id='check_result' name='check_result' value='0' />
								<input type="checkbox" name="checkBtn" id="checkBtn" onclick='showCheck(this)'/>
								<span>Show result</span>
							 </label>
						</div><br/>
						<div class="input-field col s12">
							<p align="center">
								<button class="waves-effect waves-light btn" type="submit" id="ok" name="submit" onclick="checkPDF()" value="submit">Submit</button>
								<button class="waves-effect waves-light btn" type="reset" name="reset" value="reset">Reset</button>
							</p>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</body>
</html>
