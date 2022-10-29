<?php
     declare(strict_types=1);


    require_once(__DIR__ . '/../database/restaurant.class.php');
    require_once(__DIR__ . '/../database/resCategory.class.php');

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/restaurant.tpl.php');
    require_once(__DIR__ . '/../templates/dish.tpl.php');
    require_once(__DIR__ . '/../templates/category.tpl.php');


    $id = intval($_GET['id']);

    $db = getDatabaseConnection();


    $restaurants = resCategory::getRestaurants($db, $id, 10);
    $categories = resCategory::getCategories($db, 5);
?>

<?php drawHead() ?>
  <body>
    <?php drawLetfBar() ?>
    <main>
      <?php drawSearchBar() ?>
      <?php drawRestaurantCategoryButtons($categories,$id) ?>
      <section id="card_scroll_down">
      <?php foreach($restaurants as $restaurant) {
          drawRestaurant($restaurant);
          drawRestaurant($restaurant);
          drawRestaurant($restaurant);
          drawRestaurant($restaurant);
          drawRestaurant($restaurant);
          drawRestaurant($restaurant);
      } ?>
    </section>
    </main>
    <?php drawRightBar()?>
  </body>
</html>
