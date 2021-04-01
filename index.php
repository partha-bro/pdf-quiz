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
		
	</head>
	<body>
		<div id="bodydiv" class="container">
				<fieldset>
						<div class="input-field col s12">
							<p align="center"><b>Please choose your profession :</b>
								<button class="waves-effect waves-light btn" id="teacher" name="teacher" onclick="teacher()" >Teacher</button>
                                or
								<button class="waves-effect waves-light btn" name="student" value="student" onclick="student()">Student</button>
							</p>
						</div>
					</div>
                    
				</fieldset>

                
		</div>

        
        <script>
            function teacher(){
                window.location= "main.php";
            }
            function student(){
                window.location= "http://parthainfo.epizy.com/pdf_quiz/student.php?id=formdata_5d81ea1021f9c";
            }
        </script>
	</body>
</html>
