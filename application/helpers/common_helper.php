<?php  
function user_session_check()
{
    $ci = get_instance();
    if (! $ci->session->userdata('user_id')) 
    {
        redirect('users/login');
    }
}

function admin_session_check()
{
    $ci = get_instance();
    if (! $ci->session->userdata('admin_id')) 
    {
        redirect('main');
    }
}

function get_alert_html($message, $type)
{
    if ($type == 'danger') {
        
    $html = "<div class=\"alert alert-$type\"><i class='fa fa-close fa-lg'></i> ";
    $html .= $message;
    $html .= '</div>';
    return $html;
    }
    else {
        
    $html = "<div class=\"alert alert-$type\"><i class='fa fa-check fa-lg'></i> ";
    $html .= $message;
    $html .= '</div>';
    return $html;
    }
}   

function is_admin()
{
    $ci = get_instance();
    if ($ci->session->userdata('admin_id')) 
        return true;
    else
        return false;
}

function is_user()
{
    $ci = get_instance();
    if ($ci->session->userdata('user_id')) 
        return true;
    else
        return false;
}

// pagination function
function pagination($base_url, $total_rows, $per_page = RECORDS_PER_PAGE)
{
    $ci = get_instance();

    // pagination code
    $config['base_url'] = site_url($base_url);
    $config['per_page'] = $per_page;
    $config['total_rows'] = $total_rows;
    $config['use_page_numbers'] = true;
    $config['full_tag_open'] = "<ul class='pagination'>";
    $config['full_tag_close'] = '</ul>';
    $config['next_link'] = 'Next';
    $config['prev_link'] = 'Prev';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['cur_tag_open'] = "<li class='active'><a>";
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['attributes']['rel'] = FALSE;

    $ci->load->library('pagination', $config);
    return $ci->pagination->create_links();
}

?>