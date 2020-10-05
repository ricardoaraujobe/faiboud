<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    
    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->helper('form');
        $this->load->helper('url');
       
        $this->load->model('login_model');
        $this->load->library('session');
    }
    public function index() {
        $this->load->view('v_login');
    }

    public function logar() {

        $usuario = $this->input->post("usuario");
        $senha = md5($this->input->post("senha"));
        $form_data = array(
            'login' => $usuario,
            'senha' => $senha
        );
        $logado=$this->login_model->ConsultaLogin($usuario, $senha);
        
        if ($logado) {
          
            foreach($logado as $linha){
                $id_patologia=$linha->pathologyType_idPathologyType;
                $id_usuario=$linha->idUser;
                $login=$linha->login;
                $nome_usuario=$linha->nameUser;
            }
            
            $patologia=$this->login_model->ConsultaPatologia($id_patologia);
            
            foreach ($patologia as $linha2){
                $nome_patologia = $linha2->namePathologyType;
            }
         
            $dados_usuario = array(
                'login' => $login,
                'idUsuario' => $id_usuario,
                'nome' => $nome_usuario,
                'idPatologia' => $id_patologia,
                'nomePatologia' => $nome_patologia,
                'logado' => 1
            );
            
//            $this->session->set_userdata("logado", 1);
            
           $this->session->set_userdata($dados_usuario);
            
            redirect('home');
        } else {
            //caso a senha/usuário estejam incorretos, então mando o usuário novamente para a tela de login com uma mensagem de erro.
            $dados['erro'] = "Usuário/Senha incorretos";

            $this->load->view("v_login", $dados);
        }
    }
    
    

    

    public function logout() {
        $this->session->unset_userdata("logado");
        redirect(base_url());
    }

}
