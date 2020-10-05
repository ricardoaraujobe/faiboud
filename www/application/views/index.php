<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//Descomentar para visualizar informações da ontologia
//echo $teste;
?>


<style type="text/css">
    table td div {
        padding:5px;
        background:#eee;
        height:60px;
    }
</style>







<script type='text/javascript'>

    $(function () {


        $('#carregamento').click(function () {
            $('#carregar').oLoader({
                backgroundColor: '#fff',
                image: '<?= base_url('assets/loader/images/ownageLoader/loader4.gif') ?>',
                fadeInTime: 500,
                fadeOutTime: 1000,
                fadeLevel: 0.8
            });
        });




    });

</script>

<!--<a href="preferencia/contexto" id='show-test-2'>Teste</a>-->    
<div >
    
    <table style='width:100%'>
        <tr>

            <td>
            </td>
            <td>
                <div id='carregar'></div>



            </td>
        </tr>
    </table>
    <div id='carregamento'>
        <p><a href="preferencia"  >Configurações iniciais</a></p>
        <p>Aqui vão as orientações de como utilizar o protótipo</p>
        <p><a href="imagens/get_image/Maps/ColoredMaps" >Passo 1 - Mapa</a></p>
    
    <p><a href="imagens/get_image/Graph/PieGraph">Passo 2 - Gráfico</a></p>
    <p><a href="imagens/get_image/TechnicalImages/Tomography">Passo 3 - Tomografia</a></p>
    <p><a href="elementos/get_element/Form/Registration_Form">Passo 4 - Formulário</a></p>
    <p><a href="elementos/get_element/Menu/Side_Menu">Passo 5 - Menu</a></p>
    <p><a href="elementos/get_element/Table/Financial_Table">Passo 6 - Tabela</a></p>
    </div>
</div>

