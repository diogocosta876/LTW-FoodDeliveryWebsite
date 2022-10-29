<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../database/order.class.php');
    require_once(__DIR__ . '/../database/customer.class.php');
    require_once(__DIR__ . '/../database/dish.class.php');
    require_once(__DIR__ . '/../database/restaurant.class.php');
    require_once(__DIR__ . '/../database/resCategory.class.php');

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/restaurant.tpl.php');
    require_once(__DIR__ . '/../templates/dish.tpl.php');
    require_once(__DIR__ . '/../templates/category.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');


    $db = getDatabaseConnection();
    
    $dishes = Dish::getDishes($db, 8);
    $restaurants = Restaurant::getRestaurants($db, 8);
    $resCategories = resCategory::getCategories($db, 5);

    global $order;
    global $user;

    if(isset($_SESSION['id'])){
      $user = Customer::getCustomer($db, $_SESSION['id']);
      $order = $_SESSION["order"];
    }
    if(isset($_GET['sent_order']) & isset($_SESSION['id'])){
      $order = $_SESSION["order"];
      $order->sendOrder($db);
    }
    

    console_log($_SESSION);

    if(isset($_GET['cart']) & isset($_SESSION['id'])) {
      console_log("detected press, adding to cart");
      $add_to_cart_id = intval($_GET['cart']);
      $order->AddDishToCart($db, $add_to_cart_id, $user->id);
    } 
    else if(isset($_GET['remove_from_cart']) & isset($_SESSION['id'])) {
      $remove_from_cart_id = intval($_GET['remove_from_cart']);
      console_log("detected cart dish removal, removing dish with id ".strval($remove_from_cart_id));
      $order->removeDishFromCart($db, $remove_from_cart_id, $user->id);
    } 
    console_log($_SESSION);
?>

<?php drawHead() ?>
  <body>
    <?php drawLetfBar() ?>
    <main>
      <?php drawSearchBar() ?>
      <?php drawRestaurantCategoryButtons($resCategories,0) ?>
      <?php drawRestaurants($restaurants) ?>
      <?php drawDishes($db, $restaurants, $dishes) ?>
    </main>
    <?php drawRightBar()?>
  </body>
</html>

<?php 
