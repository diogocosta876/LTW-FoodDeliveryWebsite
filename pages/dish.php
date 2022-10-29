<!DOCTYPE html>
<?php
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/dishReview.class.php');

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/restaurant.tpl.php');
require_once(__DIR__ . '/../templates/dish.tpl.php');
require_once(__DIR__ . '/../templates/category.tpl.php');
require_once(__DIR__ . '/../templates/comment.tpl.php');

$id = $_GET['id'];

$db = getDatabaseConnection();

$dish = Dish::getDish($db, $id);

$restaurant = Restaurant::getRestaurant($db,$dish->idRestaurant);
$reviews = DishReview::getReviews($db, $dish->id);

?>

<?php drawHead() ?>

<body>
    <?php drawLetfBar() ?>
    <main>
        <header id="restaurant_header">
            <img class="header_img" src="<?= $restaurant->photo ?>" alt="Restaurant image">
            <h1 id="header_name"><?= $restaurant->name ?></h1>
            <section id="header_textbox">
                <h2>Address</h2>
                <address><?= $restaurant->address ?></address>
                <h2>Review Rating</h2>
                <span class="dish_evaluation"><i class="fa fa-star" aria-hidden="true"></i><?= $restaurant->rating ?></span>
            </section>
        </header>
        <section>
            <header id="dish_name_header">
                <h1><?= $dish->name_ ?></h1>
            </header>
            <section id="dish_description_section">
                <img src="<?= $dish->photo ?>" alt="Dish image">
                <span class="dish_page_price"><?= $dish->price ?></span>
                <span class="dish_page_evaluation"><i class="fa fa-star" aria-hidden="true"></i><?= $dish->rating ?></span>
                <div class="spacer">
                <?php if (isset($_SESSION['id']) && $dish->isDishInFavourites($db, $_SESSION['id'])) { ?>
                    <form method="post" action="../actions/action_remove_dishFavourite.php">
                        <button type = "submit" class="add_to_favourites_button_dish_page" name="idDish" value="<?=$dish->id?>"><i class="fa fa-heart" aria-hidden="true"></i></button>
                    </form>
                    <?php }
                    else { ?>
                    <form method="post" action="../actions/action_add_dishFavourite.php">
                        <button type = "submit" class="add_to_favourites_button_dish_page" name="idDish" value="<?=$dish->id?>"><i class="fa fa-heart-o" aria-hidden="true"></i></button>
                    </form>
                <?php } ?>
                <a class="add_to_cart_button_dish_page" href="empty"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                </div>
            </section>
        </section>
        <section id="comments_section">
            <header>
                <h1>Comments</h1>
            </header>
            <?php drawComments($reviews) ?>
            <form action="../actions/action_add_reviewDish.php" method="POST">
                <div id = "review_options">
                <input type="radio" name="rating" id="rating_1" value="1">
                <label for="rating_1">1 <i class="fa fa-star" aria-hidden="true"></i></label>
                <input type="radio" name="rating" id="rating_2" value="2">
                <label for="rating_2">2 <i class="fa fa-star" aria-hidden="true"></i></label>
                <input type="radio" name="rating" id="rating_3" value="3">
                <label for="rating_3">3 <i class="fa fa-star" aria-hidden="true"></i></label>
                <input type="radio" name="rating" id="rating_4" value="4">
                <label for="rating_4">4 <i class="fa fa-star" aria-hidden="true"></i></label>
                <input type="radio" name="rating" id="rating_5" value="5">
                <label for="rating_5">5 <i class="fa fa-star" aria-hidden="true"></i></label>
                <input type="hidden" name="idDish" value=<?=$restaurant->id?>>
                </div>
                <br>
                <input type="submit" value="Submit">
            </form>
        </section>
    </main>
    <?php drawRightBar() ?>
</body>

</html>