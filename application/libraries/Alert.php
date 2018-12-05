<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Mensageria
 *
 * @author		Márcio Soares
 * @copyright	Copyright (c) 2018, Márcio Soares.
 * @since		Version 1.0
 */

class Alert {

	public function mensagem($sucesso=null,$erro=null) {
        if ($sucesso) {
        	echo $this->sucesso($sucesso);
        } elseif ($erro) {
        	echo $this->erro($erro);
        } else {
        	return false;
        }                
	}

	private function sucesso($sucesso) {
		
		$script = "
			<input type='hidden' id='msg' name='msg' value='".$sucesso."' />
			<script>
			    $(document).ready(function() {
			       var msg = $('#msg').val();
			       setTimeout(function() {
			            toastr.options = {
			                closeButton: true,
			                progressBar: true,
			                showMethod: 'slideDown',
			                timeOut: 4000
			            };
			            toastr.success(msg, 'Operação Realizada!');

			        }, 300);

			    });
			</script>
		";

		return $script;
	}

	private function erro($erro) {
		
		$script = "
			<input type='hidden' id='msg' name='msg' value='".$erro."' />
			<script>
			    $(document).ready(function() {
			       var msg = $('#msg').val();
			       setTimeout(function() {
			            toastr.options = {
			                closeButton: true,
			                progressBar: true,
			                showMethod: 'slideDown',
			                timeOut: 4000
			            };
			            toastr.error(msg, 'Erro!');

			        }, 300);

			    });
			</script>
		";

		return $script;
	}
}