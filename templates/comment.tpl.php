<?php 
  declare(strict_types = 1); 
  require_once(__DIR__ . '/../database/connection.db.php');
?>

<?php function drawComment($comment) { ?>
<article class="comment">
    <header>
        <?php $db = getDatabaseConnection();?>
        <?php $customer = Customer::getCustomer($db, $comment->idCustomer) ?>
        <h1><?=$customer->username?></h1>
        <h5><?=$comment->timestamp?></h5>
        <span class = "comment_evaluation">
        <?php for ($i = 1; $i <= $comment->starNum; $i++) { ?>
            <i class="fa fa-star" aria-hidden="true"></i>
        <?php } ?>
        </span> 
    </header>
    <?php if(isset($comment->reviewText)){?>
        <p><?=$comment->reviewText?></p>
    <?php };?>
    </div>
</article>
<?php } ?>

<?php function drawComments(array $comments) { 
    foreach($comments as $comment){
        drawComment($comment);
    }
} ?>
