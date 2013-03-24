<?php
   DEFINE('ADDRESS', "http://localhost/mercadotools/");
?>
<style>
h1, h2, h3, h4
{
   font-family: Tahoma;
   font-weight: normal;
}
h3
{
   color: #dc7b1c;
}
p
{
   font-family: Tahoma;
   color: #777;
}
   input[type=text], textarea
   {
      width: 400px;
   }
   select
   {
      width:415px;
      height: 30px;
   }
</style>
<script src="http://localhost/mercadotools/js/jquery.simpleUploader.js"></script>

<h1>Criação de Mútiplas vendas</h1>
<h3>1 - Envie as fotos para os novos anuncios.</h3>
<p>Enviar quantas fotos quiser. Cada foto será enviada para um anuncio diferente.</p>
<div>
   <div id='fotosBox' style="float:right;border:1px dashed #ccc; height: 70px; width:1000px;"></div>
   <div style="margin-right:1020px; padding:10px;">
      <input type="file" id="fileBackground" name="fileBackground[]" accept="image/jpg, image/jpeg, image/gif, image/png" multiple="" style="display:none"/>
      <input id="chicoEnviaFotos" class="ch-btn ch-btn-big" type="submit" value="Enviar Fotos">
   </div>
</div>
<hr>
<h3>2 - Detalhe dos produtos. </h3>
<p class="ch-form-hint" style="margin:0px">* Dados obrigatórios</p>
<p>Note que todos os anuncios terão as mesmas caracteristicas. Você poderá edita-los depois</p>

   <p class="ch-form-row ch-form-required">
      <label for="iTitulo">Título do produto:<em>*</em></label>
      <input type="text" id="iTitulo" required="required" value="" placeholder="Lembre-se de usar palavras chaves">
   </div>
   <p class="ch-form-row ch-form-required">
      <label for="input_text">Quantidade:</label>
      <input type="text" required="required"  placeholder="10" size="20" id="iQuantidade" value="">
   </p>
   <p class="ch-form-row ch-form-required">
      <label for="input_text">Categoria:<em>*</em></label>
      <?php include "categorias2_clean.inc"; ?>
   </p>

   <p class="ch-form-row ch-form-required">
      <label for="input_text">Preço:<em>*</em></label>
      <input type="text" required placeholder="29,90" size="20" name="iPreco" id="iPreco" value="">
   </p>
   <p class="ch-form-row ch-form-required">
      <label for="input_description">Descrição:<em>*</em></label>
      <textarea name="iDescricao" id="iDescricao" required placeholder="Descreva seu produto, como funciona a entrega, meios de pagamento e garantia prestada." style="height:200px"></textarea>
   </p>

   <div style="margin:auto; width:900px; border:1px solide red;">
      <input class="ch-btn ch-btn-big" type="submit" value="Salvar" onclick="create_items()">
   </div>

<script>
//------------------------------
var lis_pictures = new Array();
//------------------------------
$("#chicoEnviaFotos").click(function()
{
   $("#fileBackground").click();
});
//------------------------------
var up = new uploader($("#fileBackground").get(0),
{
   prefix: 'fileBackground',
   multiple: true,
   autoUpload: true,
   url:'<?=ADDRESS?>customer_images/index.php',
   progress:function(ev)
   {
   },
   error:function(ev){ console.log('error'); },
   success:function(data, ev)
   {

      json = eval("("+data+")");
      console.log(data);
      lis_pictures = json;
      for(i=0; i < json.length; i++)
      {
         img_src = json[i].saved_at;
         $('<img style="margin:10px;border:1px solid #ccc; border-radius:3px;" src="'+img_src+'" width=50 height=50>').appendTo('#fotosBox');
      }
      console.log(json);
      //alert(json[0].filename);
   }
});
//-------------------------------------------
var create_items = function()
{
   console.log(lis_pictures);

   $("#processing_lock").css('display', 'table');
   for(i=0; i < lis_pictures.length; i++)
   {
      lis_pictures[i].process = false;
      $.ajax({
         url: "<?=ADDRESS?>rest/create_item.php",
         type:  'POST',
         dataType: 'html',
         async: true, // to set local variable
         data:
         {
            title: $("#iTitulo").val(),
            description: $("#iDescricao").val(),
            category_id: $("#sCategoria").val(),
            price: $("#iPreco").val(),
            currency_id: "BRL",
            available_quantity: $("#iQuantidade").val(),
            listing_type_id: "bronze",
            "buying_mode":"buy_it_now",
            pictures: [{source: lis_pictures[i].saved_at}],
            condition: "new"
         },
         success: function(data, textStatus, jqXHR)
         {
            $(".main_content").html(data);
            $("#processing_lock").css("display", "none");
         },
         error: function(data, textStatus, jqXHR)
         {
            $("#processing_lock").css("display", "none");
         }
      });
   }
}
</script>