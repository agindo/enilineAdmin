<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_model extends CI_Model {

	public function getAll($table)
	{
		return $this->db->get($table);
	}

	public function getFind($id, $table)
	{
		return $this->db->get_where($table, array('id'=>$id))->row();
	}

	public function getFindField($id, $field, $table)
	{
		return $this->db->get_where($table, array($field=>$id));
	}

	public function getCountField($id, $field, $table)
	{
		$query = $this->db->get_where($table, array($field=>$id));
		return $query->num_rows();
	}

	public function save($data, $table)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data, $table)
	{
		$this->db->update($table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id, $table)
	{
		$this->db->where('id', $id);
		$this->db->delete($table);
	}

	public function delete_by_idField($id, $field, $table)
	{
		$this->db->get_where($table, array($field=>$id));
		$this->db->delete($table);
	}


	//--------------------------------------------------------------
    
    public function getMenuActive($level)
    {
        return $this->db->get_where('menus', array('level'=>$level, 'status'=>1));
    }
    
    public function getSubmenuActive($menu, $level)
    {
        return $this->db->get_where('submenus', array('level'=>$level, 'status'=>1, 'id_menu'=>$menu));
    }
    
    public function getCountFieldStatus($id, $field, $table)
	{
		$query = $this->db->get_where($table, array($field=>$id, 'status'=>1));
		return $query->num_rows();
	}
    
    public function getFindFieldLevel($id, $field, $table, $level)
	{
		return $this->db->get_where($table, array($field=>$id, 'level'=>$level));
	}

}
