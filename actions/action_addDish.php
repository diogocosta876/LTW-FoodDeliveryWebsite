<?php
  declare(strict_types = 1);

  session_start();

  if (!(isset($_SESSION['id']))) die(header('Location: ' . $_SERVER['HTTP_REFERER']));

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/dish.class.php');
  require_once(__DIR__ . '/../database/restaurant.class.php');

  $db = getDatabaseConnection();

  if(empty($_POST['name']) || empty($_POST['price'])){
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));
  }

  Dish::addDish($db, intval($_POST['idRestaurant']), $_POST['name'], intval($_POST['price']), 0, $_POST['photo']);

  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>