<?php

// ==================== //
//   [DEV] EyeTracker   //
//     Lolsecs#6289     //
// ==================== //

defined('BASEPATH') OR exit('No direct script access allowed');

class Redeemcode extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();

        $this->lang->load(array('header', 'string', 'message'));
        $this->lib->GetVisitorData('Redeem Code');
		
		$this->main_protect->mainProtectA();
		$this->allprotect->Web_Protection();
        $this->allprotect->BlockedAccount_Protection();
		$this->allprotect->DarkblowCopierGuard();
		
		$this->load->model('main/redeemcode_model', 'redeemcode');
		$this->load->library('servercommand_library');

		if ($this->getsettings->Get2()->redeemcode != 1)
		{
			redirect(base_url('player_panel'), 'refresh');
		}
	}
	
	function index()
	{
		$data['title'] = 'Redeem Code';
		$data['isi'] = 'main/content/player_panel/content_redeemcode';
		$this->load->view('main/layout/wrapper', $data, FALSE);
	}

	function do_redeem()
	{
		$response = array();
		$this->form_validation->set_error_delimiters('', '');

		$this->form_validation->set_rules(
			'code',
			'Code',
			'required|min_length[19]|max_length[19]|alpha_dash',
			array(
				'required' => '%s Cannot Be Empty.',
				'min_length' => '%s Must Contains 19 Characters Or More.',
				'max_length' => '%s Only Can Accepted 19 Characters.'
			)
		);
		if ($this->form_validation->run()) $this->redeemcode->CodeValidationV2();
		else
		{
			$response['response'] = 'false';
			$response['token'] = $this->security->get_csrf_hash();
			$response['message'] = validation_errors();
		}
	}
}

// This Code Generated Automatically By EyeTracker Snippets. //