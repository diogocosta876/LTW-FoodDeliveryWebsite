<?php 
  declare(strict_types = 1); 
  require_once(__DIR__ . '/../database/dish.class.php');
  require_once(__DIR__ . '/../database/restaurant.class.php');
  error_reporting(E_ALL);
  ini_set('display_errors', '1');

?>

<?php function drawDish(PDO $db, Dish $dish) { 
    global $db;
    if (!isset($_SESSION["id"])) $user = 0;
    $restaurant = Restaurant::getRestaurant($db,$dish->idRestaurant);
    ?>
    <article class="dish">
        <a href="/pages/dish.php?id=<?=$dish->id?>">
        <img src="<?=$dish->photo?>" alt="Dish image">
        </a>
        <div class="info">
        <span class = "dish_name"><?=$dish->name_?></span>
        <div class="spacer">
            <span class = "dish_price"><?=$dish->price?></span> 
            <span class = "dish_evaluation"><i class="fa fa-star" aria-hidden="true"></i><?=$dish->rating?></span>
        </div>
            <?php $restaurant = Restaurant::getRestaurant($db, $dish->idRestaurant);
                    $res = $restaurant->name?>
             <div class="dish_restaurant_container">
                  <span class="dish_restaurant_name"><?=$res?></span>
                  <span class = "dish_restaurant_evaluation">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </span> 
            </div>
        </div>
        <?php if (isset($_SESSION['id']) && $dish->isDishInFavourites($db, $_SESSION['id'])) { ?>
        <form method="post" action="../actions/action_remove_dishFavourite.php">
            <button type = "submit" class="add_to_favourites_button" name="idDish" value="<?=$dish->id?>"><i class="fa fa-heart" aria-hidden="true"></i></button>
        </form>
        <?php }
        else { ?>
        <form method="post" action="../actions/action_add_dishFavourite.php">
            <button type = "submit" class="add_to_favourites_button" name="idDish" value="<?=$dish->id?>"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
        </form>
        <?php } ?>
        <?php $get_request = ""; ?>
        <?php if (isset($_SESSION["id"])) $get_request = "pages?cart=" . strval($dish->id) ?>
        <a class="add_to_cart_button" href=<?php echo $get_request ?>><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
    </article>
<?php } ?>



<?php function drawDishes(PDO $db, array $restaurants, array $dishes) { ?>
    <a class="section_title" href="dishes.php">
    <div>DISHES<i class="fa fa-arrow-right" aria-hidden="true"></i></div>
    </a>
    <section id="dishes">
    <?php for ($x = 0; $x < count($dishes); $x += 2) {
        if ($x + 1 == count($dishes)){ ?>
            <div class="dish_column">
            <?php drawDish($db, $dishes[$x]); ?>
            </div>
        <?php }
        else { ?>
            <div class="dish_column">
            <?php drawDish($db, $dishes[$x]); ?>
            <?php drawDish($db, $dishes[$x+1]); ?>
            </div>
        <?php }} ?>
    </section>
<?php } ?>


<?php function drawDishForResPage($dish) { ?>
<a href="/pages/dish.php?id=<?=$dish->id?>">
    <article class="dish">
        <img src="<?= $dish->photo ?>" alt="Dish image">
        <div class="info">
            <span class="dish_name"><?= $dish->name_ ?></span>
            <div class="spacer">
                <span class="dish_price"><?= $dish->price ?></span>
                <span class="dish_evaluation"><i class="fa fa-star" aria-hidden="true"></i><?= $dish->rating ?></span>
            </div>
        </div>
    </article>
</a>
<?php } ?>
