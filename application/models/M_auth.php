<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_auth extends CI_Model
{
    function login_authentication($table, $where)
    {
        return $this->db->get_where($table, $where);
    }

    function update_last_login($id_user)
    {
        return $this->db->update('user', ['last_login' => date('Y-m-d H:i:s')], ['id' => $id_user]);
    }
}
