<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {
	/**
	 * Clientes - controller.
	 */
	public function __Construct() {
		parent::__construct();
        $this->load->model('Cliente_Model');
	}

	public function index() {

		if(!$this->Cliente_Model->table_exists('clientes')) {
			$this->load->view('create_base');
		} else {

			if ($this->uri->segment(3)!='f') {
	            $this->session->unset_userdata('f_busca');
	        }

			//Filtro
        	if( ($this->input->post('filtro_busca'))||($this->uri->segment(3)==('f')) ) {
	            if($this->uri->segment(3)!='f') {
                	$filtro=array('f_busca' => $this->input->post('filtro_busca'));
                    $this->session->set_userdata($filtro);
                }
	            $url='cliente/index/f/';
	            $offset=$this->uri->segment(4);
	        } else { //Sem Filtro
	            $url='cliente/index/';
	            $offset=$this->uri->segment(3);
	        }

	        //$url='cliente/index/';
	        //$offset=$this->uri->segment(3);

			//paginação
	        $limit=5;
	        $this->load->library('pagination');

	        $this->data['cont']=$this->Cliente_Model->get('clientes','num_rows');
            $config=$this->funcoes->paginacao(base_url($url),$this->data['cont'],$limit);
            $this->pagination->initialize($config);
            
	        $this->data['result'] = $this->Cliente_Model->get('clientes','result','registro','desc',$limit,$offset);
       		$this->load->view('cliente',$this->data);
		}
	}

	public function add() {

		$id=$this->input->post('id');

		//Validações de campos:
        $dados=$this->valida_dados($this->input->post());

        //Confg Imagem
        $config['upload_path'] = 'assets/upload/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);

        if($id=='') { //Salvar
	        if ($this->upload->do_upload('imagem')) {
	            $dados['imagem'] = $this->upload->data('file_name');
	        } else {
	            echo json_encode(array('status'=>false,'error'=>'Campo FOTO Obrigatório! <br>'.$this->upload->display_errors()));
	            exit;
	        }

	        if ($this->Cliente_Model->add('clientes',$dados)) {
	            $this->session->set_flashdata('success','Cadastrado com sucesso!');
	            echo json_encode(array('status'=>true));
	        } else {
	            echo json_encode(array('status'=>false,'error'=>'Ocorreu um erro ao Salvar. Tente mais tarde!'));
	        }
	    } else { //Editar

	    	if ($this->upload->do_upload('imagem')) {
                $dados['imagem'] = $this->upload->data('file_name');
                unlink('assets/upload/'.$dados['img']);
            }

            unset($dados['img']);//retira o tmp da imagem;

            if ($this->Cliente_Model->edit('clientes',$dados,'id',$id)) {
                $this->session->set_flashdata('success','Alterado com sucesso!');
                echo json_encode(array('status'=>true));
            } else {
                echo json_encode(array('status'=>false,'error'=>'Ocorreu um erro ao alterar. Tente mais tarde!'));
            }   
	    }
	}

	public function delete() {
		$id=$this->input->post('id');
		$img=$this->input->post('img_txt');
		if( $this->Cliente_Model->delete('clientes','id',$id) ) {
			unlink('assets/upload/'.$img);
    		$this->session->set_flashdata('success','Registro excluido!');
            echo json_encode(array('status'=>true));
    	} else {
    		echo json_encode(array('status'=>false,'error'=>'Ocorreu um erro ao Excluir. Tente mais tarde!'));
    	}
	}

	private function valida_dados($post) {

        $erro ='';

        if($post['nome']=='') { 
        	$erro = $erro.'- O campo NOME é obrigatório!<br>'; 
        }
        if($post['email']=='') { 
        	$erro = $erro.'- O campo EMAIL é obrigatório!<br>'; 
        }
        if($post['telefone']=='') { 
        	$erro = $erro.'- O campo TELEFONE é obrigatório!<br>'; 
        }

        if($erro!='') {
            echo json_encode(array('status'=>false,'error'=>$erro));
            exit;
        } 

        if(!$this->funcoes->validaEmail($post['email'])) { 
        	echo json_encode(array('status'=>false,'error'=>'E-mail Inválido!')); 
        	exit; 
        }

        return $post;
    }
}
