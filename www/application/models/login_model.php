<?php

class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function ConsultaLogin($usuario, $senha) {


        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('login', $usuario);
        $this->db->where('password', $senha);
        $query = $this->db->get();
        return $query->result();
    }

    function ConsultaPatologia($id_patologia) {

        $this->db->select('*');
        $this->db->from('pathologyType');
        $this->db->where('idPathologyType', $id_patologia);
        $query = $this->db->get();
        return $query->result();
    }

}
