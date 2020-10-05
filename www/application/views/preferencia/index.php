<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//Descomentar para visualizar informações da ontologia
//echo $teste;


$arquivo_mapas = (base_url('includes/json/pref_ColoredMaps_' . $this->session->userdata('login') . '_preference.json/'));
$info_mapas = file_get_contents($arquivo_mapas);

if (!empty($info_mapas)) {
    $texto_mapas = "Definido";
    $icone = 'assets/imagens/check.png';
} else {
    $texto_mapas = "Não definido";
    $icone = 'assets/imagens/uncheck.png';
}

//inserir aqui os demais cenarios
?>

<link href="<?= base_url('includes/tabela.css') ?>" rel="stylesheet">
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
    <table class="tabela-cotacao" border="1">


        <tbody id="carregamento">

            <tr><td colspan="2"> Configurações iniciais</td></tr>

            <tr><td width =50%> Contexto</td><td width =50% ></td></tr>
            <tr><td width =50%>Mapas</td><td width =50% ><a href="preferencia/contexto/Maps/ColoredMaps" ><button class='add-button'   > Configurar</button></a></td></tr>
            <tr><td width =50%>Gráficos</td><td width =50% ><a href="preferencia/contexto/Graph/PieGraph" ><button class='add-button'   > Configurar</button></a></td></tr>
            <tr><td width =50%>Tomografia</td><td width =50% ><a href="preferencia/contexto/TechnicalImages/Tomography" ><button class='add-button'   > Configurar</button></a></td></tr>
            <tr><td width =50%>Formulário</td><td width =50% ><a href="preferencia/contexto/Form/Registration_Form" ><button class='add-button'   > Configurar</button></a></td></tr>
            <tr><td width =50%>Menu</td><td width =50% ><a href="preferencia/contexto/Menu/Side_Menu" ><button class='add-button'   > Configurar</button></a></td></tr>
            <tr><td width =50%>Tabela</td><td width =50% ><a href="preferencia/contexto/Table/Financial_Table" ><button class='add-button'   > Configurar</button></a></td></tr>








        </tbody>
