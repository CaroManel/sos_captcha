<?php
session_start();

//Checking for captcha
if ( !empty($_POST['captcha']) ) { 
	if ( $_SESSION['captcha'] == htmlspecialchars ($_POST['captcha'], ENT_QUOTES, 'UTF-8') ) {  
		$captchaOk = TRUE;
	} else {
		$captchaOk = FALSE;
	}
}
?>

<!doctype html>

<html lang="en">
<head>
<title>PHP Captcha Class</title>  
<meta charset="utf-8">
  <meta name="description" content="PHP Captcha Class">
  <meta name="author" content="SOS Code">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  
  <!-- Style -->
  <style>
    #main {
    	margin-top: 20px;
    }
    form {
    	border: 1px solid #959595;
    	border-radius: 5px;
    	padding: 20px;
    	margin-left: auto;
    	margin-right: auto;
    }
    .captcha {
    	border: 5px solid #FFE5CC;
    	border-radius: 5px;
    }
.col-centered{
    float: none;
    margin: 0 auto;
}
  </style>
  
</head>

<body>

<!-- Main -->
<div id="main">

  <!-- Main content -->
  <div class="container">
  <div class="row">
<div class="col-lg-6 col-centered">
	<!-- Form -->
    <form method="post">
    	<h1>Captcha</h1>
    	<p>Hello, this is an Captcha example.</p>
    	
    	<?php
		// checking captcha if form is submitted 
		if ( !empty( $_POST['captcha'] ) ) { 
			if ( $captchaOk == TRUE ) { ?>
				<div class="alert alert-success" role="alert">You are good</div>
			<?php } else { ?> 
				<div class="alert alert-danger" role="alert">Ooops got ya, you failed</div>
		<?php }
		} ?>
	
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Email">
        </div>
        <div class="form-group">
            <label for="captcha">Please enter the exact captcha below</label>
            <input type="" class="form-control" name="captcha" placeholder="Captcha">
        </div>
        
        <div class="form-group">
        	<img id="captcha" class="captcha" src="CaptchaClass.php" />
        	<a href="#">Reload</a>
        </div>
       
        <button type="submit" class="btn btn-primary">Submit</button>

    </form>
  </div>
  </div>  
</div>

  <!-- JS -->
  <script src="jquery/jquery.min.js"></script>
  <script>
	  $(document).ready(function () {
		$('a').click(function(event) {
			event.preventDefault();
			$(this).fadeOut("fast");
				$('img').attr('src', 'CaptchaClass.php?'+new Date().getTime());
			$(this).fadeIn("fast");
		});
	});		
  </script>

</body>
</html>