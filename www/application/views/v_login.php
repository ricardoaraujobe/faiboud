
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <title>Colorblind Login</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

        <!-- Custom styles for this template -->
        <link href="<?= base_url('includes/signin.css') ?>" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->


        <style type="text/css">


            div.info1 {
                font-size:14px;
                color:#000000;
                background:#EEEEEE no-repeat;
                text-align: center;
                position:absolute;
                width: 35%;
                align-content: left;
                top:67%;
                left:10%;


            }
            
            div.info2 {
                font-size:14px;
                color:#000000;
                background:#EEEEEE no-repeat;
                text-align: center;
                position:absolute;
                width: 35%;
                align-content: left;
                top:67%;
               right:10%;


            }
        </style>
    </head>

    <body>
        <div>
            <p align="center"><img src="<?= base_url('assets/imagens/olho_ontologia2.jpg') ?>" width="220" height="130" alt="mapa"></p>
        </div>
        <div class="container">

            <form class="form-signin" role="form" method="post" action="<?= base_url('index.php/login/logar') ?>">
                <h4 class="form-signin-heading">Para acessar, informe seu usuário e senha</h4>
                <input type="text" class="form-control" placeholder="usuário" required autofocus name="usuario">
                <input type="password" class="form-control" placeholder="Senha" required name="senha">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Fazer login</button>
                <?php if (!empty($erro)) { ?>
                    <div class="alert alert-danger" role="alert" style="margin-top: 10px;"><?php echo $erro; ?></div>
                    <?php
                } else {
                    echo '';
                }
                ?>
            </form>
        </div> <!-- /container -->
        <div class="info1">
            
            <p style="font-size:20; font-weight: bold" align="center">Este protótipo é parte do projeto de pesquisa do Mestrado em Ciência da Computação da Faculdade Campo Limpo Paulista - Faccamp </p>
       
       <p style="font-size:16; font-weight: bold" align="center"><a href="http://www.faccamp.br/site/" target="_blank"><img src="<?= base_url('assets/imagens/logo_faccamp.png') ?>" width="150" height="110" alt="mapa"></a></p>
        </div>
        
        <div class="info2">
            
            <p style="font-size:20; font-weight: bold" align="center">Agradecimento pelo apoio do Instituto Federal de Educação, Ciência e Tecnologia do Sul de Minas - IFSULDEMINAS </p>
       
       <p style="font-size:16; font-weight: bold" align="center"><a href="http://www.ifsuldeminas.edu.br/" target="_blank"><img src="<?= base_url('assets/imagens/logo_if.jpeg') ?>" width="110" height="110" alt="mapa"></a></p>
        </div>
    </body>
</html>
