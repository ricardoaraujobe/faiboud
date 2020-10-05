

<link href="<?= base_url('includes/tabela.css') ?>" rel="stylesheet">

<a href="javascript:window.history.go(-1);" class="btn btn-default">Voltar</a>

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
            $('#carregado').oLoader({
                backgroundColor: '#fff',
                image: '<?= base_url('assets/loader/images/ownageLoader/loader4.gif') ?>',
                fadeInTime: 500,
                fadeOutTime: 1000,
                fadeLevel: 0.8
            });
        });




    });

</script>

<table style='width:100%'>
    <tr>

        <td>
        </td>
        <td>
            <div id='carregado'></div>



        </td>
    </tr>
</table>

<table class="tabela-cotacao" border="1">
   

    <tbody id='carregamento'>
        <tr><td colspan="2"> Contexto: <b><?php echo $context; ?></b> </td></tr>
        <tr><td colspan="2"> Cor original</td></tr>
        <tr><td colspan="2"  style='background-color:<?php echo $cor_original; ?>;'>&nbsp; </td></tr>
        <tr><td colspan="2"> Cores alternativas</td></tr>
        <?php
        /*
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */

        $deut = array(1, 2);
        $prot = array(3, 4);
         if (in_array($this->session->userdata('idPatologia'), $deut)) {
            $patologia = 'Deut';
        } elseif (in_array($this->session->userdata('idPatologia'), $prot)) {
            $patologia = 'Prot';
        } else {
            $patologia = "";
        }
        
        
        
        for ($i = 0; $i < count($lendo['color']); $i++) {

            $cor[$i] = explode("-", $lendo['color'][$i]);
            $cor_tipo[$i] = explode("_", $cor[$i][0]);

            if ($cor_tipo[$i][1] == $patologia) {


//                print_r(" <tr><td style='background-color:" . $cor[$i][1] . ";'><a href='".base_url('index.php/preferencia/inserepreferencia')."/" . $cor[$i][0] ."/".$cor_or. "' id='carregamento'>Escolha</a></td></tr>");
                print_r(" <tr><td  width =50% style='background-color:" . $cor[$i][1] . ";'></td><td><a href='" . base_url('index.php/preferencia/inserepreferencia') . "/" . $cor[$i][0] . "/" . $cor_or ."/" .$contexto."/" .$contexto_especifico. "' ><button  class='add-button'  ><i class='glyphicon glyphicon-plus'></i> Adicionar cor alternativa</button></a></td></tr>");
            } 
        }
        ?>







    </tbody>
</table>





<br>


</div>


