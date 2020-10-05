<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-Type" content="text/html; charset=utf-8" />

	<title>Palheta de Cores</title>
        
<style type="text/css">
#palheta td {
	height: 20px;
	width: 20px;
	display: block;
	float: left;
	margin: 1px;
}
#amarelo {
	background-color: #ff0;
}
#vermelho {
	background-color: #f00;
}
#verde {
	background-color: #0f0;
}
#azul {
	background-color: #00f;
}
#azulClaro {
	background-color: #0ff;
}
#roxo {
	background-color: #f0f;
}
</style>
<script type="text/javascript">
/**
 * Código por William Bruno - Moderador iMasters  http://forum.imasters.com.br/index.php?showuser=69222
 * e hargon - Moderador iMasters  http://forum.imasters.com.br/index.php?showuser=6541
 * o 'desafio' aqui, foi relembrar que existe o método: getComputedStyle(), capaz de ler
 * css não inline =)
 */
window.onload = function(){
	var palheta = document.getElementById('palheta');
	var tds = palheta.getElementsByTagName('TD');
	
	for (var i = 0; tds.length; i++)
	{
		tds[i].onclick = function() 
		{
			if( window.getComputedStyle ) {
			  bg = document.defaultView.getComputedStyle(this, null).backgroundColor;
			} else if( palheta.currentStyle ) {
			  bg = document.getElementById(this.id).currentStyle['backgroundColor'];
			}
			document.body.style.backgroundColor = bg;
		}
	}
}

</script>

</head>
<body>
<table id="palheta">
	<tr>
		<td id="amarelo"></td>
		<td id="vermelho"></td>
		<td id="verde"></td>
	</tr>
	<tr>
		<td id="azul"></td>
		<td id="azulClaro"></td>
		<td id="roxo"></td>
	</tr>
</table>
</body>
</html>
