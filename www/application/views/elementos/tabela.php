<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!--<link href="<?= base_url('includes/tabela.css') ?>" rel="stylesheet">-->

<style type="text/css">
/*
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
*/
/* 
    Created on : 19/07/2016, 14:13:49
    Author     : ricardo
*/


.tabela-cotacao{
    border-collapse: collapse;
    color:#000000;
    width: 690px;
    height: 93px; 
    text-align: center; 
    border: 3px solid <?php echo $borda ?>;
    margin-right:auto; 
    margin-left:auto;
}

.td-imagem{
     border:3px solid <?php echo $borda ?>;
     
}

.th{
    border:3px solid <?php echo $borda ?>;
    background-color: <?php echo $background_titulo ?>;
    color:#FFFFFF;
    text-align: center; 
}


.td-cotacao1{
    border:3px solid <?php echo $borda ?>;
    background-color: #000000;
    color:#FFFFFF;
    text-align: center; 
}

.td-cotacao2{
    border:3px solid #006600;
    background-color: #000000;
    color:<?php echo $cotacao_positiva ?>;
    text-align: center; 
}

.td-cotacao3{
    border:3px solid #006600;
    background-color: #000000;
    color:<?php echo $cotacao_negativa ?>;
    text-align: center; 
}

.td-bolsa{
    border:3px solid <?php echo $borda ?>;
    
}

.a-link:visited {
	text-decoration:underline;
            color: <?php echo $link_visitado ?>;
	}
.a-link:hover {
	text-decoration: underline; 
	color: <?php echo $link_nao_visitado ?>;
	}
.a-link {
	text-decoration: none
	}

</style>

<a href="javascript:window.history.go(-1);" class="btn btn-default">Voltar</a>
<p>Exemplo de tabela</p>
<table class="tabela-cotacao" >


    <tbody>


        <tr>



            <td colspan="4" class="td-imagem"><img src="<?= base_url('assets/imagens/Table/'.$logo) ?>" width="300" height="203"  alt="imagem"></td>


        </tr>


        <tr>


            <th colspan="4" class="th">COTA&Ccedil;&Otilde;ES
                E &Iacute;NDICES
                DO DIA</th>


        </tr>


        <tr >


            <td class="td-cotacao1">BOVESPA</td>


            <td class="td-cotacao1">D&oacute;lar Comercial</span></td>


            <td class="td-cotacao1">Peso Argentino</span></td>


            <td class="td-cotacao1">Euro</span></td>


        </tr>


        <tr>


            <td class="td-cotacao2"><img style="width: 18px; height: 20px;" alt="" src="<?= base_url('assets/imagens/Table/'.$seta_cima) ?>"> + 1,54%</td>


            <td class="td-cotacao2"><img style="width: 18px; height: 20px;" alt="" src="<?= base_url('assets/imagens/Table/'.$seta_cima) ?>"> +1,91</td>


            <td class="td-cotacao3"><img src="<?= base_url('assets/imagens/Table/'.$seta_baixo) ?>" alt="" style="width: 18px; height: 20px;">-2,62%</td>


            <td class="td-cotacao3"><img src="<<?= base_url('assets/imagens/Table/'.$seta_baixo) ?>" alt="" style="width: 18px; height: 20px;">-1,99%</td>


        </tr>



    </tbody>
</table>


<br>


<table class="tabela-cotacao">


    <tbody>


        <tr >


            <td class="th" colspan="2">LEGENDAS</td>


        </tr>


        <tr>


            <td class="td-bolsa"><font color="<?php echo $link_nao_visitado ?>">&nbsp;Bolsa
                    de Valores</font></td>


            <td class="td-bolsa">Link nunca visitado pelo usu&aacute;rio</td>


        </tr>


        <tr>


            <td class="td-bolsa"><font color="<?php echo $link_visitado ?>">C&acirc;mbio</font></td>


            <td class="td-bolsa">Link j&aacute; visitado pelo usu&aacute;rio</td>


        </tr>


        <tr>


            <td class="td-bolsa"><img style="width: 60px; height: 60px;" alt="" src="<?= base_url('assets/imagens/Table/'.$baixo_risco) ?>"></td>


            <td class="td-bolsa">Imagem que representa investimentos com baixo risco</td>


        </tr>


        <tr>


            <td class="td-bolsa"><img style="width: 60px; height: 60px;" alt="" src="<?= base_url('assets/imagens/Table/'.$alto_risco) ?>"></td>


            <td class="td-bolsa">Imagem que representa investimentos com alto risco</td>


        </tr>



    </tbody>
</table>


<div style="text-align: center;"><br>


    <table class="tabela-cotacao">


        <tbody>


            <tr>


                <td class="th"  colspan="2">BOLSA
                    (A&ccedil;&otilde;es em destaque)</td>


            </tr>


            <tr>


                <td class="th">Empresa</td>


                <td class="th">Risco</td>


            </tr>


            <tr>


                <td class="td-bolsa"><a class="a-link" href="##">Empresa A</a></td>


                <td class="td-bolsa"><img style="width: 27px; height: 27px;" alt="" src="<?= base_url('assets/imagens/Table/'.$baixo_risco) ?>"></td>


            </tr>


            <tr>


                <td class="td-bolsa"><a class="a-link" href="####">Empresa B</a></td>


                <td class="td-bolsa"><img style="width: 27px; height: 27px;" alt="" src="<?= base_url('assets/imagens/Table/'.$alto_risco) ?>"></td>


            </tr>


            <tr>


                <td class="td-bolsa"><a class="a-link" href="#">Empresa C</a></td>


                <td class="td-bolsa"><img style="width: 27px; height: 27px;" alt="" src="<?= base_url('assets/imagens/Table/'.$baixo_risco) ?>"></td>


            </tr>


            <tr>


                <td class="td-bolsa"><a class="a-link" href="###">Empresa D</a></td>


                <td class="td-bolsa"><img style="width: 27px; height: 27px;" alt="" src="<?= base_url('assets/imagens/Table/'.$alto_risco) ?>"></td>


            </tr>



        </tbody>
    </table>


    <br>


</div>




