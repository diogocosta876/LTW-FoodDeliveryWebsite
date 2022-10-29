<?php
  declare(strict_types = 1);

  session_start();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/dish.class.php');

  $db = getDatabaseConnection();

  $dishes = Dish::searchDishes($db, $_GET['search'], 8);

  echo json_encode($dishes);
?>