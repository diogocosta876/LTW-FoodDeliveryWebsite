<?php
  declare(strict_types = 1);

  session_start();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/restaurant.class.php');

  $db = getDatabaseConnection();

  $restaurants = Restaurant::searchRestaurants($db, $_GET['search'], 8);

  echo json_encode($restaurants);
?>