<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Register extends MY_Controller {

    public function __construct() {
        parent::__construct();


        $this->load->library('template');
        $this->load->model('user_model');
    }

    //Como este controller estende o MY_Controller, que é onde está a verificação de login e senha, então aqui você não precisa
    //fazer nenhuma verifição se o usuário está logado.
    //Lembre-se: os controllers que você deseja proteger, devem estender o MY_Controller. 
    //O controller Login não pode estender o MY_Controller, caso contrário o código entra em loop, e também não tem sentido proteger
    //a tela de login. :)
    public function create_user() {
        
        $nome="";
        $login="";
        $senha="";
        $patologia="";
        $this->template->load('templates/template1', 'admin/add', $variaveis);
    }

    

}
