<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Mensageria
 *
 * @author		Márcio Soares
 * @copyright	        Copyright (c) 2017, Márcio Soares.
 * @since		Version 1.0
 */

class Funcoes {

	public function caixa_alta ($valor) {
		$LATIN_UC_CHARS = "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝ°°ª";
		$LATIN_LC_CHARS = "àáâãäåæçèéêëìíîïðñòóôõöøùúûüý°ºª";
		$valor = strtr ($valor, $LATIN_LC_CHARS, $LATIN_UC_CHARS);
		$valor = strtoupper($valor);
		return $valor;
	}

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

    

    public function somarData($data, $formato, $dias=0, $meses=0, $ano=0)
    {

        $pos = strpos($data, '-');

        if($pos == true) {
            $data = explode("-", $data);
        } else {
            $data = explode("/", $data);
        }

        $newData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses, $data[0] + $dias, $data[2] + $ano) );
        $dataFormat=strtotime(str_replace('/', '-',$newData));
        
        if(strpos($formato, '-')) {
                $dataFormat=date($formato, strtotime(str_replace('/', '-', $newData)));
        } else {
                $dataFormat=date($formato, strtotime($newData));
        }
        
        return $dataFormat;
    }

    public function formataData($data, $formato) {

        $retornoData="";
        switch ($formato) {
            case 'dd/mm/yyyy':
                $retornoData=date('d/m/Y', strtotime(str_replace('-', '/', $data)));
                break;
            case 'yyyy-mm-dd':
                $retornoData=date('Y-m-d', strtotime(str_replace('/', '-', $data)));
                break;
        }

        return $retornoData;
    }

    //transforma data aaaa-mm-dd em dd/mm/aaaa
    public function dataBr($data) {
        $d=explode('-',$data);
        return $d[2].'/'.$d[1].'/'.$d[0];
    }

    //Para inserir valores no banco de dados quando for NUMERIC, dexando no seguinte formarto: 0000.00
    public function addValor($valor) {
        return str_replace(',','.',str_replace('.', '', $valor));
    }

    //para não dar erro de sintaxe em json_decode
    public function utf8_converter($array) {
        array_walk_recursive($array, function(&$item, $key) {
            if(!mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);
            }
        });
 
        return $array;
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

    //Valida Data de Nascimento
    public function validaData($data){
        if ( strlen($data) < 8){
            return false;
        }else{
            if(strpos($data, "/") !== FALSE){
                $partes = explode("/", $data);
                $dia = $partes[0];
                $mes = $partes[1];
                $ano = isset($partes[2]) ? $partes[2] : 0;
     
                if (strlen($ano) < 4) {
                    return false;
                } else {
                    if (checkdate($mes, $dia, $ano)) {
                         return true;
                    } else {
                         return false;
                    }
                }
            }else{
                return false;
            }
        }
    }

    //Valida CPF
    public function validaCPF($cpf) {
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
         
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }
        return true;
    }

    //Entra com a data de nascimento no formato [dd/mm/yyyy] e retorna a idade
    public function idade($data) {
        //$data = '29/08/2008';
        //$data=date('d/m/Y', strtotime($data));
   
        // Separa em dia, mês e ano
        list($dia, $mes, $ano) = explode('/', $data);
       
        // Descobre que dia é hoje e retorna a unix timestamp
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        // Descobre a unix timestamp da data de nascimento do fulano
        $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
       
        // Depois apenas fazemos o cálculo já citado :)
        $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
        return $idade;
    }


    //CALCULANDO DIAS NORMAIS
    /*Abaixo vamos calcular a diferença entre duas datas. Fazemos uma reversão da maior sobre a menor 
    para não termos um resultado negativo. */
    public function CalculaDias($xDataInicial, $xDataFinal){
        $time1 = $this->dataToTimestamp($xDataInicial);  
        $time2 = $this->dataToTimestamp($xDataFinal); 

        $tMaior = $time1>$time2 ? $time1 : $time2;  
        $tMenor = $time1<$time2 ? $time1 : $time2;  

        $diff = $tMaior-$tMenor;  
        $numDias = $diff/86400; //86400 é o número de segundos que 1 dia possui
        return $numDias;
    }

    //CALCULA DIAS UTEIS
    /*É nesta função que faremos o calculo. Abaixo podemos ver que faremos o cálculo normal de dias ($calculoDias), após este cálculo, faremos a comparação de dia a dia, verificando se este dia é um sábado, domingo ou feriado e em qualquer destas condições iremos incrementar 1*/
    public function DiasUteis($yDataInicial,$yDataFinal){

       $diaFDS = 0; //dias não úteis(Sábado=6 Domingo=0)
       //$calculoDias = $this->CalculaDias($yDataInicial, $yDataFinal); //número de dias entre a data inicial e a final
       $calculoDias=0;
       $diasUteis = 0;
       
       while($yDataInicial!=$yDataFinal){
          $diaSemana = date("w", $this->dataToTimestamp($yDataInicial));
          //if($diaSemana==0 || $diaSemana==6){
          if($diaSemana==0){
             //se DOMINGO, SOMA 01
             $diaFDS++;
          }else{
          //senão vemos se este dia é FERIADO
             for($i=0; $i<=9; $i++){
                if($yDataInicial==$this->Feriados(date("Y"),$i)){
                   $diaFDS++;   
                }
             }
          }
          $calculoDias++;
          $yDataInicial = $this->Soma1dia($yDataInicial); //dia + 1
       }

       if($yDataInicial==$yDataFinal) {
            $diaSemana = date("w", $this->dataToTimestamp($yDataInicial));
            //if($diaSemana==0 || $diaSemana==6){
            if($diaSemana==0){
                //se DOMINGO, SOMA 01
                $diaFDS++;
            }else{
            //senão vemos se este dia é FERIADO
                for($i=0; $i<=9; $i++){
                    if($yDataInicial==$this->Feriados(date("Y"),$i)){
                        $diaFDS++;   
                    }
                }
            }
            $calculoDias++;
            $yDataInicial = $this->Soma1dia($yDataInicial); //dia + 1
        }

        return $calculoDias - $diaFDS;
    }

    //SOMA 01 DIA   
    public function Soma1dia($data) {   
        $ano = substr($data, 6,4);
        $mes = substr($data, 3,2);
        $dia = substr($data, 0,2);

        return date("d/m/Y", mktime(0, 0, 0, $mes, $dia+1, $ano));
    }

    //FORMATA COMO TIMESTAMP
    /*Esta função é bem simples, e foi criada somente para nos ajudar a formatar a data já em formato  TimeStamp facilitando nossa soma de dias para uma data qualquer.*/
    public function dataToTimestamp($data) {
        $ano = substr($data, 6,4);
        $mes = substr($data, 3,2);
        $dia = substr($data, 0,2);
        return mktime(0, 0, 0, $mes, $dia, $ano);  
    } 

    //LISTA DE FERIADOS NO ANO
    /*Abaixo criamos um array para registrar todos os feriados existentes durante o ano.*/
    private function Feriados($ano,$posicao){
        $dia = 86400;
        $datas = array();
        $datas['pascoa'] = easter_date($ano);
        $datas['sexta_santa'] = $datas['pascoa'] - (2 * $dia);
        $datas['carnaval'] = $datas['pascoa'] - (47 * $dia);
        $datas['corpus_cristi'] = $datas['pascoa'] + (60 * $dia);
        $feriados = array (
            '01/01',
            //'02/02', // Navegantes
            //date('d/m',$datas['carnaval']),
            date('d/m',$datas['sexta_santa']),
            date('d/m',$datas['pascoa']),
            '21/04',
            '01/05',
            date('d/m',$datas['corpus_cristi']),
            //'20/09', // Revolução Farroupilha \m/
            '12/10',
            '02/11',
            '15/11',
            '25/12',
        );
           
        return $feriados[$posicao]."/".$ano;
    }      
}