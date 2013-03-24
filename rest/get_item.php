<?php
   include '../mercadolivre-php-api/src/meli.php';
   $meli = new Meli(array(
      'appId'  	=> '6727658572087911',
   	'secret' 	=> 'CFbWA9QH2dL1WvLNtrU56XQJOybc2ouf',
   ));
   $userId = $meli -> initConnect();
   $itemID = $_GET['itemID'];
   $item_full = $meli->get('/items/' . $itemID);  // ir para inicio
   $item = $item_full['json'];
?>

   <h3>Detalhes dos produtos</h3>
   <input type="hidden" id="itemID" value="<?=$item['id']?>">
   <p class="ch-form-hint" style="margin:0px">* Dados obrigatórios</p>
   <p class="ch-form-row ch-form-required">
		<label for="required_disabled">Título do produto:<em>*</em></label>
		<input type="text" id="iTitulo" required="required" value="<?=$item['title']?>">
	</div>
   <p class="ch-form-row ch-form-required">
       <label for="input_text">Quantidade:</label>
       <input type="text" placeholder="10" size="20" id="iQuantidade"  value="<?=$item['available_quantity']?>">
   </p>
   <p class="ch-form-row ch-form-required">
       <label for="input_text">Preço:<em>*</em></label>
       <input type="text" required placeholder="29,90" size="20" name="iPreco" id="iPreco" value="<?=$item['price']?>">
   </p>
   <div style="margin:auto; width:900px; border:1px solide red;">
      <input class="ch-btn ch-btn-big" type="submit" value="Salvar" onclick="save_item()">
   </div>