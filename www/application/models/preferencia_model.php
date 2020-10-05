<?php

class Preferencia_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_cor($original_color, $contexto) {


        $this->db->select('idcolorPreferences, preferedColor, context');
        $this->db->from('colorPreferences');
        $this->db->where('originalColor', $original_color);
        $this->db->where('user_idUser', $this->session->userdata('idUsuario'));
        $this->db->where('context', $contexto);
        $query = $this->db->get();
        return $query->result();
    }

    function Salva_dados($dados) {
        $this->db->insert('colorPreferences', $dados);
        if ($this->db->affected_rows() >= '1') {
            return TRUE;
        }

        return FALSE;
    }
    
    function Deleta_dados($id_cor) {
        
        $this->db->delete('colorPreferences', array('idcolorPreferences' => $id_cor));
        
        if ($this->db->affected_rows() >= '1') {
            return TRUE;
        }

        return FALSE;
    }
}
