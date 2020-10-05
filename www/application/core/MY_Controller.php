<?php 

class MY_Controller extends CI_Controller {
	/*
	 * Este controller deve estender o CI_Controller normalmente, pois aqui não precisamos fazer verificação de senha, já que
	 * não tem sentido querer proteger a tela de login. ;)
	 * A função abaixo simplesmente verifica se o conteúdo da variável logado na sessão é igual a 1, caso seja, então, então não faz nada, caso não seja
	 * então redireciona novamente para o controller de login.
	 */
 	public function __construct()
       {
            parent::__construct();
			
			$logado = $this->session->userdata("logado");
			
			if ($logado != 1) 
				redirect(base_url('index.php/login'));				
       }
}
