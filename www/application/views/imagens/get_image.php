<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$deut = array(1, 2);
$prot = array(3, 4);



if (in_array($this->session->userdata('idPatologia'), $deut)) {
    $imagem = 'assets/imagens/'.$contexto.'/'.$nome_imagem.'';
}
 
elseif (in_array($this->session->userdata('idPatologia'), $prot)) {
    $imagem = 'assets/imagens/'.$contexto.'/'.$nome_imagem.'';
} else {
    $imagem = "";
}
?>
<a href="javascript:window.history.go(-1);" class="btn btn-default">Voltar</a>

<div class="figura">
    <p><img src="<?= base_url($imagem) ?>" width="700" height="500" alt="mapa"></p>

</div>

<?php

        

?>