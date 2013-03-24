<?php
   DEFINE('ADDRESS', "http://localhost/mercadotools/");
   $itemID = "MLB472963863";
   include '../mercadolivre-php-api/src/meli.php';
   $meli = new Meli(array(
      'appId'  	=> '6727658572087911',
   	'secret' 	=> 'CFbWA9QH2dL1WvLNtrU56XQJOybc2ouf',
   ));
   //https://api.mercadolibre.com/sites/MLB/categories
   $userId = $meli -> initConnect();

   //$item_full = $meli->get('/items/' . $itemID);  // ir para inicio
   //$item = $item_full['json'];
?>
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
      color: #FFF8C6;
   }

   .product_page
   {
      overflow: scroll-x;
      height: 220px;
      border:1px solid red;
   }

   .product_page_item
   {
     float:left;
     width:210px;
     height: 210px;
     margin:4px;
     border-radius:5px;
     border:1px solid #ccc;
   }

   .product_page_item:hover
   {
      background-color: #ffffcc;
      border:3px solid #ccc;
      margin-top:2px;
      margin-left: 2px;
      cursor:pointer;
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
</style>
<div class="product_page">
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



      $url = "https://api.mercadolibre.com/sites/MLB/search?seller_id={$userId}";
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
         if(isset($value['pictures'][0]))
         {
            list($width, $height) = explode('x', $value['pictures'][0]['size']);
            if($width > $height)
            {
               $height = $height * 200 / $width;
               $width  = 200;
            }
            else
            {
               $width = $width * 200 / $height;
               $height  = 200;
            }
            $img = $value['pictures'][0]['url'];
         }
         else
         {

            $img = ADDRESS."artsinfoto.gif";
            $width  = 200;
            $height = 200;;
         }
   ?>
      <div class="product_page_item" data-itemid="<?=$value['id']?>">
         <div class="rotate" style="width:140px; position: relative; left: 60px; top: 30px;">
            <div class="tag-triangle"></div>
            <div class="hole"></div>
            <div class="tag-rectangle">
               <h1>R$ <?=($value['price']);?></h1>
            </div>
         </div>
         <img src="<?=$img;?>" width="<?=$width?>px" height="<?=$height?>px" style="margin-top:-35px;">
      </div>
   <?php
      endforeach;
   ?>
</div>
<hr>
<!-- Inicia a Edição -->
<div class="mercadobox_edita">
</div>
<script>
   $(".product_page_item").click(function()
   {
      console.log($(this).attr("data-itemid"));
      $("#processing_lock").css('display', 'table');
      $.ajax({
         url: "<?=ADDRESS?>rest/get_item.php?itemID="+$(this).attr("data-itemid"),
         type:  'GET',
         dataType: 'html',
         async: true, // to set local variable
         success: function(data, textStatus, jqXHR)
         {
            console.log(data);
            $(".mercadobox_edita").html(data);
            $("#processing_lock").css("display", "none");
         },
         error: function(data, textStatus, jqXHR)
         {
            $("#processing_lock").css("display", "none");
         }
      });

   });
   //----------------------------------------------------
   var save_item = function()
   {
      $("#processing_lock").css('display', 'table');
      $.ajax({
         url: "<?=ADDRESS?>rest/save_item.php",
         type:  'POST',
         dataType: 'html',
         async: true, // to set local variable
         data:
         {
            itemID: $("#itemID").val(),
            title: $("#iTitulo").val(),
            //subtitle: $("#iSubtitulo").val(),
            //category_id: 'MLB112873',
            price: $("#iPreco").val(),
            //currency_id: "BRL",
            available_quantity: $("#iQuantidade").val(),
            //listing_type_id: "bronze",
            //condition: "new"
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

      console.log(1);
      return false;
   };
</script>