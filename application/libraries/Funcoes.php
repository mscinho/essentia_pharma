<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Mensageria
 *
 * @author		Márcio Soares
 * @copyright	        Copyright (c) 2017, Márcio Soares.
 * @since		Version 1.0
 */

class Funcoes {

	public function paginacao ($url,$total_rows,$per_page=5) {

        $config['base_url'] = $url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = 5;
        $config['next_link'] = '<i class="fa fa-chevron-right"></i>';
        $config['prev_link'] = '<i class="fa fa-chevron-left"></i> ';
        $config['full_tag_open'] = '<ul class="pagination pagination-large">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><span>';
        $config['cur_tag_close'] = '</span></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
        $config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        return $config;
	}

    //Valida Email
    public function validaEmail($email){
        $er = "/^(([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}){0,1}$/";
        if (preg_match($er, $email)){
            return true;
        } else {
            return false;
        }
    } 
}