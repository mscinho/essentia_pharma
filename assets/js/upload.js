/* 
 * Upload.js
 */

$(document).on('click', '#close-preview', function(){ 
    $('.image-preview').popover('hide');
    $('.image-preview').hover(
        function () {
           $('.image-preview').popover('show');
        }, 
         function () {
           $('.image-preview').popover('hide');
        }
    );    
});

$(function() {
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;'
    });
    closebtn.attr("class","close pull-right");
    
    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Visualizar</strong>"+$(closebtn)[0].outerHTML,
        content: "Nenhuma imagem",
        placement:'bottom'
    });
    
    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Procurar"); 
    }); 
    
    $(".image-preview-input input:file").change(function (){     
        var img = $('<img/>', {
            id: 'dynamico',
            width:250,
            height:200
        });      
        var file = this.files[0];
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $(".image-preview-input-title").text("Alterar");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);            
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
        };        
        reader.readAsDataURL(file);
    });  
});