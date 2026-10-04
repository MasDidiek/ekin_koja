<?php
class Authmodel extends CI_Model
{
	function __construct()
	{
        parent::__construct();
    }
	
	
	
	function get_auth_read($UserID, $menuid)
	{
        $sql = "SELECT a.id_group, a.id_menu, b.name
				FROM user_group_detail AS a, user AS b
				WHERE a.id_menu = '$menuid'
				AND b.ID = '$UserID'
				AND b.id_group = a.id_group
				AND a.read_flg = 1";
        $qry = $this->db->query($sql);
	
	
        if ($qry->num_rows() > 0)
		{
            return TRUE;
        }else{
            return FALSE;
        }
    }
	
	

	function getValidUserData($UserName, $UserPwd)
	{
		
		$query = $this->db->get_where('usermst_client', array('UserName' => $UserName,'UserPwd' => $mdpassword), 1, 0);
		return $query->result_array();
	}
	
	
	  //cek data dari tabel partner sebagai user administrator
	function loginMember($EmailID, $UserPwd, $id_client)
	{
	
		$sql    = "SELECT * FROM customer WHERE (email =? or phone = ?) AND password=?";
		$query  = $this->db->query($sql, array($EmailID, $EmailID, $UserPwd));
		$row 	= $query->result_array();
	
		return $row;
		
	}
		
	function getBankMember($id_customer, $id_client)
	{
		
		$sql = "SELECT a.*, b.nama_bank FROM `member_bank` a
		LEFT JOIN mst_bank b ON a.id_bank = b.id_bank
		WHERE `id_member` = $id_customer order by id ASC";
		$qry = $this->db->query($sql);
		$row = $qry->result();
		
		return $row;
	}
		
		
	function dataMutasiMember($id_customer, $limit, $offset, $id_client)
	{
		 $sql = "SELECT a.*, b.name
				FROM member_wallet a 
				LEFT JOIN customer b on a.id_customer = b.id_customer
				WHERE b.id_customer = $id_customer ORDER BY  a.id_wallet DESC
				limit $limit offset $offset";
				
		
	        $qry = $this->db->query($sql);
	        $row = $qry->result();
		
		return $row;
	}
	
	
	function member_detail($EmailID, $id_client)
	{
		$query = $this->db->get_where('customer', array('email' => $EmailID), 1, 0);
		return $query->result_array();
		
	}
	
	
	function getDetMember($id_customer, $id_client)
	{
		$query = $this->db->get_where('customer', array('id_customer' => $id_customer), 1, 0);
		return $query->result_array();
		
	}
	
	
	function getAuthRead($UserID, $MenuID)
	{
		//echo $UserID.'-----'.$MenuID;
        $sql = "SELECT ug.UserGroupID, ug.MenuID, u.UserName
				FROM usergroupdtlmst AS ug, usermst AS u
				WHERE ug.MenuID = '$MenuID'
				AND u.UserID = '$UserID'
				AND u.UserGroupID = ug.UserGroupID
				AND ug.ReadFlg = 1";
        $qry = $this->db->query($sql);
	
	
        if ($qry->num_rows() > 0)
		{
            return TRUE;
        }else{
            return FALSE;
        }
    }
	
    
    function GetUsername($UserID)
    {
     	$sql      = "select UserName from usermst where UserID = '$UserID'";
     	$qry      = $this->db->query($sql);
     	$row      = $qry->result_array();
     	$UserName = $row[0]['UserName'];
     	
		return $UserName;
	}
	function config_module($MENU_ID)
	{
		$sql = "SELECT * FROM config_module WHERE MenuID = '$MENU_ID'";
        $qry = $this->db->query($sql);
        $row = $qry->result();
		
        return $row;
	}
	function GetmenuName($id){
		$sql = "SELECT MenuName FROM menumst where cMenuName='$id'";
		$qry = $this->db->query($sql);
		$num = $qry->num_rows();
		
		if($num > 0){
			$row = $qry->result_array();
			return $row[0]['MenuName'];
		}
	}
	
	
	function cekEmailExist($email, $id_client)
	{
		$DBMaster = $this->load->database('master', TRUE);
			
		$sql = "SELECT db_name, db_pass, db_user FROM db_client  WHERE id_client = $id_client";
	        $qry = $DBMaster->query($sql);
	        $row = $qry->result();	
		
		$db_name = $row[0]->db_name;
		$db_pass = $row[0]->db_pass;
		$db_user = $row[0]->db_user;
			
		
		$this->db = $this->load->database('mysqli://'.$db_user.':'.$db_pass.'@localhost/'.$db_name,true);
		
		$sql = "SELECT id_customer FROM customer where lower(email) = '$email'";	
		
		
		$qry = $this->db->query($sql);
		$num = $qry->num_rows();
        return $num;
	}
	
	function cekPhoneExist($phone, $id_client)
	{
		$this->db =  $this->load_db($id_client);
		
		$sql = "SELECT id_customer FROM customer where phone = '$phone'";			
		$qry = $this->db->query($sql);
		$num = $qry->num_rows();
        	return $num;
	}
	
	
	function getMemberSaldo($id_member, $id_client)
	{
	
		$this->db =  $this->load_db($id_client);
		$sql = "SELECT saldo FROM member_wallet where id_customer = '$id_member' order by id_wallet DESC";		
		$qry = $this->db->query($sql);
		$row = $qry->result();
		$num = $qry->num_rows();
		
		if($num==0)
		{
			return 0;
		}else{
		    $saldo = $row[0]->saldo;
			return  $saldo;
		}
		
		
      
	}
	
	
    function getRequestPending($id_member, $id_client)
	{
	
	    //$this->db =  $this->load_db($id_client);
	    $DBM = $this->load->database('master', TRUE);
        $sql = "SELECT SUM(jml_req) as jumlah FROM `member_req_penarikan` WHERE id_member = $id_member AND status < 2 AND id_client =$id_client";
		$qry = $DBM->query($sql);
        $row = $qry->result();
		$jmlh = $row[0]->jumlah;
		
		return $jmlh;
	}


	
	function load_db($id_client)
	{
		$DBMaster = $this->load->database('master', TRUE);
		
		$sql = "SELECT db_name, db_pass, db_user FROM db_client  WHERE id_client = $id_client";
	        $qry = $DBMaster->query($sql);
	        $row = $qry->result();	
		
		$db_name = $row[0]->db_name;
		$db_pass = $row[0]->db_pass;
		$db_user = $row[0]->db_user;
			
		
		
		
		return $this->load->database('mysqli://'.$db_user.':'.$db_pass.'@localhost/'.$db_name,true);;
		
	}
	
	  //cek data dari tabel partner sebagai user administrator
	function getDataConfig($id, $id_client)
	{
	
		$this->db =  $this->authmodel->load_db($id_client);
		$query = $this->db->get_where('config ', array('id' => $id), 1, 0);
		return $query->result();
		
	}
	
	function getMemberRequest($id_client, $limit, $offset, $id_member)
	{
	
	
	    	$DBM = $this->load->database('master', TRUE);
		
		$sql = "SELECT a.*, b.nama_perusahaan
		FROM `member_req_penarikan` a LEFT JOIN ms_client b  ON a.id_client = b.ID
		WHERE a.id_client = $id_client AND id_member = $id_member order by tgl_req DESC limit $limit offset $offset";
		$qry = $DBM->query($sql);
        	$row = $qry->result();
		
		return $row;
	}
	
	
    function insertAdminValidasi($id_req, $note, $status)
	{
		$detReq    = $this->admin_wallet_model->getDetReq($id_req);
		$id_client = $detReq[0]->id_client;
		$kd_req    = $detReq[0]->kd_req;
		
		$this->db =  $this->authmodel->load_db($id_client);
		
		$admin = $this->session->userdata('UserName');
			
			$data = array(
					'id_req'  => $id_req,
					'admin'   => $admin,
					'note'	=> $note,
					'status'  => $status,
			);
		
		
		$this->db->insert('admin_validasi_request', $data);
		
		if($status==3)
		{
			$keterangan   = 'Reject Request dana untuk Kode Request #'.$kd_req;
		}elseif($status==1){
			$keterangan   = 'Accept Request dana untuk Kode Request #'.$kd_req;
		}
		
		
		$this->insertLogAdmin($keterangan, $id_client, $id_req);
		
		
		return true;
	}
	
	
	
    function insertClientValidasi()
	{
		
	
		$status       = $this->input->post('pilihan');
		$id_req 	   = $this->input->post('id_req');
		$id_customer  = $this->input->post('id_customer');
		$jml_req      = $this->input->post('jml_req');//
		$jumlah       = clearTag($jml_req);
		
		$ket          = $this->input->post('note1');
		$ket2          = $this->input->post('note2');//untuk member
	
		
		$detReq    = $this->admin_wallet_model->getDetReq($id_req);
		$id_client = $detReq[0]->id_client;
		$kd_req    = $detReq[0]->kd_req;
		
		$admin = $this->session->userdata('UserName');
		$DB2 =  $this->authmodel->load_db($id_client);
		
		//print_array();exit;
	
			$data = array(
					'id_req'	   => $id_req,
					'id_bank_tf'   => $this->input->post('bank_transfer'),
					'admin'        => $admin,
					'jumlah'	   => $jumlah,
					'keterangan'   => $ket,
					'keterangan2'   => $ket2,
					'status'	   => $status,
			);
		

		$DB2->insert('client_validasi_request', $data);
	
		$id_wallet = $id_req;
		if($status==3)
		{
			$keterangan   = 'Reject Request dana untuk Kode Request #'.$kd_req;
		}elseif($status==2){
			$keterangan   = 'Accept Request dana untuk Kode Request #'.$kd_req;
			
			$cek = $this->admin_wallet_model->cek_status($id_req);
			
			if($cek==true)
			{
				$id_mutasi = $this->import_model->insert_mutasi($id_customer, 'out', $jml_req, $ket);
				$id_wallet = $this->import_model->insert_member_wallet($id_customer, 'out', $jml_req, $ket);
				$this->email_model->kirimEmailTransfer($id_req, $id_customer);
			}
			
		}
		
		$this->insertLogAdmin($keterangan, $id_client, $id_wallet);
		$this->email_model->kirimEmailTransfer($id_req, $id_customer);
		
		return true;
	}
	
	
	
	function cekPendingRequest($id_member)
	{
	
		$sql = "SELECT id_member FROM member_req_penarikan where id_member = $id_member";
        $qry = $this->db->query($sql);
        $num = $qry->num_rows();
		
		return $num;		
	}
		
	function insertLogAdmin($keterangan, $id_client, $id_wallet)
	{
		$UserName = $this->session->userdata('UserName');
		
		$this->db =  $this->authmodel->load_db($id_client);
		$dataLog = array(
			'username' => $UserName,
			'deskripsi' => $keterangan,
			'tanggal' => date('Y-m-d H:i:s'),
			'tipe_kegiatan' => 2,
			'id_target' => $id_wallet,
		);
		
		$this->db->insert('admin_log', $dataLog);
		
		return true;
	}
	
	
		
		
	
	
}
?>
