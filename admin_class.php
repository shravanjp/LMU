<?php
session_start();
ini_set('display_errors', 1);
class Action
{
	private $db;
	public function __construct(){
		ob_start();
		include 'db_connect.php';
		$this->db = $conn;
	}
	function __destruct(){
		$this->db->close();
		ob_end_flush();
	}
	function login()
	{
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '" . $username . "' and password = '" . md5($password) . "' ");
		if ($qry->num_rows > 0) {
			foreach ($qry->fetch_array() as $key => $value) {
				if ($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			return 1;
		} else {
			return 3;
		}
	}
	
	function logout()
	{
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2()
	{
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user()
	{
		extract($_POST);
		$data = "name='$name'";
		$data .= ",username='$username'";
		$data .= ",password='".md5($password)."'";
		$data .= ", type = '$type' ";
		if (empty($name) || empty($username) || empty($password)) {
			return 0;
		}
		

		
		if (empty($id)) {
			$qry = $this->db->query("SELECT * FROM users where $username='".$username."'");
			if ($qry!=false && $qry->num_rows>0) {
				return 2;
			} 
			if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $username)? TRUE : FALSE)
				return -1;
			else {
				$temp=$this->db->query("INSERT INTO users set " .$data);
				if($temp)
				return 1;
			}
		}
		else{
			if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $username)? TRUE : FALSE)
			return -1;
			$qry = $this->db->query("SELECT * FROM users where $username='".$username."'");
			if ($qry!=false && $qry->num_rows>=1) {
				return 2;
			} 
			else {
				$temp=$this->db->query("UPDATE users set ".$data." where id = ".$id);
				if($temp)
				return 1;
			}
			
		}
			return 2;
			
	}


	function save_category(){
		extract($_POST);
		if($name == "" || $price == "")
			return 3;
		$data = " name = '$name' ";
		$data .= ", price = '$price' ";
		
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO laundry_categories set " . $data);
			return 1;
		} else {
			$save = $this->db->query("UPDATE laundry_categories set " . $data . " where id=" . $id);
			return 2;
		}
	}
	function delete_category(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM laundry_categories where id = " .$id);
		if ($delete)
			return 1;
		else
			return 2;
	}
	function delete_user(){
		extract($_POST);
		if ($id == $_SESSION['login_id']) {
			return 2;
		} else {
			$delete = $this->db->query("DELETE FROM users where id = " .$id);
		}
		if ($delete)
			return 1;
	}
	function save_supply(){
		extract($_POST);
		if($name == "")
			return 0;
		$data = " name = '$name' ";
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO supply_list set " . $data);
		} else {
			$save = $this->db->query("UPDATE supply_list set " . $data . " where id=" . $id);
		}
		if ($save)
			return 1;
	}
	function delete_supply(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM supply_list where id = " . $id);
		if ($delete)
			return 1;
	}
	
	function save_laundry(){
		extract($_POST);
		if($customer_name == "")
			return 2;
		$data = " customer_name = '$customer_name' ";
		if (isset($status))
			$data .= ", status = '$status' ";
		if (empty($id)) {
			$queue = $this->db->query("SELECT `queue` FROM laundry_list where status != 3 order by id desc limit 1");
			$queue = $queue->num_rows > 0 ? $queue->fetch_array()['queue'] + 1 : 1;
			$data .= ", queue = '$queue' ";
			$data .= ", total_amount = '$tamount' ";
			$data .= ", remarks = '$remarks' ";
			$save = $this->db->query("INSERT INTO laundry_list set ".$data);
			if ($save) {
				$id = $this->db->insert_id;
				foreach ($weight as $key => $value) {
					$items = " laundry_id = '$id' ";
					$items .= ", laundry_category_id = '$laundry_category_id[$key]' ";
					$items .= ", weight = '$weight[$key]' ";
					$items .= ", unit_price = '$unit_price[$key]' ";
					$items .= ", amount = '$amount[$key]' ";
					$save2 = $this->db->query("INSERT INTO laundry_items set ".$items);
				}
				return 1;
			}
		} else {
			$data .= ", total_amount = '$tamount' ";
			$data .= ", remarks = '$remarks' ";
			$save = $this->db->query("UPDATE laundry_list set ".$data." where id=".$id);
			if ($save) {
				$this->db->query("DELETE FROM laundry_items where id in(".implode(',', $item_id).")");
				foreach ($weight as $key => $value) {
					$items = " laundry_id = '$id' ";
					$items .= ", laundry_category_id = '$laundry_category_id[$key]' ";
					$items .= ", weight = '$weight[$key]' ";
					$items .= ", unit_price = '$unit_price[$key]' ";
					$items .= ", amount = '$amount[$key]' ";
					if (empty($item_id[$key]))
						$save2 = $this->db->query("INSERT INTO laundry_items set " .$items);
					else
						$save2 = $this->db->query("UPDATE laundry_items set " .$items. " where id=" .$item_id[$key]);
				}
				return 1;
			}
		}
	}

	function delete_laundry(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM laundry_list where id = " . $id);
		if ($delete)
			return 1;
	}
	function save_inv(){
		extract($_POST);
		$invqry = $this->db->query("SELECT * FROM inventory where id = '" . $id . "' ");
		$avl = $invqry->fetch_assoc();
		$act_qty = $avl['qty'];
		$data = " supply_id = '$supply_id' ";
		$act_avl = 0;
		if ($stock_type == 2) {
			if ($avl['available'] < $qty)
				return $qty;
			else
				$act_avl = $avl['available'] - $qty;
		}
		if ($stock_type == 1) {
			$act_avl = $avl['available'] + $qty;
			$act_qty += $qty;
		}
		if ($act_avl <= 0) {
			$act_avl = 0;
			$stock_type = 2;
		} else {
			$stock_type = 1;
		}
		$data .= ", qty = '$act_qty' ";
		$data .= ", available = '$act_avl' ";
		$data .= ", stock_type = '$stock_type' ";
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO inventory set " . $data);
		} else {
			$save = $this->db->query("UPDATE inventory set " . $data . " where id=" . $id);
		}
		if ($save)
			return 1;
	}
	function delete_inv(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM inventory where id = " . $id);
		if ($delete)
			return 1;
	}
}
