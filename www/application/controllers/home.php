<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MY_Controller {

    public function __construct() {
        parent::__construct();


        $this->load->library('template');
    }

    //Como este controller estende o MY_Controller, que é onde está a verificação de login e senha, então aqui você não precisa
    //fazer nenhuma verifição se o usuário está logado.
    //Lembre-se: os controllers que você deseja proteger, devem estender o MY_Controller. 
    //O controller Login não pode estender o MY_Controller, caso contrário o código entra em loop, e também não tem sentido proteger
    //a tela de login. :)
    public function index() {

        //$login = $this->session->userdata('login');
        //Descomentar para acessar a ontologia
//        exec('cd /vagrant/workspace/Prototipo/src/; sudo javac -cp ".:lib/*" colorblindOWL/CreateUser.java');
//
//
//        $teste= exec('cd /vagrant/workspace/Prototipo/src; sudo java -cp ".:lib/*" colorblindOWL.CreateUser ricardo.araujo');
//
//        $this->template->load('templates/template1', 'index', array('teste' => $teste));

        $this->template->load('templates/template1', 'index');
    }

    public function retorno() {
        $arquivo = (base_url('includes/export_list_color_java.json/'));




        $info = file_get_contents($arquivo);
        //echo $info;

        $lendo = json_decode($info, true);


        for ($i = 0; $i < count($lendo['color']); $i++) {

            print_r($i . " Usuário: " . $lendo['color'][$i] . "<br>");
        }
    }
    public function preferencia() {

       $arquivo = (base_url('includes/export_list_color_java.json/'));




        $info = file_get_contents($arquivo);


        $lendo = json_decode($info, true);




        $this->template->load('templates/template1', 'preferencia3', array('lendo'=>$lendo));
    }

}
