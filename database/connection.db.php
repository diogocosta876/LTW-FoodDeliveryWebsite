<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/order.class.php');
  require_once(__DIR__ . '/customer.class.php');

  session_start();

  $db = new PDO('sqlite:' . __DIR__ . '/../database/restaurants.db');

  if (isset($_SESSION["id"])){
    
    $order = $_SESSION["order"];
    $user = Customer::getCustomer($db, $_SESSION["id"]);

    if (!isset($order)){
      $order = InitializeOrder();
      $_SESSION["order"] = $order;
    }
  }



  function getDatabaseConnection() : PDO {
    $db = new PDO('sqlite:' . __DIR__ . '/../database/restaurants.db');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $db;
  }

  function InitializeOrder(){
    $db = new PDO('sqlite:' . __DIR__ . '/../database/restaurants.db');
    $stmt = $db->prepare('SELECT idOrder, idState FROM Order_ LIMIT ?');
    $stmt->execute(array(5000));
    $max_order_id = 0;
    while($order = $stmt->fetch()){
     $order_id = $order['idOrder'];
     if ($max_order_id < $order_id){
       $max_order_id = $order_id;
     }
     $statet = $order['idState'];
     $state = unserialize($statet);
    }
    $new_order_id = $order_id + 1;
    if($_SESSION["id"]){
      return new Order($new_order_id, $_SESSION["id"], 0, 0);
    }
    else{
      return new Order($new_order_id, -1, 0, 0);
    }
 }
?>