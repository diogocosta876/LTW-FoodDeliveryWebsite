<?php
  declare(strict_types = 1);

  session_start();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/dish.class.php');

  $db = getDatabaseConnection();

  $dish = Dish::getDish($db, $_POST['idDish']);
  $res = Restaurant::getRestaurant($db, $dish->id);

  echo json_encode($res->name);
?>