<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/restaurant.class.php');
?>

<?php function drawRestaurant(Restaurant $restaurant) { ?>
<a class="restaurant_clickbox" href="/pages/restaurant.php?id=<?=$restaurant->id?>">
    <article class="restaurant">
        <img src="<?=$restaurant->photo?>" alt="Restaurant image">
        <div class="info">
        <span class = "restaurant_name"><?=$restaurant->name?></span> 
        <span class = "restaurant_evaluation"><?=$restaurant->rating?>
        <?php for ($i = 1; $i <= $restaurant->rating; $i++) { ?>
            <i class="fa fa-star" aria-hidden="true"></i>
        <?php } ?>
        </span> 
        <span class = "restaurant_distance">
            <i class="fa fa-car" aria-hidden="true"></i>
            <?=$restaurant->address?>
        </span>
        </div>
    </article>
</a>
<?php } ?>

<?php function drawRestaurants(array $restaurants) { ?>
<a class="section_title" href="restaurants.php">
    <div>RESTAURANTS<i class="fa fa-arrow-right" aria-hidden="true"></i></div>
    </a>
    <section id="restaurants">
    <?php foreach($restaurants as $restaurant) {
        drawRestaurant($restaurant);
    } ?>
    </section>
<?php } ?>