<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Colorblind</title>

        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">-->
        <link href="<?= base_url('includes/bootstrap.min.css') ?>" rel="stylesheet">

        <link href="<?= base_url('includes/signin.css') ?>" rel="stylesheet">
        <link href="<?= base_url('includes/extra.css') ?>" rel="stylesheet">
        
            <script src="<?= base_url('assets/loader/js/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/loader/js/jquery.oLoader.min.js') ?>"></script>

<style type="text/css">

</style>


    </head>
    <body> 


        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= base_url('index.php/home') ?>"><img src="<?= base_url('assets/imagens/olho_ontologia2.jpg') ?>" width="60" height="38" alt="mapa"></a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?= base_url('index.php/home') ?>">Início</a></li>
                        <li><a href="#"></a></li>
                        <li><a href="#"></a></li>
                        <li><a href="<?= base_url('index.php/login/logout') ?>">Sair</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="main" class="container-fluid">
            <br><br>
            <p>Olá <?php echo $this->session->userdata('nome'); ?></p> 
            <?php 
            
            //echo $this->session->userdata('nomePatologia')."<br>";
            echo $contents; 
            ?>
        </div>
<!--        <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>-->
        <link href="<?= base_url('includes/extra.css') ?>" rel="stylesheet">
    </body>
</html>
