<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>


	
		<!--<script src="js/jquery.min.js"></script>-->
                
    <style type="text/css">
      table td div {
        padding:5px;
        background:#eee;
        height:100px;
      }
    </style>
	

  <table style='width:100%'>
    <tr>
      
      <td>
        <div id='test-2'>#test-2</div>
        
        <a href="#" id='show-test-2'>Teste</a>

      </td>
    </tr>
  </table>
  <br>
  
  
  
<script type='text/javascript'>

$(function(){  
  // test-1
  $('#show-test-1').click(function(){
    $('#test-1').oLoader({
      backgroundColor:'#f00',
      fadeInTime: 500,
      fadeOutTime: 1000,
      fadeLevel: 0.5
    });
  });
  $('#hide-test-1').click(function(){
    $('#test-1').oLoader('hide');
  });
  
  // test-2
  $('#show-test-2').click(function(){
    $('#test-2').oLoader({
      backgroundColor:'#fff',
      image: '<?= base_url('assets/loader/images/ownageLoader/loader4.gif') ?>',
      fadeInTime: 500,
      fadeOutTime: 1000,
      fadeLevel: 0.8
    });
  });
  $('#hide-test-2').click(function(){
    $('#test-2').oLoader('hide');
  });
  
  // test-3
  $('#show-test-3').click(function(){
    $('table td input').oLoader({
      backgroundColor:'#fff',
      image: '<?= base_url('assets/loader/images/ownageLoader/loader2.gif') ?>',
      style: 0,
      fadeInTime: 500,
      fadeOutTime: 1000,
      fadeLevel: 0.5
    });
  });
  $('#hide-test-3').click(function(){
    $('table td input').oLoader('hide');
  });
});

</script>
