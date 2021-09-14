<?php

// ==================== //
//   [DEV] EyeTracker   //
//     Lolsecs#6289     //
// ==================== //

defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function GetItemRealName2($id)
	{
		$query = $this->db->get_where('player_items', array('owner_id' => $_SESSION['uid'], 'object_id' => $id))->row();
		if ($query)
		{
			return $query;
		}
		else
		{
			redirect(base_url('player_panel/inventory'), 'refresh');
		}
	}

	function GetItemCategory($item_id)
	{
		if ($item_id >= 100003001 && $item_id <= 904007069)
		{
			return 1;
		}
		else if ($item_id >= 1001001003 && $item_id <= 1105003032)
		{
			return 2;
		}
		else if ($item_id >= 1300002003 && $item_id <= 1302379000)
		{
			return 3;
		}
	}

	function GetItemRealName($item_id)
	{
		$query = $this->db->get_where('shop', array('item_id' => $item_id))->row();
		if ($query)
		{
			return $query->item_name;
		}
		else
		{
			return "";
		}
	}
	
	function GetInventoryPerPage($limit, $start)
	{
		return $this->db->where('owner_id', $_SESSION['uid'])->order_by('object_id', 'desc')->get('player_items', $limit, $start)->result_array();
	}
	
	function GetInventoryCount()
	{
		return $this->db->where('owner_id', $_SESSION['uid'])->get('player_items')->num_rows();
	}
	
	function DeleteItem()
	{
		sleep(1);
		$response = array();

		$data = array(
			'player_id' => $this->encryption->encrypt($this->input->post('player_id')),
			'item_id' => $this->encryption->encrypt($this->input->post('item_id'))
		);

		$query = $this->db->get_where('player_items', array('owner_id' => $_SESSION['uid'], 'item_id' => $this->encryption->decrypt($data['item_id'])))->row();
		if ($query)
		{
			$delete = $this->db->where(array('owner_id' => $query->owner_id, 'item_id' => $query->item_id))->delete('player_items');
			if ($delete)
			{
				$response['response'] = 'true';
				$response['token'] = $this->security->get_csrf_hash();
				$response['message'] = 'Successfully Delete This Item.';
				echo json_encode($response);
			}
			else
			{
				$response['response'] = 'false';
				$response['token'] = $this->security->get_csrf_hash();
				$response['message'] = 'Failed To Delete This Item.';
				echo json_encode($response);
			}
		}
		else
		{
			$response['response'] = 'false';
			$response['token'] = $this->security->get_csrf_hash();
			$response['message'] = 'Failed To Delete This Item.';
			echo json_encode($response);
		}
	}
}
// This Code Generated Automatically By EyeTracker Snippets. //