<?php
if(!defined('BASEPATH')) {
   die('Direct access to the script is not allowed');
}
$title .= "Blogs";

if( !route(1) ){
  
}elseif( route(1) && preg_replace('/[^a-zA-Z]/', '', route(1))  ){
  $templateDir  = "blogpost";

  $blog = route(1);
  
  $blogDetail = $conn->prepare("SELECT * FROM blogs WHERE blog_get = :blog_get AND status IN ('1', '2')");
  $blogDetail->execute(array("blog_get" => $blog));
  $blogDetail = $blogDetail->fetch(PDO::FETCH_ASSOC);
  
  if (!$blogDetail) {
    header("Location:".site_url("blog"));
    exit;
  }
  
  if ($blogDetail) {
    $blogtitle = $blogDetail['title'] ?? '';
    $blogimage = $blogDetail['image_file'] ?? '';
    $blogcontent = $blogDetail['content'] ?? '';
  }
}
