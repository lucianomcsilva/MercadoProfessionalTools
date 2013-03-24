<?php
   session_start();
   DEFINE('ADDRESS', "http://localhost/mercadotools/");
   DEFINE('PATH',    'C:\\PortableApps\\xampp\\htdocs\\mercadotools\\');
   error_reporting(0);
   function getNormalizedFILES()
   {
       $newfiles = array();
       foreach($_FILES as $fieldname => $fieldvalue)
           foreach($fieldvalue as $paramname => $paramvalue)
               foreach((array)$paramvalue as $index => $value)
                   $newfiles[$fieldname][$index][$paramname] = $value;
       return $newfiles;
   }
   //---------------------------------------
   $output = array();
   foreach ($_FILES as $key=>$_filedata)
   {
      $temp_name = $_filedata["tmp_name"];
      $file_name = $_filedata["name"];
      $file_atrb = explode('.', $file_name);
      $ext       = strtolower($file_atrb[sizeof($file_atrb) - 1]);
      $random_name = md5(time() +rand());
      move_uploaded_file($temp_name, PATH."customer_images\\{$random_name}.{$ext}");
      $output[] = array(
                  "original_filename" => $file_name,
                  "type" => $_filedata['type'],
                  "filename" => "{$random_name}.{$ext}",
                  "saved_at" => ADDRESS."customer_images/{$random_name}.{$ext}",
                  "thumb_at" => ADDRESS."customer_images/thumbnails/120/{$random_name}.{$ext}");

   }

   $json = json_encode($output);
   header("HTTP/1.0 {$vl_status} {$dc_status}");
   header("Status: {$vl_status} {$dc_status}");
   header("content-type: application/json");

   echo $json;
?>