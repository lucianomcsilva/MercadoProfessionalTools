<?php
   include '../mercadolivre-php-api/src/meli.php';
   $meli = new Meli(array(
      'appId'  	=> '6727658572087911',
   	'secret' 	=> 'CFbWA9QH2dL1WvLNtrU56XQJOybc2ouf',
   ));
   $userId = $meli -> initConnect();
   $user = $meli->getWithAccessToken('/users/me');  // ir para inicio
   //Se chegou ate aqui, é porque está conectado. Eu testo todas as páginas
?>
<style>
h1, h2, h3, h4
{
   margin:0px;
   font-family: Tahoma;
}
h3
{
   color: #777;
}
</style>
<h1>Olá <?=$user['json']['first_name']?>(<?=$userId?>), bem vindo de volta </h1>
<h3>Abaixo um resumo dos seus dados. Caso este não seja você, <a href="<?php echo $meli->getLogoutUrl(); ?>">clique aqui para sair</a>.</h3>
<pre>
<?php
print_r($user['json']);
?>
</pre>
