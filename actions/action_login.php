<?php
  declare(strict_types = 1);

  session_start();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/customer.class.php');
  require_once(__DIR__ . '/../database/owner.class.php');

  $db = getDatabaseConnection();

  $customer = Customer::getCustomerWithPassword($db, $_POST['username'], $_POST['password']);

  if ($customer) {
    echo("LOG IN!");
    $_SESSION['id'] = $customer->id;
    $_SESSION['name'] = $customer->username;
    $_SESSION['order'] = InitializeOrder();
  }

  else{
    $owner = Owner::getOwnerWithPassword($db, $_POST['username'], $_POST['password']);

    if ($owner) {
      echo("LOG IN!");
      $_SESSION['id'] = $owner->id;
      $_SESSION['name'] = $owner->username;
      $_SESSION['owner'] = true;
    }
  }

  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>