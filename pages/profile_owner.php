<!DOCTYPE html>
<?php
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/owner.class.php');
    require_once(__DIR__ . '/../database/order.class.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');

    $db = getDatabaseConnection();
?>

<?php drawHead() ?>
  <body>
    <?php drawLetfBar() ?>
    <main>
    <?php if(isset($_SESSION['id'])) {
        $owner = Owner::getOwner($db, $_SESSION["id"]);?>
        <section id = "profile_owner_page">
            <h1 class = "username"><?=$owner->username?></h1>
            <label class="popup-button" id="register" for="register-popup"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></label>
            <input type="checkbox" id="register-popup">
            <div class="popupRegister">
                <label for="register-popup" class="transparent-label"></label>
                <div class="popup-inner">
                    <div class="popup-title">
                        <h6>Update information</h6>
                        <label for="register-popup" class="popup-close-btn">Close</label>
                    </div>
                    <div class="popup-content">
                        <form action="../actions/action_edit_user_info.php" method="post">
                            <ul>
                                <li>
                                    <input type="text" name="username" value="<?=$owner->username?>">
                                </li>
                                <li>
                                    <input type="password" name="password" value="Password">
                                </li>
                                <li>
                                    <input type="text" name="address" value="<?=$owner->address?>">
                                </li>
                                <li>
                                    <input type="numbers" name="phone_number" value="<?=$owner->phoneNumber?>">
                                </li>
                                <li>
                                    <button type="submit">Update</button>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
            <span id = "user_info">
                <div class="info_piece"><span>Name</span><p><?=$owner->username?></p></div>
                <div class="info_piece"><span>Contact</span><p><?=$owner->phoneNumber?></p></div>
                <div class="info_piece"><span>address</span><address><?=$owner->address?></address></div>
            </span>
            </span>
        </section>
        <section id = "owner_restaurants">
            <header>
                <h1>My Restaurants</h1>
                <label class="popup-button" id="sign-in" for="login-popup"><i class="fa fa-plus" aria-hidden="true"></i></label>
                <input type="checkbox" id="login-popup">
                <div class="popupLogin">
                <label for="login-popup" class="transparent-label"></label>
                <div class="popup-inner">
                    <div class="popup-title">
                    <h6>Add Restaurant</h6>
                    <label for="login-popup" class="popup-close-btn">Close</label>
                    </div>
                    <div class="popup-content">
                    <form action="../actions/action_addRestaurant.php" method="post">
                        <ul>
                        <li>
                            <input type="text" name="name" placeholder="Restaurant Name">
                        </li>
                        <li>
                            <input type="numbers" name="address" placeholder="Address">
                        </li>
                        <li>
                            <input type="text" name="photo" placeholder="Link to photo">
                        </li>
                        <li>
                            <input type="hidden" name="idOwner" value="<?=$owner->id?>">
                        </li>
                        <li>
                            <button type="submit">Add Restaurant</button>
                        </li>
                        </ul>
                    </form>
                    </div>
                </div>
                </div>
            </header>
            <?php $restaurants = Owner::getRestaurants($db, $owner->id);
            console_log($restaurants);
            foreach ($restaurants as $restaurant) { ?>
                <span class = "my_restaurant">
                    <p class = "name_restaurant"><?=$restaurant->name?></p>
                    <p class = "evaluation_restaurant"><?=$restaurant->rating?></p>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <a href="/pages/restaurant.php?id=<?=$restaurant->id?>"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                </span>
            <?php } ?>
        </section>
    <?php } 
    else { ?>
    <div id="not_registered_favourites">
        <h2 >TO SEE YOUR PROFILE YOU MUST BE LOGGED IN</h2>
    </div>
    <?php } ?>
    </main>
    <?php drawRightBar()?>
  </body>
</html>
