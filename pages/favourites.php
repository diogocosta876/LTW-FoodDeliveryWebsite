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
    $user_id;

    if(isset($_SESSION["id"])){
        $user_id = $_SESSION["id"];
        $dishes = getFavouriteDishes($db, $user_id);
    }
    else{
        $user_id = 0;
    }

    

?>

<?php drawHead() ?>
  <body>
    <?php drawLetfBar() ?>
    <main>

    <?php if(isset($_SESSION['id'])) { ?>
    
    <a class="section_title" id="favourite_dishes" href="dishes.php">
        <span>FAVOURITE DISHES<i class="fa fa-arrow-right" aria-hidden="true"></i></span>
    </a>
    <section id="dishes">
        <?php for ($x = 0; $x < count($dishes); $x += 2) {
            if ($x + 1 == count($dishes)) { ?>
                <div class="dish_column">
                    <?php drawDish($db, $dishes[$x]); ?>
                </div>
            <?php } else { ?>
                <div class="dish_column">
                    <?php drawDish($db, $dishes[$x]); ?>
                    <?php drawDish($db, $dishes[$x + 1]);?>
                </div>
        <?php }
        } ?>
    </section>

    <?php } 
    else { ?>
    <div id="not_registered_favourites">
        <h2 >TO SEE YOUR FAVOURITES YOU MUST BE LOGGED IN</h2>
    </div>
    <?php } ?>
    </main>
    <?php drawRightBar()?>
  </body>
</html>



<?php 
function getFavouriteDishes(PDO $db, int $user_id) { 
    $stmt = $db->prepare('SELECT idDish FROM FavouriteDish WHERE idCustomer = ? LIMIT ?');
    $stmt->execute(array($user_id, 20));

    $dish_array = [];
    while($dish = $stmt->fetch()){;
        $dish_array[] = Dish::getDish($db, intval($dish["idDish"]));
    }
    console_log($dish_array);


    return $dish_array;
} ?>

