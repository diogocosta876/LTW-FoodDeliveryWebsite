<?php
    declare(strict_types=1);

    session_start();

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/restaurant.tpl.php');
    require_once(__DIR__ . '/../templates/dish.tpl.php');
    require_once(__DIR__ . '/../templates/category.tpl.php');

    require_once(__DIR__ . '/../database/order.class.php');
    require_once(__DIR__ . '/../database/dish.class.php');
    require_once(__DIR__ . '/../database/dishCategory.class.php');
    require_once(__DIR__ . '/../database/restaurant.class.php');

    $id = intval($_GET['id']);

    $db = getDatabaseConnection();

    $dishes = dishCategory::getDishes($db, $id, 8);
    $categories = dishCategory::getCategories($db, 5);
?>

<?php drawHead() ?>
  <body>
    <?php drawLetfBar() ?>
    <main>
      <?php drawSearchBar() ?>
      <?php drawDishCategoryButtons($categories,$id) ?>
      <section id="card_scroll_down">
      <?php foreach($dishes as $dish) {
          drawDish($db, $dish);
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
