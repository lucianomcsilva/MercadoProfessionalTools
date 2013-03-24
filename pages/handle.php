<?php
   //error_reporting(0);
   include '../mercadolivre-php-api/src/meli.php';
   $meli = new Meli(array(
      'appId'  	=> '6727658572087911',
   	'secret' 	=> 'CFbWA9QH2dL1WvLNtrU56XQJOybc2ouf',
   ));
   $userId = $meli -> initConnect();

   if (isset($userId))
   {
      //$user = $meli->getWithAccessToken('/users/me');  // ir para inicio
      $page = $_GET['zs_menu'];
      switch ($page)
      {
         case 1:  include "inicio.php"; break;
         case 2:  include "meusprodutos.php"; break;
         case 3:  include "lote.php"; break;
         case 4:  include "perguntas.php"; break;
         case 5:  include "insights.php"; break;
         default: include "default.php";
      }

   }
   else
   {
?>
<h1>Antes de mais nada, conecte-se no nosso site</h1>
<p> Login using OAuth 2.0 handled by the PHP SDK: </p>
        <a href="<?php echo $meli->getLoginUrl(); ?>">Login with MercadoLibre</a>
<?php
   }
?>