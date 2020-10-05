
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Template de Login do Bootstrap</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	
    <!-- Custom styles for this template -->
    <link href="<?= base_url('includes/signin.css') ?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  	<div class="container">
  		
		<h1 class="text-center">Parabéns, você está logado.</h1>
		<p>Lembre-se, para proteger seus controllers, basta estender o controller MY_Controller, e assim, automaticamente
			seus controllers passarão pela verificação de senha.
		</p>
		Cliqui aqui para deslogar: <a href="<?= base_url('index.php/login/logout') ?>">Deslogar</a></p>
		
  	</div>
  </body>
</html>