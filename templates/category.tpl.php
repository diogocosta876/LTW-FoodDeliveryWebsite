<?php 
  declare(strict_types = 1); 

  function getBackgroundColor($num) {
    switch($num) {
        case 1:
            return "#FF9898";
        case 2:
            return "#00B372";
        case 3:
            return "#FFAA5C";
        case 4:
            return "#49C8FF";
        case 5:
            return "#FF4949";
        default:
            return "#fff";
    }
  }
?>

<?php function drawRestaurantCategoryButtons($categories, $selected) { ?>
    <section class="categories" href="empty">
        <?php foreach($categories as $category) { ?>
            <?php if ($category->id == $selected): ?>
                <a class="category" id="selected_category" href = "../pages/restaurantCategory.php?id=<?=$category->id?>" 
                    style="--selected-color: <?php echo getBackgroundColor($category->id); ?>">
                    <?=strtoupper($category->name)?>
                </a>
            <?php else: ?>
                <a class="category" href = "../pages/restaurantCategory.php?id=<?=$category->id?>" 
                    style="background-color: <?php echo getBackgroundColor($category->id); ?>">
                    <?=strtoupper($category->name)?>
                </a>
            <?php endif ?>
        <?php } ?>
    </section>
<?php } ?>

<?php function drawDishCategoryButtons($categories, $selected) { ?>
    <section class="categories" href="empty">
        <?php foreach($categories as $category) { ?>
            <?php if ($category->id == $selected): ?>
                <a class="category" id="selected_category" href = "../pages/dishCategory.php?id=<?=$category->id?>" 
                    style="--selected-color: <?php echo getBackgroundColor($category->id); ?>">
                    <?=strtoupper($category->name)?>
                </a>
            <?php else: ?>
                <a class="category" href = "../pages/dishCategory.php?id=<?=$category->id?>" 
                    style="background-color: <?php echo getBackgroundColor($category->id); ?>">
                    <?=strtoupper($category->name)?>
                </a>
            <?php endif ?>
        <?php } ?>
    </section>
<?php } ?>
