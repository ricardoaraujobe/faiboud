

<link href="<?= base_url('includes/tabela.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') ?>" rel="stylesheet">
<a href="javascript:window.history.go(-1);" class="btn btn-default">Voltar</a>

<table class="tabela-cotacao" border="1">


    <tbody>
        <tr><td> Cor original</td><td></td></tr>
        <?php
        /*
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */

        for ($i = 0; $i < count($lendo['color']); $i++) {

            $cor[$i] = explode("-", $lendo['color'][$i]);


            print_r(" <tr><td style='background-color:" . $cor[$i][1] . ";'></td><td><a href='getcoralterantiva/" . $cor[$i][0] . "'> Escolher cor alternativa</button></a></td></tr>");
        }
        ?>








    </tbody>
</table>





<br>


</div>


