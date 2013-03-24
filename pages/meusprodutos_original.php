<style type="text/css">
   .rotate
   {
      -ms-transform:rotate(-45deg); /* IE 9 */
      -moz-transform:rotate(-45deg); /* Firefox */
      -webkit-transform:rotate(30deg); /* Safari and Chrome */
      -o-transform:rotate(-45deg); /* Opera */
      transform:rotate(-45deg);
   }

   .tag-triangle {
      border-color:transparent #4AA02C transparent transparent;
      border-style:solid;
      border-width:20px;
      width:0;
      height:0;
      float:left;
   }

   .tag-rectangle {
      background-color:#4AA02C;
      width:100px;
      height:40px;
      display:inline;
      float:right;
   }

   .hole {
      width: 8px;
      height: 8px;
      -webkit-border-radius: 10px;
      -moz-border-radius: 10px;
      border-radius: 10px;
      background-color:#E7E9EB;
      position: absolute;
      left: 30px;
      top: 16px;
   }

   .tag-rectangle h1 {
      text-align: center;
      font-size: 16px;
      color: #FFF8C6;/
   }
   input[type=text]
   {
      width: 400px;
   }
   select
   {
      width:415px;
      height: 30px;
   }
</style>
<div class="mercadobox">
   <form id="cria_produtos_lote"  class="ch-form myForm" method="POST">
      <legend>Detalhes dos produtos</legend>
      <div class="ch-form-row ch-form-required ch-form-disabled">
				<label for="required_disabled">
					Título do produto:<em>*</em>
				</label>
				<input type="text" id="required_disabled" required="required" disabled="disabled" value="Será solicitado mais tarde">
			</div>
      <p class="ch-form-row ch-form-required">
          <label for="input_text">Subtítulo:<em>*</em></label>
          <input type="text" required placeholder="Some text here..." size="20" name="input_text" id="input_text">
      </p>
      <p class="ch-form-row ch-form-required">
          <label for="select">Categoria:<em>*</em></label>
          <select id="select" name="select">
              <option value="-1">Selecione a categoria</option>
              <?php
                  include '../mercadolivre-php-api/src/meli.php';
                  $meli = new Meli(array(
                     'appId'  	=> '6727658572087911',
                  	'secret' 	=> 'CFbWA9QH2dL1WvLNtrU56XQJOybc2ouf',
                  ));
                  //https://api.mercadolibre.com/sites/MLB/categories
                  $categories = $meli->get('/sites/MLB/categories');  // ir para inicio
                  //print_r($categories);
                  foreach ($categories['json'] as $key=>$value):
              ?>
                  <optgroup value="<?=$value['id']?>" label="<?=$value['name']?>"></optgroup>
              <?php
                  //https://api.mercadolibre.com/categories/MLB5672
                     $subcategories = $meli->get('/categories/' . $value['id']);  // ir para inicio
                     foreach ($subcategories['json']['children_categories'] as $subkey=>$subvalue):
                        $subsubcategories = $meli->get('/categories/' . $subvalue['id']);  // ir para inicio
                        foreach ($subsubcategories['json']['children_categories'] as $subsubkey=>$subsubvalue):
              ?>
                    <option value="<?=$subsubvalue['id']?>" <php if($item['category_id'] == "<?=$subsubvalue['id']?>") echo "selected" ?> >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$subvalue['name']." - ".$subsubvalue['name']?></option>
              <?php
                     set_time_limit(60);
                        endforeach;
                     endforeach;
                  endforeach;
              ?>
          </select>
      </p>
      <p class="ch-form-row ch-form-required">
          <label for="input_text">Preço:<em>*</em></label>
          <input type="text" required placeholder="29,90" size="20" name="input_text" id="input_text">
      </p>
      <div style="margin:auto; width:100%; border:1px solide red;">
         <input class="ch-btn ch-btn-big" type="submit" value="Criar novos produtos em lote">
      </div>
   </form>
</div>
<?php return; ?>
<div class="mercadobox">
<?php
function getSSLPage($url)
{
    $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_SSLVERSION,3);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

   include '../mercadolivre-php-api/src/meli.php';
   $meli = new Meli(array(
      'appId'  	=> '6727658572087911',
   	'secret' 	=> 'CFbWA9QH2dL1WvLNtrU56XQJOybc2ouf',
   ));
   $userId = $meli -> initConnect();

   $url = "https://api.mercadolibre.com/sites/MLB/search?seller_id={$userId}";
   echo $url;
   $json = getSSLPage($url);
   $json_array = json_decode($json, true);
   $items_ids = "";
   foreach ($json_array['results'] as $key => $value)
   {
      $items_ids .= $value['id'].",";
   }
   $json_items = getSSLPage("https://api.mercadolibre.com/items/?ids={$items_ids}&attributes=id,price,permalink,pictures&limit=200");
   $json_items_array = json_decode($json_items, true);
   foreach ($json_items_array as $key => $value):
      list($width, $height) = explode('x', $value['pictures'][0]['size']);
      if($width > $height)
      {
         $height = $height * 230 / $width;
         $width  = 230;
      }
      else
      {
         $width = $width * 230 / $height;
         $height  = 230;
      }
?>
   <div style="float:left; width:240px; height: 240px; margin:4px; border-radius:5px; border:1px solid #ccc;">
      <div class="rotate" style="width:140px; position: relative; left: 100px; top: 30px;">
         <div class="tag-triangle"></div>
         <div class="hole"></div>
         <div class="tag-rectangle">
            <h1>R$ <?=($value['price']);?></h1>
         </div>
      </div>
      <img src="<?=($value['pictures'][0]['url']);?>" width="<?=$width?>px" height="<?=$height?>px" style="margin-top:-35px;">
   </div>
<?php
   endforeach;
?>
   <div style="clear:both"></div>
</div>
<div style="clear:both"></div>