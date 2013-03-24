<?php
   include '../mercadolivre-php-api/src/meli.php';
   $meli = new Meli(array(
      'appId'  	=> '6727658572087911',
   	'secret' 	=> 'CFbWA9QH2dL1WvLNtrU56XQJOybc2ouf',
   ));
   //$userId = $meli -> initConnect();
	$search = $meli->get('/sites/MLB/search',array('q' => $_GET['q'], "limit" => 200));
   $total = $search['json']['paging']['total'];
   $pages = intval($total/200, 10);
   //$pages = 1;
   $lista = $search['json']['results'];

   for ($i = 0; $i < $pages ; $i++ )
   {
     $offset = 200*($i+1) + 1;
	  $search = $meli->get('/sites/MLB/search',array('q' => $_GET['q'], "limit" => 200, "offset" => $offset));
     $lista_temp = $search['json']['results'];
     array_merge($lista, $lista_temp);
     set_time_limit(60);
   }
   print_r($lista);
   echo "<div style='width:800px; height:400px;overflow:auto;>";
   echo "VendedorID;PowerSellerStatus;Preco;Quantidade;Vendidos;Tipo;Anuncio;Estado";
   foreach ($lista as $key=>$value)
   {
      echo " ";
      echo $value['seller']['id'].";";
      echo $value['seller']['power_seller_status'].";";
      echo $value['price'].";";
      echo $value['available_quantity'].";";
      echo $value['sold_quantity'].";";
      echo $value['buying_mode'].";";
      echo $value['listing_type_id'].";";
      echo $value['condition']."\n";
      set_time_limit(60);
   }
   echo "</div>";

   $listing_type_id = array();
   foreach ($lista as $key=>$value)
   {
      $type = $value['listing_type_id'];
      if(isset($listing_type_id[$type])) $listing_type_id[$type]++;
      else $listing_type_id[$type] = 1;
   }
   var_dump($listing_type_id);
?>