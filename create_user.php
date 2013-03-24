<?php
   include 'mercadolivre-php-api/src/meli.php';
   $meli = new Meli(array(
      'appId'  	=> '6727658572087911',
   	'secret' 	=> 'CFbWA9QH2dL1WvLNtrU56XQJOybc2ouf',
   ));

   $params = array("ids" => implode(",", array("MLB472167526", "MLB470611301")));
   $item = @$meli -> get('/items/', $params);
   //https://api.mercadolibre.com/items/?ids=MLB472167526
   //$meli -> postWithAccessToken('/answers', array('question_id' => $_REQUEST['question_id'], 'text' => $_REQUEST['answer_text']));
   //getWithAccessToken
   echo $item;
   echo "<hr>";
   //Criando o usuario teste

   $params = array("site_id" => "MLB");
   $userId = $meli -> initConnect();
   if ($userId)
   {
      $user_id = $meli -> postWithAccessToken('/users/test_user', $params);
      print_r($user_id);
   }
?>