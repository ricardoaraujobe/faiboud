

<link href="<?= base_url('includes/tabela.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') ?>" rel="stylesheet">
  

<a href="<?= base_url('index.php/preferencia') ?>" class="btn btn-default">Voltar às configurações</a>

<style type="text/css">
      table td div {
        padding:5px;
        background:#ffff;
        height:60px;
      }
    </style>
	

  

  
  
  
<script type='text/javascript'>

$(function(){  
 
  $('#carregamento').click(function(){
    $('#carregar').oLoader({
      backgroundColor:'#eee',
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
        <div id='carregar'></div>
        
        

      </td>
    </tr>
   
<table class="tabela-cotacao" border="1">

    
    <tbody id="carregamento">
       <tr><td colspan="3"> Contexto: <b><?php echo $context; ?></b> </td></tr>
        <tr><td width =33%> Cor original</td><td width =33% >Cores alternativas</td><td width =33%>Ação</td></tr>
      
            <?php
      
        
        echo $dados;
        ?>

   



<?php
//
//if($flag==1){
//
//?>

        <!--<tr><td colspan="3"><a  href="//<?= base_url('index.php/preferencia').'/'.$this->uri->segment(4, 0) ?>" ><button class='add-button'   > Voltar às configurações </button></a>
</td></tr>-->
        <?php
//}
//        ?>
    </tbody>
    
</table>



<br>





