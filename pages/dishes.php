<?php
     declare(strict_types=1);

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/restaurant.tpl.php');
    require_once(__DIR__ . '/../templates/dish.tpl.php');
    require_once(__DIR__ . '/../templates/category.tpl.php');

    require_once(__DIR__ . '/../database/dish.class.php');
    require_once(__DIR__ . '/../database/dishCategory.class.php');
    require_once(__DIR__ . '/../database/restaurant.class.php');


    $db = getDatabaseConnection();

    $dishes = Dish::getDishes($db, 8);
    $categories = dishCategory::getCategories($db, 5);
?>

<?php drawHead() ?>
  <body>
    <?php drawLetfBar() ?>
    <main>
      <?php drawSearchBar() ?>
      <?php drawDishCategoryButtons($categories,0) ?>
      <section id="card_scroll_down">
      <?php foreach($dishes as $dish) {
          drawDish($db, $dish);
          drawDish($db, $dish);
          drawDish($db, $dish);
          drawDish($db, $dish);
          drawDish($db, $dish);
      } ?>
    </section>
    </main>
    <?php drawRightBar()?>
  </body>
</html>