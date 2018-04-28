
<!doctype html>
<html lang="en">
  	<head>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    	<meta name="description" content="">
    	<meta name="author" content="">
    	<link rel="shortcut icon" href="{baseUrl}assets/ico/favicon.png">
		  <title>Evaluasi Online</title>
    	<!-- Bootstrap core CSS -->
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    	<!-- Custom styles for this template -->
    	<link href="{baseUrl}assets/custom/floating-labels.css" rel="stylesheet">
  	</head>
  	<body>
    	<form class="form-signin" method="POST" action="{baseUrl}forgot/send">
      		<!-- <div class="text-center mb-4">
        		<img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        		<h1 class="h3 mb-3 font-weight-normal">Floating labels</h1>
        		<p>Build form controls with floating labels via the <code>:placeholder-shown</code> pseudo-element. <a href="https://caniuse.com/#feat=css-placeholder-shown">Works in latest Chrome, Safari, and Firefox.</a></p>
      		</div> -->
          <?php echo $this->session->flashdata('message');?>
      		<div class="form-label-group">
        		<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        		<label for="inputEmail">Email address</label>
      		</div>
      		<button class="btn btn-lg btn-primary btn-block" type="submit">Send</button>
      		<!-- <p class="mt-5 mb-3 text-muted text-center">&copy; 2017-2018</p> -->
    	</form>
  	</body>
</html>
