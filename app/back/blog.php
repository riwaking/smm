<?php
if(!defined('BASEPATH')) {
   die('Direct access to the script is not allowed');
}
$title .= "Blogs";

if( !route(1) ){
  
}elseif( route(1) && preg_replace('/[^a-zA-Z]/', '', route(1))  ){
  $templateDir  = "blogpost";

  $blog = route(1);
  if (!countRow(['table' => 'blogs', 'where' => ['blog_get' => $blog, 'status' => "1" ]])) {
    header("Location:".site_url("blog"));
    exit;
  } 
  
  $blogDetail = $conn->prepare("SELECT * FROM blogs WHERE blog_get = :blog_get AND status = :status");
  $blogDetail->execute(array("blog_get" => $blog, "status" => "1"));
  $blogDetail = $blogDetail->fetch(PDO::FETCH_ASSOC);
  
  if ($blogDetail) {
    $blogtitle = $blogDetail['title'] ?? '';
    $blogimage = $blogDetail['image_file'] ?? '';
    $blogcontent = $blogDetail['content'] ?? '';
  }
}
