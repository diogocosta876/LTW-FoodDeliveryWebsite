<?php 
  declare(strict_types = 1); 
  require_once(__DIR__ . '/../database/order.class.php');
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/dish.class.php');

  global $order;
  global $user;

  session_start();

  if(isset($_SESSION["id"])){
    $user = $_SESSION["id"];
    $order = $_SESSION["order"];
  }
?>

<?php function drawHead() { ?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>TOGO</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/darkmode_style.css">
    <script type="text/javascript" src="../javascript/script.js" defer></script>
    <script type="text/javascript" src="../javascript/search_restaurant.js" defer></script>
    <script type="text/javascript" src="../javascript/search_dish.js" defer></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
  </head>
<?php } ?>

<?php function drawLetfBar() { ?>
<nav id="left_nav">
    <header id="logo">
        <h1><a href="index.php">TOGO</a></h1>
        <h3>REINVENTING FOOD DELIVERY</h3>
    </header>

    <ul class="nav_options">
    <li><a href="../pages/restaurants.php"><i class="fa fa-home" aria-hidden="true"></i>Restaurants</a></li>
    <li><a href="../pages/dishes.php"><i class="fa fa-cutlery" aria-hidden="true"></i>Dishes</a></li>
    <li><a href="../pages/favourites.php"><i class="fa fa-heart" aria-hidden="true"></i>Favourites</a></li>
    <?php if(isset($_SESSION['owner'])){?>
    <li><a href="../pages/profile_owner.php"><i class="fa fa-user" aria-hidden="true"></i>Profile</a></li>
    <?php } 
    else{?>
    <li><a href="../pages/profile_customer.php"><i class="fa fa-user" aria-hidden="true"></i>Profile</a></li>
    <?php } ?>
    </ul>
    <div class="darkmode_toggle">
    <span>DARKMODE</span>
    <input type="checkbox" id="switch" /><label class="switch" for="switch">Toggle</label>
    </div>
</nav>
<?php } ?>

<?php function drawSearchBar(){ ?>
<div class="search-container">
<form action="empty">
        <input id = "search" type="text" placeholder="" name="search">
        <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
</form>
</div>
<?php } ?>


<?php function drawRightBar() { 
    global $db;
    global $order;  ?>
    <nav id = "right_nav">
        <section id = "profile">
            <?php 
            if(isset($_SESSION['id'])) drawLogOutButton();
            else  drawRegisterLoginButtons();
            ?>
        </section>
        <section id="cart">
            <span class = "section_name">Cart</span>
        <?php if (isset($_SESSION['id'])) {
            if ($order->idRestaurant == 0) $restaurant_name = "restaurant";
            else  $restaurant_name = Restaurant::getRestaurant($db, $order->idRestaurant)->name;  ?>
            <div class="cart_info">
                <span class = "order_number">Order <?php echo $order->idOrder?></span>
                <span class = "cart_restaurant"><?php echo $restaurant_name?></span>
            </div>
            <?php drawCartItems($db, 20); ?>
            <div id="cart_bar_divider"></div>
            <div class="total">
                <span class = "total_label">TOTAL</span>
                <span class = "total_num"><?php echo $order->total ?>€</span>
            </div>
            <?php $get_request = "?sent_order=1" ?>
            <a href=<?php echo $get_request ?> class="order">Order</a>
            
        </section>
        <?php } 
        else{ ?>
            <span class = "section_name">Please Login</span>
            <div class = "spacer"></div>
        <?php } ?>

        <div class="ad_banner_label">Post your advertisement here!</div>
        <img src="..\images\advertisement.png" class="ad" >
    </nav>
<?php } ?>

<?php function drawCartItems(PDO $db, int $count) {
    $order = $_SESSION["order"];

    $dishes = $order->getCartDishes($db);
    foreach ($dishes as $dish_id){?>
        <?php $dish = Dish::getDish($db, $dish_id); ?>
        <article class="cart_dish">
                <img src="<?php echo $dish->photo ?>" alt="Restaurant image">
                <div class="order_info">
                    <span class = "dish_name"><?php echo $dish->name_ ?></span> 
                    <span class = "qnt">Qnt: 1</span>
                    <span class = "price"><?php echo $dish->price ?>€</span> 
                </div>
                <?php $get_request = "pages?remove_from_cart=" . strval($dish->id) ?>
                <a href=<?php echo $get_request ?> class="remove_cart_item"><i class="fa fa-times"></i></a>
        </article>
    <?php }
} ?>


<?php function drawRegisterLoginButtons() { ?>
    <label class="popup-button" id="register" for="register-popup">Register</label>
	<input type="checkbox" id="register-popup">
	<div class="popupRegister">
		<label for="register-popup" class="transparent-label"></label>
		<div class="popup-inner">
			<div class="popup-title">
				<h6>Register</h6>
				<label for="register-popup" class="popup-close-btn">Close</label>
			</div>
			<div class="popup-content">
				<form action="../actions/action_register.php" method="post">
					<ul>
						<li>
							<input type="text" name="username" placeholder="Username">
						</li>
						<li>
							<input type="password" name="password" placeholder="Password">
						</li>
                        <li>
							<input type="text" name="address" placeholder="address">
						</li>
                        <li>
							<input type="numbers" name="phone_number" placeholder="Phone Number">
						</li>
                        <li>
                            <label for="owner_checkbox"> I am a owner</label>
                            <input type="checkbox" id= "owner_checkbox" name="owner" value="true">
                        </li>
						<li>
							<button type="submit">Register</button>
						</li>
					</ul>
				</form>
			</div>
		</div>
	</div>
	<label class="popup-button" id="sign-in" for="login-popup">Login</label>
	<input type="checkbox" id="login-popup">
	<div class="popupLogin">
		<label for="login-popup" class="transparent-label"></label>
		<div class="popup-inner">
			<div class="popup-title">
				<h6>Login</h6>
				<label for="login-popup" class="popup-close-btn">Close</label>
			</div>
			<div class="popup-content">
				<form action="../actions/action_login.php" method="post">
					<ul>
						<li>
							<input type="text" name="username" placeholder="Username">
						</li>
						<li>
							<input type="password" name="password" placeholder="Password">
						</li>
						<li>
							<button type="submit">Log in</button>
						</li>
					</ul>
				</form>
			</div>
		</div>
	</div>
<?php } ?>


<?php function drawLogOutButton(){ ?>
  <?php if(empty($_SESSION['owner'])){ ?>
    <h3>Customer</h3><br>
  <?php }
    else{ ?>
    <h3>Owner</h3>
  <?php } ?>
  <form action="../actions/action_logout.php" method="post" class="logout">
    <?=$_SESSION['name']?>
    <button type="submit">Logout</button>
  </form>
<?php } ?>
