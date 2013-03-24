<?php
   DEFINE('ADDRESS', "http://localhost/mercadotools/")
?>
<!DOCTYPE html>
<!--[if IE 7]>    <html class="no-js lt-ie10 lt-ie9 lt-ie8 ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie10 lt-ie9 ie8" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js lt-ie10 ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<html>
   <head>
      <title>Mercado Tools - Mais Facilidade para comprar e vender de tudo</title>
      <meta charset="UTF-8" />
      <meta name="generator" content="PSPad editor, www.pspad.com" />
      <meta name="description" content="" />
      <meta name="author" content="Luciano Camilo" />

      <meta name="viewport" content="width=device-width; initial-scale=1.0" />

      <script src="http://localhost/zeetha/sites/app/js/jquery-1.8.1.js" type="text/javascript"></script>

      <script src="http://localhost/zeetha/sites/app/js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
      <link rel="stylesheet" href="http://localhost/zeetha/sites/app/js/css/ui-lightness/jquery-ui-1.8.23.custom.css">

      <script src="http://localhost/zeetha/sites/app/js/jQueryRotate.2.2.js" type="text/javascript"></script>

      <!-- Chico UI -->
      <link rel="stylesheet" href="chico-0.13.2/css/chico-min-0.13.2.css" type="text/css">
      <script src="chico-0.13.2/js/chico-min-0.13.2.js" type="text/javascript"></script>
      

      <style>
         body
         {
            margin:0px;
            padding: 0px;
         }
         .header
         {
            height: 50px;
            background-color: #fff372;
            background-color: #ffffdd;
            border-bottom: 5px solid #bbbb88;
            border-top: 1px solid #bbbb88;
            color: #000;
            width: 100%;
         }
         .header span
         {
            line-height: 50px;
            font-size: 28px;
            font-weight: bolder;
            color: #33339;
            margin-left: 20px;

         }
         .main_box
         {
            width: 100%;
            border:1px solid #fff;
            clear: both;
            background-color: #ffffff;
         }
         .main_menu
         {
            float:left;
            width: 300px;
            min-height: 600px;
            border: 2px solid transparent;
            margin: 10px;
         }
         .menu_item
         {
            line-height: 20px;
            padding:  10px;
            background-color: #999;
            border: 2px solid #99;
            font-size: 22px;
            color: #fff;
            font-weight: bolder;
            cursor: pointer;
            margin-bottom: 5px;
         }
         .menu_item:hover
         {
            background-color: #bbbb88;
            color: #ffd;

         }
         .main_content
         {
            min-height: 600px;
            border: 2px solid silver;

            margin: 10px;
            margin-left: 320px;;
            padding:20px;

         }
      </style>
   </head>
   <!-- Lock screen -->
   <style>
   #processing_lock
   {
     display: none;
     position:fixed;
     border:1px solid #ccc;
     background:#000;
     width:100%;
     height: 100%;
     left:0px;
     top: 0px;
     color:#fff;
     z-index: 1000;
      opacity:0.75;
      filter:alpha(opacity=75); /* For IE8 and earlier */
   }
   #processing_lock_msg
   {
      display: table-cell;
      vertical-align: middle;
      font-size: 36px;
      font-weight: bold;
      height: 200px;
      border:1px solid red;
      text-align: center;
   }
   </style>
   <div id="processing_lock">
      <div id="processing_lock_msg">
         <img src="http://localhost/zeetha/sites/app/images/301.gif" width="50px" align="absmiddle"">  Processando, aguarde...
      </div>
   </div>
   <!-- end Lock Screen -->
   <body>
      <div class="header">
         <span>Mercado Professional Tools</span>
      </div>
      <div class="main_box">


         <div class="main_menu">
            <div class="menu_item"><span data-content="<?=ADDRESS?>pages/inicio.php" data-location="<?=ADDRESS?>#Inicio">Inicio</span></div>
            <div class="menu_item"><span data-content="<?=ADDRESS?>pages/meusprodutos.php" data-location="<?=ADDRESS?>#MeusProdutos">Meus Produtos</span></div>
            <div class="menu_item"><span data-content="<?=ADDRESS?>pages/lote.php" data-location="<?=ADDRESS?>#Lote">Envio em Lote</span></div>
            <div class="menu_item"><span data-content="<?=ADDRESS?>pages/insights.php" data-location="<?=ADDRESS?>#Insights">Insights</span></div>
            <div class="menu_item"><span data-content="<?=ADDRESS?>pages/perguntas.php" data-location="<?=ADDRESS?>#Perguntas">Respostas Pre-definidas</span></div>
         </div>
         <div class="main_content"> Conteudo 2</div>
         <div style="clear:both"></div>
      </div>
      <script>
         $(window).ready(function()
         {
            $(".menu_item").click(function()
            {
               console.log($(this).find("span").attr("data-location"));
               $("#processing_lock").css('display', 'table');
               $.ajax({
                  url: $(this).find("span").attr("data-content"),
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
               window.location = $(this).find("span").attr("data-location");
            });
         });
      </script>
   </body>
</html>