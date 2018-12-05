<!DOCTYPE html>
<html>

<head>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
    
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//use.fontawesome.com/9e15f25f00.js"></script>
    <script src="<?php echo base_url('assets/js/upload.js'); ?>"></script>

    <!-- LADDA -->
    <link href="<?php echo base_url('assets/plugins/ladda/ladda-themeless.min.css'); ?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/plugins/ladda/spin.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/ladda/ladda.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/ladda/ladda.jquery.min.js'); ?>"></script>

    <!-- Mascara -->
    <script src="<?php echo base_url('assets/js/jquery.mask.js'); ?>"></script>

    <!-- Toastr -->
    <link href="<?php echo base_url('assets/plugins/toastr/toastr.min.css'); ?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/plugins/toastr/toastr.min.js'); ?>"></script>

    <title>Clientes | Essentia Pharma</title>
</head>

<body>

    <?php $this->alert->mensagem($this->session->flashdata('success'),$this->session->flashdata('error')); ?>
    
    <div class="container">
        <div class="row">
            <div class="panel panel-default widget">

                <div class="panel-heading">
                    <i class="fa fa-user"></i>
                    <h3 class="panel-title"><a href="<?php echo base_url(); ?>">Contatos (<?php echo $cont; ?>)</a></h3>
                    <a class="add btn btn-primary btn_top_add">Novo Contato</a>
                   
                    <div id="busca">
                        <form action="<?php echo base_url('cliente') ?>" method="POST">
                            <div class="form-group">
                                <font color="#000"><input name="filtro_busca" type="text" class="form-control" placeholder="Procurar...">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel-body">
                    <ul class="list-group">
                        <?php
                            foreach ($result as $rs) {
                                echo '
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-xs-2 col-md-1">
                                                <img src="'.base_url('assets/upload/'.$rs->imagem).'" class="img-circle img-responsive"/>
                                            </div>
                                            <div class="col-xs-10 col-md-11">
                                                <div>
                                                    <b>'.$rs->nome.'</b>
                                                    <div class="comment-text">'.$rs->telefone.'  |  '.$rs->email.'</div>
                                                </div>
                                                <div class="mic-info">Cadastrado em: '.date("d/m/Y", strtotime($rs->registro)).'</div>
                                                <div class="action">
                                                    <a class="edit btn btn-primary btn-xs" 
                                                        cod="'.$rs->id.'"
                                                        tnome="'.$rs->nome.'"
                                                        temail="'.$rs->email.'"
                                                        ttelefone="'.$rs->telefone.'"
                                                        timagem="'.$rs->imagem.'"
                                                        title="Editar"><i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a class="delete btn btn-danger btn-xs" 
                                                        cod="'.$rs->id.'"
                                                        tnome="'.$rs->nome.'"
                                                        timagem="'.$rs->imagem.'"
                                                        title="Excluir"><i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                ';
                            }
                        ?>
                    </ul>
                </div>

            </div>
            <div class="text-center">
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
    </div>


    <!-- Modais -->
    <!-- Add and Edit -->
    <div id="modal_add" class="modal fade bootstrap-modal">
        <div class="modal-dialog">
            <form id="frmCliente">
                <div class="modal-content"> 
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> Cadastro e Alteração de Clientes
                    </div>
                    <div class="modal-body">
                        
                    <div class="row">
                        <div id="codigo"></div>

                        <div class="form-group col-md-12">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control" maxlength="100">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Foto</label>
                            <a data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Na edição: Caso não queira trocar a foto, apenas deixe em branco."><i class="fa fa-question-circle"></i></a>
                            <span id="img"></span>
                            <div class="input-group image-preview">
                                <input type="text" class="form-control image-preview-filename" disabled="disabled"> 
                                <span class="input-group-btn">
                                    
                                    <button type="button" class="btn btn-info image-preview-clear" style="display: none;">
                                        <i class="fa fa-times" aria-hidden="true"></i> Limpar
                                    </button>
                                    
                                    <div class="btn btn-info image-preview-input">
                                        <i class="fa fa-folder-open" aria-hidden="true"></i>
                                        <span class="image-preview-input-title">Procurar</span>
                                        <input type="file" accept="image/png, image/jpeg, image/jpg, image/gif" name="imagem" id="imagem" > 
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                        
                    <div class="row">
                        <div class="form-group col-md-6 ">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" maxlength="100">
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label>Telefone</label>
                            <input type="text" name="telefone" class="form-control" id="telefone" maxlength="14" autocomplete="off">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12"><center><span class="erro"></font></center></div>
                    </div>  
                        
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                        <button class="ladda-button btn btn-primary" data-style="zoom-in" id="btnSalvar">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete -->
    <div id="modal_delete" class="modal fade bootstrap-modal">
        <div class="modal-dialog">
            <form id="frmDCliente">
                <div class="modal-content"> 
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <div><font size="2"><b>Excluir Cliente</b></font></div>
                    </div>
                    <div class="modal-body">
                        <p>Deseja realmente excluir o cliente: <b><span id="info_nome"></span></b> ?</p>
                        <input type="hidden" name="id">
                        <input type="hidden" name="img_txt">
                        <div class="col-xs-12"><center><span class="erro"></center></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Não</button>
                        <button class="ladda-button btn btn-primary" data-style="zoom-in" id="btnExcluir">Sim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Fim Modal -->

    <!-- scripts -->
    <script src="<?php echo base_url('assets/js/script.js'); ?>"></script>

    <!-- Ajax -->
    <script>
        $('#btnSalvar').ladda().click(function(e) {
            e.preventDefault();

            var frm = document.getElementById('frmCliente');
            var formData = new FormData(frm);
            
            $('#btnSalvar').ladda('start');
            $('.erro').html('');

            $.ajax({
                type: "POST",
                url: "<?php echo base_url('cliente/add'); ?>",
                dataType: "JSON",
                data: formData,
                enctype: 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                timeout: 60000,
                success: function(data) {
                    if(data.status) {
                        location.reload(true);
                    } else {
                        $('#btnSalvar').ladda('stop');
                        $('.erro').html(data.error);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#btnSalvar').ladda('stop');
                    $('.erro').html('Erro: '+xhr.status+' - '+thrownError);
                }    
            });
        });

        $('#btnExcluir').ladda().click(function(){
            $(this).ladda( 'start' );
            $(".erro").html("");

            $.ajax({
                url: "<?php echo base_url('cliente/delete'); ?>",
                type: "POST",
                dataType: "JSON",
                data: $('#frmDCliente').serialize(),
                timeout: 60000,
                success: function(data) {
                    if(data.status) {
                        location.reload();
                    } else {
                        $(".erro").html(data.error); 
                        $('#btnExcluir').ladda('stop');   
                        return;
                    }  
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#btnExcluir').ladda('stop'); 
                    $('.erro').html('Erro: '+xhr.status+' - '+thrownError);
                }    
            });
        });

    </script>
    

</body>


</html>