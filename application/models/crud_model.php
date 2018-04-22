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


	public function getLatpimAngkatan($id)
	{
		$this->db->select('latpim.nama_latpim, angkatan.nama_angkatan');
		$this->db->from('angkatan');
		$this->db->join('latpim', 'latpim.id = angkatan.id_latpim');
		$this->db->where('angkatan.id', $id);
		return $this->db->get();
	}

	public function getMataPelatihan($angkatan)
	{	
		$this->db->select('pelatihan.id, pelatihan.tanggal, pelatihan.nama_fasilitator, matapelatihan.nama_matapelatihan');
		$this->db->from('pelatihan');
		$this->db->join('matapelatihan', 'matapelatihan.id = pelatihan.id_matapelatihan');
		$this->db->where('id_angkatan', $angkatan);
		$this->db->where('pelatihan.status', 1);
		return $this->db->get();
	}

	public function getRateMataPelatihan($id)
	{	
		$this->db->select('pelatihan.id, pelatihan.tanggal, pelatihan.nama_fasilitator, matapelatihan.nama_matapelatihan');
		$this->db->from('pelatihan');
		$this->db->join('matapelatihan', 'matapelatihan.id = pelatihan.id_matapelatihan');
		$this->db->where('pelatihan.id', $id);
		$this->db->where('pelatihan.status', 1);
		return $this->db->get();
	}

	public function getFound($id, $peserta)
	{
		$this->db->from('nilai_kuisioner');
		$this->db->where('id_pelatihan', $id);
		$this->db->where('id_peserta', $peserta);
		return $this->db->get();
	}

	public function getNilaiKuisioner($id)
	{	
		$this->db->select('nilai_kuisioner.id, nilai_kuisioner.tanggal, nilai_kuisioner.saran, nilai_kuisioner.id_pelatihan, nilai_kuisioner.id_peserta, detail_nilai.nilai, SUM(detail_nilai.nilai) AS tot');	
		$this->db->from('nilai_kuisioner');
		$this->db->join('detail_nilai', 'detail_nilai.id_nilai_kuisioner = nilai_kuisioner.id');
		$this->db->where('nilai_kuisioner.id_pelatihan', $id);
		return $this->db->get();
	}

}
