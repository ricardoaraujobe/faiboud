
<style type="text/css">

    div.logo {
        float: left;
        width: 25%;
        position:absolute;
        top:10%;
        left:40%;
    }

    div.formulario {
        font-size:14px;
        color:#000000;
        background:<?php echo $background_form ?> no-repeat;
        text-align: center;
        position:absolute;
        top:35%;
        left:30%;


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
    <img src="<?= base_url('assets/imagens/Form/'.$nome_imagem) ?>" width="150" height="150"  alt="imagem">

</div>
<div class="body-extra">

    <div class="formulario">
        <?php
        $attributes = array('class' => 'email', 'id' => 'form');
        echo form_open('elementos/confirma_form', $attributes);
        echo form_fieldset('Exemplo de formulário <br>Preencha seus dados');
        ?>
        <p>
            <?php
            echo form_label('Nome:  ', 'username');
            ?>
        </p>
        <p>

            <?php
            echo form_hidden('background_form', $background_form);
            echo form_hidden('button_return', $button_return);
            echo form_hidden('nome_imagem', $nome_imagem);
            
            $data = array(
                'name' => 'username',
                'id' => 'username',
                'value' => '',
                'maxlength' => '50',
                'size' => '50',
                'style' => 'width:50%'
            );
            echo form_input($data);
            ?>
        </p>
        <p>
            <?php
            echo form_label('Email:  ', 'email');
            ?>
        </p>
        <p>
            <?php
            $data = array(
                'name' => 'email',
                'id' => 'email',
                'value' => '',
                'maxlength' => '50',
                'size' => '50',
                'style' => 'width:50%'
            );
            echo form_input($data);
            ?>
        </p>
        <p>
            <?php
            echo form_label('Cidade:   ', 'cidade');
            ?>
        </p>
        <p>
            <?php
            $data = array(
                'name' => 'cidade',
                'id' => 'cidade',
                'value' => '',
                'maxlength' => '50',
                'size' => '50',
                'style' => 'width:50%'
            );
            echo form_input($data);
            ?>
        </p>
        <p>
            &nbsp;
        </p>

        <p>
            <a class="but-voltar" href="javascript:window.history.go(-1);">Voltar</a>
            <button class="but-enviar" type="submit" >Enviar</button>
        </p>
        <?php
        echo form_fieldset_close();
        ?>
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