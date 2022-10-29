<?php
  declare(strict_types = 1);

  session_start();

  if (!(isset($_SESSION['id']))) die(header('Location: /'));

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/dish.class.php');

  $db = getDatabaseConnection();

  $dish = Dish::getDish($db, intval($_POST['idDish']));

  if($dish){
      $dish->addDishToFavourites($db, intval($_SESSION['id']));
  }

  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>