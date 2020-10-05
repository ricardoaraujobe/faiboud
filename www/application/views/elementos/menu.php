<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<!--<link href="<?= base_url('includes/menu.css') ?>" rel="stylesheet">-->

<style type="text/css">
    
    *{
	/* A universal CSS reset */
	margin:0;
	padding:0;
}

body{
	font-size:14px;
	color:<?php echo $background_menu ?>;
	background:<?php echo $background_menu ?> no-repeat;
	
/*	 CSS3 Radial Gradients 
	background-image:-moz-radial-gradient(center -100px 45deg, circle farthest-corner, #8B7400 150px, #009946 300px);
	background-image:-webkit-gradient(radial, 50% 0, 150, 50% 0, 300, from(#009946), to(#009946));*/
	
	font-family:Arial, Helvetica, sans-serif;
}

#navigationMenu li{
	list-style:none;
	height:39px;
	padding:2px;
	width:40px;
}

#navigationMenu span{
	/* Container properties */
	width:0;
	left:38px;
	padding:0;
	position:absolute;
	overflow:hidden;

	/* Text properties */
	font-family:'Myriad Pro',Arial, Helvetica, sans-serif;
	font-size:18px;
	font-weight:bold;
	letter-spacing:0.6px;
	white-space:nowrap;
	line-height:39px;
	
	/* CSS3 Transition: */
	-webkit-transition: 0.25s;
	
	/* Future proofing (these do not work yet): */
	-moz-transition: 0.25s;
	transition: 0.25s;
}

#navigationMenu a{
	/*background:url('../assets/imagens/menus/navigation.bmp') no-repeat;*/
        background:url('<?= base_url('assets/imagens/Menu/'.$nome_imagem) ?>') no-repeat;
        

	height:39px;
	width:38px;
	display:block;
	position:relative;
}

/* General hover styles */

#navigationMenu a:hover span{ width:auto; padding:0 20px;overflow:visible; }
#navigationMenu a:hover{
	text-decoration:none;
	
	/* CSS outer glow with the box-shadow property */
	-moz-box-shadow:0 0 5px #9ddff5;
	-webkit-box-shadow:0 0 5px #9ddff5;
	box-shadow:0 0 5px #9ddff5;
}

/* Green Button */

#navigationMenu .home {	background-position:0 0;}
#navigationMenu .home:hover {	background-position:0 -39px;}
#navigationMenu .home span{
	background-color: <?php echo $background_home ?>;
	color:<?php echo $texto_home ?>;
	text-shadow:1px 1px 0 #99bf31;
}

/* Blue Button */

#navigationMenu .about { background-position:-38px 0;}
#navigationMenu .about:hover { background-position:-38px -39px;}
#navigationMenu .about span{
	background-color: <?php echo $background_sobre ?>;
	color:<?php echo $texto_sobre ?>;
	text-shadow:1px 1px 0 #44a8d0;
}

/* Orange Button */

#navigationMenu .services { background-position:-76px 0;}
#navigationMenu .services:hover { background-position:-76px -39px;}
#navigationMenu .services span{
	background-color: <?php echo $background_servico ?>;
	color:<?php echo $texto_servico ?>;
	text-shadow:1px 1px 0 #d28344;
}

/* Yellow Button */

#navigationMenu .portfolio { background-position:-114px 0;}
#navigationMenu .portfolio:hover{ background-position:-114px -39px;}
#navigationMenu .portfolio span{
	background-color: <?php echo $background_portfolio ?>;
	color:<?php echo $texto_portfolio ?>;
	text-shadow:1px 1px 0 #d8b54b;
}

/* Purple Button */

#navigationMenu .contact { background-position:-152px 0;}
#navigationMenu .contact:hover { background-position:-152px -39px;}
#navigationMenu .contact span{
	background-color: <?php echo $background_contato?>;
	color:<?php echo $texto_contato ?>;
	text-shadow:1px 1px 0 #d244a6;
}

/* The styles below are only needed for the demo page */

#main{
	
}


h1 {
	color:#fff;
	font-size:20px;
	font-weight:normal;
	padding:0px 0 0px;
	text-align:left;
}

h2{
	font-weight:normal;
	text-align:center;
}

h1,h2{
	font-family:"Myriad Pro",Arial,Helvetica,sans-serif;
}

a, a:visited,a:active {
	color:#0196e3;
	text-decoration:none;
	outline:none;
}

a:hover{
	text-decoration:underline;
}

a img{
	border:none;
}

p.note{
	color:#707070;
	font-size:10px;
	text-align:center;
	margin:50px;
}
    
</style>
<a href="javascript:window.history.go(-1);" class="btn btn-default">Voltar</a>
<h1> Exemplo de menu       </h1>
    





<ul id="navigationMenu">
    <li>
	    <a class="home" href="#">
            <span>P&aacute;gina
inicial</span>
        </a>
    </li>
    
    <li>
    	<a class="about" href="#">
            <span>Sobre</span>
        </a>
    </li>
    
    <li> <a class="services" href="#"> <span>Servi&ccedil;os</span>
    </a> </li>

  <li> <a class="portfolio" href="#"> <span>Portf&oacute;lio</span>
    </a> </li>

  <li> <a class="contact" href="#"> <span>Contato</span>
    </a> </li>
    

</ul>
    


