<!DOCTYPE html>
<?php
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/restaurantReview.class.php');
    require_once(__DIR__ . '/../database/dish.class.php');
    require_once(__DIR__ . '/../database/order.class.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/restaurant.tpl.php');
    require_once(__DIR__ . '/../templates/dish.tpl.php');
    require_once(__DIR__ . '/../templates/category.tpl.php');
    require_once(__DIR__ . '/../templates/comment.tpl.php');


    $id = $_GET['id'];

    $db = getDatabaseConnection();

    $restaurant = Restaurant::getRestaurant($db,$id);
    $dishes = Dish::getDishesFromRestaurant($db, $restaurant->id);
    $reviews = RestaurantReview::getReviews($db, $restaurant->id);
?>

<?php drawHead() ?>
  <body>
    <?php drawLetfBar() ?>
    <main>
      <header id="restaurant_header">
        <img class="header_img" src="<?=$restaurant->photo?>" alt="Restaurant image">
        <h1 id="header_name"><?=$restaurant->name?></h1>
        <section id="header_textbox">
          <h2>Address</h2>
          <address><?=$restaurant->address?></address>
          <h2>Review Rating</h2>
          <span class = "dish_evaluation"><i class="fa fa-star" aria-hidden="true"></i><?=$restaurant->rating?></span>
        </section> 
      </header>
      <section id="restaurant_dishes_section">
        <header>
          <h1>Dishes</h1>
          <?php if(isset($_SESSION['id']) && intval($_SESSION['id']) == $restaurant->getOwner($db)){?>
            <label class="popup-button" id="register" for="register-popup">Add Dish</label>
            <input type="checkbox" id="register-popup">
            <div class="popupRegister">
              <label for="register-popup" class="transparent-label"></label>
              <div class="popup-inner">
                <div class="popup-title">
                  <h6>Add Dish</h6>
                  <label for="register-popup" class="popup-close-btn">Close</label>
                </div>
                <div class="popup-content">
                  <form action="../actions/action_addDish.php" method="post">
                    <ul>
                      <li>
                        <input type="text" name="name" placeholder="Dish Name">
                      </li>
                      <li>
                        <input type="numbers" name="price" placeholder="Price (€)">
                      </li>
                      <li>
                        <input type="text" name="photo" placeholder="Link to photo">
                      </li>
                      <input type="hidden" name="idRestaurant" value=<?=$restaurant->id?>>
                      <li>
                        <button type="submit">Add Dish</button>
                      </li>
                    </ul>
                  </form>
                </div>
              </div>
            </div>
          <?php } ?>
          
        </header>
        <section id="card_scroll_down">
          <?php foreach($dishes as $dish) {
              drawDishForResPage($dish);
          } ?>
        </section>
      </section>
      <section id="comments_section">
        <header>
          <h1>Comments</h1>
        </header>
        <?php drawComments($reviews) ?>
        <form action="../actions/action_add_reviewRestaurant.php" method="POST">
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
                <input type="hidden" name="idRestaurant" value=<?=$restaurant->id?>>
          </div>
          <textarea class="add_comment" name="reviewText">Type your comment here.</textarea>
          <br>
          <input type="submit" name="submit" value="Add comment">
        </form>
      </section>
    </main>
    <?php drawRightBar()?>
  </body>
</html>
