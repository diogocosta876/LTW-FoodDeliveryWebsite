<!DOCTYPE html>
<?php
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/customer.class.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/restaurant.tpl.php');
    require_once(__DIR__ . '/../templates/dish.tpl.php');
    require_once(__DIR__ . '/../templates/category.tpl.php');
    require_once(__DIR__ . '/../templates/comment.tpl.php');

    $db = getDatabaseConnection();
?>

<?php drawHead() ?>
  <body>
    <?php drawLetfBar() ?>
    <main>
    <?php if(isset($_SESSION['id'])) {
        $customer = Customer::getCustomer($db, $_SESSION['id']);?>
        <section id = "profile_owner_page">
            <h1 class = "username"><?=$customer->username?></h1>
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
                                    <input type="text" name="username" value="<?=$customer->username?>">
                                </li>
                                <li>
                                    <input type="password" name="password" value="Password">
                                </li>
                                <li>
                                    <input type="text" name="address" value="<?=$customer->address?>">
                                </li>
                                <li>
                                    <input type="numbers" name="phone_number" value="<?=$customer->phoneNumber?>">
                                </li>
                                <li>
                                    <input type="hidden" name="id" value="<?=$customer->id?>">
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
                <div class="info_piece"><span>Name</span><p><?=$customer->username?></p></div>
                <div class="info_piece"><span>Contact</span><p><?=$customer->phoneNumber?></p></div>
                <div class="info_piece"><span>address</span><address><?=$customer->address?></address></div>
            </span>
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
