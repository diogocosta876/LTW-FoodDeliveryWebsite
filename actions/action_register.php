<?php
  declare(strict_types = 1);

  session_start();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/customer.class.php');
  require_once(__DIR__ . '/../database/owner.class.php');

  $db = getDatabaseConnection();

  if(empty($_POST['username']) || empty($_POST['password'])){
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }

  if(empty($_POST['owner'])){
    $customer = Customer::registerCustomer($db, $_POST['username'], $_POST['password'], $_POST['address'], $_POST['phone_number']);

    if ($customer) {
      $_SESSION['id'] = $customer->id;
      $_SESSION['name'] = $customer->username;
    }
  }

  else{
    $owner = Owner::registerOwner($db, $_POST['username'], $_POST['password'], $_POST['address'], $_POST['phone_number']);

    if ($owner) {
      $_SESSION['id'] = $owner->id;
      $_SESSION['name'] = $owner->username;
      $_SESSION['owner'] = true;
    }
  }

  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>