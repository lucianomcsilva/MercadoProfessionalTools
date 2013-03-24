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
<h1>Insights</h1>
<h3>Veja o que outros vendedores estão anunciando.</h3>
<p>Faça uma pesquisa para saber o que você vai encontrar</p>
   <p class="ch-form-row ch-form-required">
       <label for="input_text">Palavras-chave:</label>
       <input type="text" placeholder="faça a busca para saber mais" size="20" id="q" name="q"  value="">
   </p>
   <div style="margin:auto; width:900px; border:1px solide red;">
      <input class="ch-btn ch-btn-big" type="submit" value="Buscar" onclick="buscar()">
   </div>
<script>
   var buscar = function()
   {
      $.ajax({
         url: "<?=ADDRESS?>rest/buscar2.php?q="+$("#q").val(),
         type:  'POST',
         dataType: 'html',
         async: true, // to set local variable
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
</script>