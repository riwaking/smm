<?php
if(!defined('BASEPATH')) {
   die('Direct access to the script is not allowed');
}

if( $admin["access"]["subscriptions"] != 1  ):
    header("Location:".site_url("admin"));
    exit();
  endif;


  if( $_SESSION["client"]["data"] ):
    $data = $_SESSION["client"]["data"];
    foreach ($data as $key => $value) {
      $$key = $value;
    }
    unset($_SESSION["client"]);
  endif;

    if( route(2) AND is_numeric(route(2)) ):
      $page = route(2);
    else:
      $page = 1;
    endif;

    $statusList = ["all","active","paused","completed","canceled","expired","limit"];
    if( route(3) AND in_array(route(3),$statusList) ):
      $status   = route(3);
    elseif( !route(3) || !in_array(route(3),$statusList) ):
      $status   = "all";
    endif;

    if( $_GET["search_type"] == "username" AND $_GET["search"] ):
      $search_where = $_GET["search_type"];
      $search_word  = urldecode($_GET["search"]);
      $clients      = $conn->prepare("SELECT client_id FROM clients WHERE username LIKE '%".$search_word."%' ");
      $clients     -> execute(array());
      $clients      = $clients->fetchAll(PDO::FETCH_ASSOC);
      $id=  "("; foreach ($clients as $client) { $id.=$client["client_id"].","; } if( substr($id,-1) == "," ):  $id = substr($id,0,-1); endif; $id.=")";
      $search       = " orders.client_id IN ".$id;
      $count        = $conn->prepare("SELECT * FROM orders INNER JOIN clients ON clients.client_id = orders.client_id WHERE {$search} AND orders.dripfeed='1' AND orders.subscriptions_type='2' ");
      $count        -> execute(array());
      $count        = $count->rowCount();
      $search       = "WHERE {$search} AND orders.dripfeed='1' AND orders.subscriptions_type='2' ";
      $search_link  = "?search=".$search_word."&search_type=".$search_where;
    elseif( $_GET["search_type"] == "order_id" AND $_GET["search"] ):
      $search_where = $_GET["search_type"];
      $search_word  = urldecode($_GET["search"]);
      $count        = $conn->prepare("SELECT * FROM orders INNER JOIN clients ON clients.client_id = orders.client_id WHERE orders.order_id LIKE '%".$search_word."%' AND orders.dripfeed='1' AND orders.subscriptions_type='2' ");
      $count        -> execute(array());
      $count        = $count->rowCount();
      $search       = "WHERE orders.order_id LIKE '%".$search_word."%'  AND orders.dripfeed='1' AND orders.subscriptions_type='2' ";
      $search_link  = "?search=".$search_word."&search_type=".$search_where;
    elseif( $_GET["search_type"] == "order_url" AND $_GET["search"] ):
      $search_where = $_GET["search_type"];
      $search_word  = urldecode($_GET["search"]);
      $count        = $conn->prepare("SELECT * FROM orders INNER JOIN clients ON clients.client_id = orders.client_id WHERE orders.order_url LIKE '%".$search_word."%' AND orders.dripfeed='1' AND orders.subscriptions_type='2' ");
      $count        -> execute(array());
      $count        = $count->rowCount();
      $search       = "WHERE orders.order_url LIKE '%".$search_word."%'  AND orders.dripfeed='1' AND orders.subscriptions_type='2' ";
      $search_link  = "?search=".$search_word."&search_type=".$search_where;
    elseif( $_GET["subscription"] ):
      $subs_id      = $_GET["subscription"];
      $count        = $conn->prepare("SELECT * FROM orders INNER JOIN clients ON clients.client_id = orders.client_id WHERE orders.order_id LIKE '%".$search_word."%' AND orders.dripfeed='1' AND orders.subscriptions_type='2' ");
      $count        -> execute(array());
      $count        = $count->rowCount();
      $search       = "WHERE orders.subscriptions_id='$subs_id'  AND orders.dripfeed='1' AND orders.subscriptions_type='2' ";
      $search_link  = "?subscription=".$_GET["subscription"];
    elseif( $_GET["dripfeed"] ):
      $drip_id      = $_GET["dripfeed"];
      $count        = $conn->prepare("SELECT * FROM orders INNER JOIN clients ON clients.client_id = orders.client_id WHERE orders.order_id LIKE '%".$search_word."%' AND orders.dripfeed='1' AND orders.subscriptions_type='2' ");
      $count        -> execute(array());
      $count        = $count->rowCount();
      $search       = "WHERE orders.dripfeed_id='$drip_id'  AND orders.dripfeed='1' AND orders.subscriptions_type='2' ";
      $search_link  = "?dripfeed=".$_GET["subscription"];
    elseif( $status != "all" ):
      $count          = $conn->prepare("SELECT * FROM orders WHERE subscriptions_status=:status AND dripfeed=:dripfeed AND subscriptions_type=:sub ");
      $count        ->execute(array("dripfeed"=>1,"sub"=>2,"status"=>$status));
      $count          = $count->rowCount();
      $search         = "WHERE orders.subscriptions_status='".$status."' AND orders.dripfeed='1' AND orders.subscriptions_type='2' ";
    elseif( $status == "all" ):
      $count          = $conn->prepare("SELECT * FROM orders WHERE dripfeed=:dripfeed AND subscriptions_type=:sub ");
      $count        ->execute(array("dripfeed"=>1,"sub"=>2));
      $count          = $count->rowCount();
      $search         = "WHERE orders.dripfeed='1' AND orders.subscriptions_type='2' ";
    endif;
    $to             = 50;
    $pageCount      = ceil($count/$to); if( $page > $pageCount ): $page = 1; endif;
    $where          = ($page*$to)-$to;
    $paginationArr  = ["count"=>$pageCount,"current"=>$page,"next"=>$page+1,"previous"=>$page-1];
    $orders         = $conn->prepare("SELECT * FROM orders INNER JOIN clients ON clients.client_id=orders.client_id INNER JOIN services ON services.service_id=orders.service_id $search ORDER BY orders.order_id DESC LIMIT $to OFFSET $where ");
    $orders         -> execute(array());
    $orders         = $orders->fetchAll(PDO::FETCH_ASSOC);
    function orderStatu($statu){

      switch ($statu) {
        case 'limit':
          $statu  = "Limit";
        break;
        case 'active':
          $statu  = "Active";
        break;
        case 'completed':
          $statu  = "Completed";
        break;
        case 'paused':
          $statu  = "Paused";
        break;
        case 'canceled':
          $statu  = "Canceled";
        break;
        case 'processing':
          $statu  = "Processing";
        break;
        case 'expired':
          $statu  = "Expired";
        break;
      }

      return $statu;
    }

    if( $_POST ):

        if( route(2) == "set_expiry" ):
          $id     = route(3);
          $expiry = date("Y-m-d", strtotime(str_replace("/","-",$_POST["expiry"])));
          $update = $conn->prepare("UPDATE orders SET subscriptions_expiry=:expiry WHERE order_id=:id AND subscriptions_status!=:status ");
          $update->execute(array("id"=>$id,"expiry"=>$expiry,"status"=>"limit"));
          header("Location:".site_url("admin/subscriptions"));
        elseif( route(2) == "multi-action" ):
          $orders   = $_POST["order"];
          $action   = $_POST["bulkStatus"];
          if( $action ==  "paused" ):
            foreach ($orders as $id => $value):
              $update = $conn->prepare("UPDATE orders SET subscriptions_status=:status WHERE order_id=:id  AND subscriptions_status!=:not");
              $update->execute(array("status"=>"paused","id"=>$id,"not"=>"limit"));
            endforeach;
          elseif( $action ==  "completed" ):
            foreach ($orders as $id => $value):
              $update = $conn->prepare("UPDATE orders SET subscriptions_status=:status WHERE order_id=:id AND subscriptions_status!=:not  ");
              $update->execute(array("status"=>"completed","id"=>$id,"not"=>"limit"));
            endforeach;
          elseif( $action ==  "active" ):
            foreach ($orders as $id => $value):
              $update = $conn->prepare("UPDATE orders SET subscriptions_status=:status WHERE order_id=:id AND subscriptions_status!=:not ");
              $update->execute(array("status"=>"active","id"=>$id,"not"=>"limit"));
            endforeach;
          elseif( $action ==  "canceled" ):
            foreach ($orders as $id => $value):
              $update = $conn->prepare("UPDATE orders SET subscriptions_status=:status WHERE order_id=:id AND subscriptions_status!=:not ");
              $update->execute(array("status"=>"canceled","id"=>$id,"not"=>"limit"));
            endforeach;
          endif;
          header("Location:".site_url("admin/subscriptions"));
        endif;
      exit();
    endif;

  require admin_view('subscriptions');

  if( route(2) ==  "subscriptions_pause" ):
      $update = $conn->prepare("UPDATE orders SET subscriptions_status=:status WHERE order_id=:id  AND subscriptions_status!=:not");
      $update->execute(array("status"=>"paused","id"=>route(3),"not"=>"limit"));
      header("Location:".site_url("admin/subscriptions"));
  elseif( route(2) ==  "subscriptions_complete" ):
      $update = $conn->prepare("UPDATE orders SET subscriptions_status=:status WHERE order_id=:id AND subscriptions_status!=:not  ");
      $update->execute(array("status"=>"completed","id"=>route(3),"not"=>"limit"));
      header("Location:".site_url("admin/subscriptions"));
  elseif( route(2) ==  "subscriptions_active" ):
      $update = $conn->prepare("UPDATE orders SET subscriptions_status=:status WHERE order_id=:id AND subscriptions_status!=:not ");
      $update->execute(array("status"=>"active","id"=>route(3),"not"=>"limit"));
      header("Location:".site_url("admin/subscriptions"));
  elseif( route(2) ==  "subscriptions_canceled" ):
      $update = $conn->prepare("UPDATE orders SET subscriptions_status=:status WHERE order_id=:id AND subscriptions_status!=:not ");
      $update->execute(array("status"=>"canceled","id"=>route(3),"not"=>"limit"));
      header("Location:".site_url("admin/subscriptions"));
  endif;
