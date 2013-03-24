<?php
   include '../mercadolivre-php-api/src/meli.php';
   $meli = new Meli(array(
      'appId'  	=> '6727658572087911',
   	'secret' 	=> 'CFbWA9QH2dL1WvLNtrU56XQJOybc2ouf',
   ));
   $userId = $meli -> initConnect();
   $itemID = $_POST['itemID'];
   unset($_POST['itemID']);
   $item = $meli->putWithAccessToken("/items/{$itemID}", $_POST);  // ir para inicio
   print_r($item);
?>