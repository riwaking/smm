<?php
if(!defined('BASEPATH')) {
   die('Direct access to the script is not allowed');
}

$title .= $languageArray["dripfeed.title"];

if( $_SESSION["msmbilisim_userlogin"] != 1  || $user["client_type"] == 1  ){
  header("Location:".site_url('logout'));
}
if( $settings["email_confirmation"] == 1  && $user["email_type"] == 1  ){
  header("Location:".site_url('confirm_email'));
}
$status_list  = ["all","active","completed","canceled"];
$search_statu = route(1); if( !route(1) ):  $route[1] = "all";  endif;

  if( !in_array($search_statu,$status_list) ):
    $route[1]         = "all";
  endif;

  if( route(2) ):
    $page         = route(2);
  else:
    $page         = 1;
  endif;
    if( route(1) != "all" ): $search  = "AND dripfeed_status='".route(1)."'"; else: $search=""; endif;
    if( !empty($_GET["search"]) ): $search.= " AND ( order_url LIKE '%".$_GET["search"]."%' OR order_id LIKE '%".$_GET["search"]."%' ) "; endif;
    $c_id       = $user["client_id"];
    $to         = 25;
    $count      = $conn->query("SELECT * FROM orders WHERE client_id='$c_id' AND dripfeed='2' AND subscriptions_type='1' $search ")->rowCount();
    $pageCount  = ceil($count/$to);
      if( $page > $pageCount ): $page = 1; endif;
    $where      = ($page*$to)-$to;
    $paginationArr = ["count"=>$pageCount,"current"=>$page,"next"=>$page+1,"previous"=>$page-1];

  $orders = $conn->prepare("SELECT * FROM orders INNER JOIN services ON services.service_id = orders.service_id WHERE orders.dripfeed=:dripfeed AND orders.subscriptions_type=:subs AND orders.client_id=:c_id $search ORDER BY orders.order_id DESC LIMIT $to OFFSET $where ");
  $orders-> execute(array("c_id"=>$user["client_id"],"dripfeed"=>2,"subs"=>1 ));
  $orders = $orders->fetchAll(PDO::FETCH_ASSOC);
  $ordersList = [];

    foreach ($orders as $order) {
      $o["id"]              = $order["order_id"];
      $o["date"]            = date("Y-m-d H:i:s", (strtotime($order["order_create"])+$user["timezone"]));
      $o["runs"]            = $order["dripfeed_runs"];
      $o["link"]            = $order["order_url"];
      $o["total_charges"]   = $order["dripfeed_totalcharges"];
      $o["delivery"]        = $order["dripfeed_delivery"];
      $o["total_quantity"]  = $order["dripfeed_totalquantity"];
      $o["service"]         = $order["service_name"];
      $o["quantity"]        = $order["order_quantity"];
      $o["status"]          = $languageArray["dripfeed.status.".$order["dripfeed_status"]];
      $o["interval"]        = $order["dripfeed_interval"];
      array_push($ordersList,$o);
    }
