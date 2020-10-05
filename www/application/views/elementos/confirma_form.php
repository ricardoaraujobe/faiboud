<style type="text/css">

    div.logo {
        float: left;
        width: 25%;
        position:absolute;
        top:10%;
        left:40%;
    }

    div.formulario-confirma {
        text-align: left;
        position:absolute;
        top:35%;
        left:33%;
        width:30%;
    }
    .confirma { border:2px solid green;
                padding: 2em;
                font:100%/2 sans-serif;
                width:80%;

    }

    fieldset { border:2px solid red;
               padding: 1em;
               font:100%/2 sans-serif;
               background-color: #FFFFF;

    }

    label {
        float:left;
        width:25%;
        margin-right:0.5em;
        padding-top:0.2em;
        text-align:center;
        font-weight:bold;
    }


    .but-enviar {
        display: inline-block;
        background-color: <?php echo $button_send ?>;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        box-sizing: border-box;
        font-family: Helvetica, Arial, sans-serif;
        font-size: 14px;
        border: 0px;

    }

    .but-voltar {
        display: inline-block;
        background-color: <?php echo $button_return ?>;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        box-sizing: border-box;
        font-family: Helvetica, Arial, sans-serif;
        font-size: 14px;
        border: 0px;
    }
</style>

<link href="<?= base_url('includes/extra.css') ?>" rel="stylesheet">


<div class="logo">
    <img src="<?= base_url('assets/imagens/Form/' . $nome_imagem) ?>" width="150" height="150"  alt="imagem">

</div>

<div class="formulario-confirma">
    <div class="confirma">

        <?php
        $attributes = array('class' => 'email', 'id' => 'form');
        echo form_open('elementos/confirma_form', $attributes);
        ?>
        <p>
            <?php
            echo form_label('Nome:  ', 'username');
            ?>


            <?php
            echo $nome;
            ?>
        </p>
        <p>
            <?php
            echo form_label('Email:   ', 'email');
            ?>

            <?php
            echo $email;
            ?>
        </p>
        <p>
            <?php
            echo form_label('Cidade:   ', 'cidade');
            ?>

            <?php
            echo $cidade;
            ?>
        </p>
        <p>
            Formulário enviado com sucesso. Volte a página inicial para continuar a avaliação.
        </p>

        <p>
            <a class="but-voltar" href="<?= base_url('index.php/home') ?>">Voltar a página inicial</a>

        </p>
    </div>
</div>
<?php


//$attributes = array('class' => 'email', 'id' => 'form');
//echo form_open('email/send', $attributes);
//echo form_label('Nome', 'username');
//echo form_input('username');
//echo form_label('E-mail', 'email');
//echo form_input('email');
//echo form_button('name','Voltar');
//echo form_button('name','Enviar');