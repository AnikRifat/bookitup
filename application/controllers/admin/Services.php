<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Services extends Home_Controller {

    public function __construct()
    {
        parent::__construct();
        //check auth
        if (!is_user()) {
            redirect(base_url());
        }
    }


    public function index(){
        $data = array();
        $data['page_title'] = 'Service';     
        $data['page'] = 'Service';   
        $data['service'] = FALSE;
        $data['category'] = FALSE;
        $data['categories'] = $this->admin_model->select_by_user('service_category');
        $data['service_extras'] = $this->admin_model->get_extra_services();
        $data['services'] = $this->admin_model->select_by_order_user('services');
        $data['staffs'] = $this->admin_model->select_by_user('staffs');
        $data['main_content'] = $this->load->view('admin/user/services',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    public function add()
    {	
       
        check_status();

        if($_POST)
        {   
            $id = $this->input->post('id', true);

            //validate inputs
            $this->form_validation->set_rules('name', trans('name'), 'required');
            
            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('error', validation_errors());
                redirect(base_url('admin/services'));
            } else {

                if (empty($this->input->post('orders'))) {
                    $orders = 0;
                }else{
                    $orders = $this->input->post('orders');
                }
                
                if (empty($this->input->post('category_id'))) {
                    $category_id = 0;
                }else{
                    $category_id = $this->input->post('category_id');
                }

                if (empty($this->input->post('allow_zoom'))) {
                    $zoom_link = '';
                }else{
                    $zoom_link = $this->input->post('zoom_link');
                }

                if (empty($this->input->post('allow_gmeet'))) {
                    $google_meet = '';
                }else{
                    $google_meet = $this->input->post('google_meet');
                }

                if ($this->input->post('duration_type') == 'day') {
                    $duration = '1';
                }else{
                    $duration = $this->input->post('duration');
                }

                if (!empty($this->input->post('service_extra'))) {
                    $service_extra = implode(',', $this->input->post('service_extra'));
                }else{
                    $service_extra = '';
                }

                $data=array(
                    'user_id' => user()->id,
                    'business_id' => $this->business->uid,
                    'name' => $this->input->post('name', true),
                    'category_id' => $category_id,
                    'slug' => str_slug(trim($this->input->post('name'))),
                    'details' => $this->input->post('details', true),
                    'service_type' => $this->input->post('service_type', true),
                    'number_of_service' => $this->input->post('number_of_service', true),
                    'service_repeat' => $this->input->post('service_repeat', true),
                    'capacity' => $this->input->post('capacity', true),
                    'duration' => $duration,
                    'duration_type' => $this->input->post('duration_type', true),
                    'price' => $this->input->post('price', true),
                    'tax' => $this->input->post('tax', true),
                    'staffs' => json_encode($this->input->post('staffs', true)),
                    'status' => $this->input->post('status', true),
                    'zoom_link' => $zoom_link,
                    'google_meet' => $google_meet,
                    'orders' => $orders,
                    'enable_service_extra' => $this->input->post('enable_service_extra', true),
                    'service_extra' => $service_extra,
                    'created_at' => my_date_now()
                );
                
                //if id available info will be edited
                if ($id != '') {
                    $this->admin_model->edit_option($data, $id, 'services');
                    $this->session->set_flashdata('msg', trans('updated-successfully')); 
                } else {
                    $total = get_total_value('services');
                    if (ckeck_plan_limit('services', $total) == FALSE) {
                        $this->session->set_flashdata('error', trans('reached-maximum-limit'));
                        redirect(base_url('admin/services'));
                        exit();
                    }
                    
                    $id = $this->admin_model->insert($data, 'services');
                    $edata=array(
                        'image' => 'assets/front/img/no-image.png',
                        'thumb' => 'assets/front/img/no-image.png'
                    );
                    $this->admin_model->edit_option($edata, $id, 'services');
                    $this->session->set_flashdata('msg', trans('inserted-successfully')); 
                }

                //upload image
                $data_img = $this->admin_model->do_upload('photo');
                if($data_img){
                    $data_img = array(
                        'image' => $data_img['medium'],
                        'thumb' => $data_img['thumb']
                    );
                    $this->admin_model->edit_option($data_img, $id, 'services'); 
                 }

                redirect(base_url('admin/services'));

            }
        }      
        
    }

    public function edit($id)
    {  
        
        $data = array(); 
        $data['page'] = 'Service';   
        $data['page_title'] = 'Edit';   
        $data['service'] = $this->admin_model->select_option($id, 'services');
        $data['service_extras'] = $this->admin_model->get_extra_services();
        $data['categories'] = $this->admin_model->select_by_user('service_category');
        $data['staffs'] = $this->admin_model->select_by_user('staffs');
        $data['main_content'] = $this->load->view('admin/user/services',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    public function category(){
        $data = array();
        $data['page_title'] = 'Category';     
        $data['page'] = 'Service';   
        $data['service'] = FALSE;
        $data['category'] = FALSE;
        $data['categories'] = $this->admin_model->select_by_user('service_category');
        $data['main_content'] = $this->load->view('admin/user/category',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    
    public function add_category()
    {	
        check_status();

        if($_POST)
        {   
            $id = $this->input->post('id', true);

            //validate inputs
            $this->form_validation->set_rules('name', trans('name'), 'required');
            
            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('error', validation_errors());
                redirect(base_url('admin/services'));
            } else {

                if (empty($this->input->post('orders'))) {
                    $orders = 0;
                }else{
                    $orders = $this->input->post('orders');
                }

                if ($this->input->post('icon_image', true) == 1) {
                    $is_active = 1;
                }else{
                     $is_active = 2;
                }

                $data=array(
                    'user_id' => user()->id,
                    'business_id' => $this->business->uid,
                    'name' => $this->input->post('name', true),
                    'icon' => $this->input->post('icon', true),
                    'status' => $this->input->post('status', true),
                    'orders' => $orders,
                    'is_active' => $is_active
                );
                $data = $this->security->xss_clean($data);
                if ($id != '') {
                    $this->admin_model->edit_option($data, $id, 'service_category');
                    $this->session->set_flashdata('msg', trans('updated-successfully')); 
                } else {
                    $id = $this->admin_model->insert($data, 'service_category');
                    $this->session->set_flashdata('msg', trans('inserted-successfully')); 
                }

                $data_img = $this->admin_model->do_upload('photo');
                if($data_img){
                    $data_img = array(
                        'image' => $data_img['thumb'],
                    );
                    $this->admin_model->edit_option($data_img, $id, 'service_category'); 
                 }

                redirect(base_url('admin/services/category'));

            }
        }      
        
    }

    public function edit_category($id)
    {  
        $data = array();
        $data['page_title'] = 'Edit Category';   
        $data['page'] = 'Service';   
        $data['category'] = $this->admin_model->select_option($id, 'service_category');
        $data['main_content'] = $this->load->view('admin/user/category',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    public function category_update($status) 
    {
        $data = array(
            'enable_category' => $status
        );
        $this->admin_model->edit_option($data, $this->business->id, 'business');
        
        if ($status == 1) {
            $this->session->set_flashdata('msg', trans('activate-successfully')); 
        } else {
            $this->session->set_flashdata('msg', trans('deactivate-successfully')); 
        }
        
        echo json_encode(array('st' => 1));
    }

    public function delete($id)
    {
        $this->admin_model->delete($id,'services'); 
        echo json_encode(array('st' => 1));
    }

    public function extra_delete($id)
    {
        $this->admin_model->delete($id,'service_extra'); 
        echo json_encode(array('st' => 1));
    }

    public function delete_category($id)
    {
        $this->admin_model->delete($id,'service_category'); 
        echo json_encode(array('st' => 1));
    }

    public function service_extra(){
        $data = array();
        $data['page_title'] = 'Service Extra';     
        $data['page'] = 'Service';   
        $data['service'] = FALSE;
        $data['service_extra'] = FALSE;
        $data['service_extras'] = $this->admin_model->select_by_user('service_extra');
        $data['main_content'] = $this->load->view('admin/user/service_extra',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


     public function add_service_extra()
    {   

        check_status();

        if($_POST)
        {   
            $id = $this->input->post('id', true);

            $data=array(
                'user_id' => user()->id,
                'business_id' => $this->business->uid,
                'name' => $this->input->post('name', true),
                'price' => $this->input->post('price', true),
                'duration_type' => $this->input->post('duration_type', true),
                'duration' => $this->input->post('duration', true),
                'status' => $this->input->post('status', true),
                'created_at' => my_date_now(),
            );
            $data = $this->security->xss_clean($data);
            if ($id != '') {
                $this->admin_model->edit_option($data, $id, 'service_extra');
                $this->session->set_flashdata('msg', trans('updated-successfully')); 
            } else {
                $id = $this->admin_model->insert($data, 'service_extra');
                $this->session->set_flashdata('msg', trans('inserted-successfully')); 
            }

            redirect(base_url('admin/services/service_extra'));

            
        }      
        
    }


    public function edit_service_extra($id)
    {  
        $data = array();
        $data['page_title'] = 'Edit Service Extra';   
        $data['page'] = 'Service';   
        $data['service_extra'] = $this->admin_model->select_option($id, 'service_extra');
        $data['main_content'] = $this->load->view('admin/user/service_extra',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    public function delete_service_extra($id)
    {
        $this->admin_model->delete($id,'service_category'); 
        echo json_encode(array('st' => 1));
    }


}
	

