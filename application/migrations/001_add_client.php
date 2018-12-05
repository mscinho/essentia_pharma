<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_client extends CI_Migration {

        public function up() {

            /*if ($this->dbforge->create_database('essentia_pharma')) {
                try {
                    $current_database = "essentia_pharma";
                    $this->db->database = $current_database;
                    $this->db->close();
                    $config['database'] = $current_database;
                    $this->load->database($config);*/

               

                    $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'nome' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'email' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'telefone' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'imagem' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'ativo' => array(
                                'type' => 'INT',
                                'default' => 1,
                        ),
                        
                    ));

                    $this->dbforge->add_field("`registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
                    $this->dbforge->add_key('id', TRUE);
                    $this->dbforge->create_table('clientes');

                    //populate
                    $data = array(
                            array('nome' => "Márcio Soares", 'email'=> "marcio.ti260@gmail.com", 'telefone'=>"(48) 99610-9057", 'imagem'=>"teste1.png"),
                            array('nome' => "Pedro", 'email'=> "pedro@teste.com", 'telefone'=>"(48) 95555-9956", 'imagem'=>"teste2.png"),
                            array('nome' => "João", 'email'=> "joao@teste.com", 'telefone'=>"(48) 98852-8524", 'imagem'=>"teste3.png"),
                            array('nome' => "Maria", 'email'=> "maria@teste.com", 'telefone'=>"(48) 85472-1111", 'imagem'=>"teste4.png"),
                            array('nome' => "Joana", 'email'=> "joana@teste.com.br", 'telefone'=>"(48) 99999-4444", 'imagem'=>"teste5.png"),
                            array('nome' => "Gabriel", 'email'=> "gabriel@teste.com.br", 'telefone'=>"(48) 95847-2210", 'imagem'=>"teste6.png"),
                            array('nome' => "Ronaldo", 'email'=> "ronaldo@teste.com", 'telefone'=>"(48) 84256-5825", 'imagem'=>"teste7.png")
                    );
                    $this->db->insert_batch('clientes', $data);

                /*} catch(Exception $e) {
                    echo $e->getMessage(); die;
                }
            }*/
        }

        public function down() {
            $this->dbforge->drop_table('clientes');
        }
}