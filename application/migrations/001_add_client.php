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
                            array('nome' => "Márcio", 'email'=> "marcio.ti260@gmail.com", 'telefone'=>"(48) 99610-9057", 'imagem'=>"80.png"),
                            array('nome' => "Márcio 2", 'email'=> "marcio.ti260@gmail.com2", 'telefone'=>"(48) 99610-9057", 'imagem'=>"80.png")
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