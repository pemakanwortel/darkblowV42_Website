<?php

// ==================== //
//   [DEV] EyeTracker   //
//     Lolsecs#6289     //
// ==================== //

defined('BASEPATH') or exit('No direct script access allowed');

Class Banned extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->lang->load(array('header', 'string'));
        $this->lib->GetVisitorData('Banned');

        $this->allprotect->BlockedAccount_Protection();
		$this->allprotect->DarkblowCopierGuard();
        $this->allprotect->Banned_Protection2();
    }

    function index()
    {
        $data['title'] = 'IP Address Banned';
        $this->load->view('main/content/banned/content_banned', $data, FALSE);
    }
}

// This Code Generated Automatically By EyeTracker Snippets. //

?>