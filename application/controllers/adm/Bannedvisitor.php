<?php

// ==================== //
//   [DEV] EyeTracker   //
//     Lolsecs#6289     //
// ==================== //

defined('BASEPATH') or exit('No direct script access allowed');

Class Bannedvisitor extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->allprotect->AdminDashboard_Protection();
        $this->load->model('admin/bannedvisitor_model', 'bannedvisitor');
    }

    function index()
    {
        $data['title'] = 'Banned Visitor';
        $data['header'] = 'Banned Visitor';

        $data['ip'] = $this->bannedvisitor->GetAllIPAddress();

        $data['content'] = 'admin/content/bannedvisitor/content_bannedvisitor';
        $this->load->view('admin/layout/wrapper', $data, FALSE);
    }

    function do_add()
    {
        $response = array();

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules(
            'ip_address',
            'IP ADDRESS',
            'required',
            array('required' => '%s Cannot Be Empty.')
        );
        if ($this->form_validation->run()) $this->bannedvisitor->AddIPAddress();
        else
        {
            $response['response'] = 'false';
            $response['token'] = $this->security->get_csrf_hash();
            $response['message'] = validation_errors();

            echo json_encode($response);
        }
    }

    function do_delete()
    {
        $response = array();

        $this->form_validation->set_error_delimiters('', '');

        $this->form_validation->set_rules(
            'ip_address',
            'IP ADDRESS',
            'required',
            array('required' => '%s Cannot Be Empty.')
        );
        if ($this->form_validation->run()) $this->bannedvisitor->DeleteIPAddress();
        else
        {
            $response['response'] = 'false';
            $response['token'] = $this->security->get_csrf_hash();
            $response['message'] = validation_errors();

            echo json_encode($response);
        }
    }
}

// This Code Generated Automatically By EyeTracker Snippets. //

?>