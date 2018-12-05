//init
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});

//Mascara para telefone ---------------------
var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
spOptions = {
    onKeyPress: function(val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
    }
};
$('#telefone').mask(SPMaskBehavior, spOptions);
//--------------------------------------------

$('.add').click(function(){
    $(".erro").html("");
    $('#codigo').html('');
    $('#img').html('');
    $('input[name="nome"]').val('');
    $('input[name="email"]').val('');
    $('input[name="telefone"]').val('');
    $('#modal_add').modal( 'show' );
});

$('.edit').click(function(){
    $(".erro").html("");
    $('#codigo').html('<input type="hidden" name="id" value="'+$(this).attr('cod')+'">');
    $('#img').html('<input type="hidden" name="img" value="'+$(this).attr('timagem')+'">');
    $('input[name="nome"]').val($(this).attr('tnome'));
    $('input[name="email"]').val($(this).attr('temail'));
    $('input[name="telefone"]').val($(this).attr('ttelefone'));
    $('#modal_add').modal( 'show' );
});

$('.delete').click(function(){
    $(".erro").html("");
    $("#info_nome").html("");
    $('input[name="id"]').val($(this).attr('cod'));
    $('#info_nome').html($(this).attr('tnome'));
    $('input[name="img_txt"]').val($(this).attr('timagem'));
    $('#modal_delete').modal( 'show' );
});
