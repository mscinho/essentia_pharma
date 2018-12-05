<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_Model extends CI_Model {

	public function table_exists($table) {
		return $this->db->table_exists($table);
	}

	public function add($table,$data){
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1') {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function edit($table,$data,$fieldID,$ID) {
        $this->db->where($fieldID,$ID);
        $this->db->update($table, $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public function delete($table,$fieldID,$id) {
        $this->db->where($fieldID,$id);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1') {
            return TRUE;
        }   
        return FALSE;       
    }

    public function get($table,$type,$fieldOrder=null,$orderby=null,$limit=null,$offset=null) {
        $this->db->from($table);
        if($this->session->f_busca) 
            $this->db->where("nome LIKE '%".$this->session->f_busca."%'");
        if($fieldOrder)
            $this->db->order_by($fieldOrder,$orderby);
        if($limit)
            $this->db->limit($limit);
        if($offset)
            $this->db->offset($offset);

        if($type == 'result') {
            return $this->db->get()->result();
        } else {
            return $this->db->get()->num_rows();
        }
    }
    /*
    public function get($table,$type='result',$fieldID=null,$id=null,$fieldOrder=null,$orderby=null,$limit=null,$offset=null) {
        $this->db->from($table);
        
        if($fieldID)
            $this->db->where($fieldID,$id);

        if($fieldOrder)
            $this->db->order_by($fieldOrder,$orderby);

        if($limit)
            $this->db->limit($limit);

        if($offset)
            $this->db->offset($offset);
        
        if($type == 'result') {
            return $this->db->get()->result();
        } elseif($type == 'num_rows') {
            return $this->db->get()->num_rows();
        } else {
            return $this->db->get()->row();
        }
    }
    */
	
}