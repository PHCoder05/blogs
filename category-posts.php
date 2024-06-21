<?php 
include 'partials/header.php';

//fetch posts if id is set
if(isset($_GET['id'])){
    $id=filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query= "SELECT * FROM posts WHERE category_id=$id ORDER BY date_time DESC";
    $posts=mysqli_query($connection,$query);
}else{
    header('location: ' . ROOT_URL . 'blog.php');
}


?>


<header class="category__title">
  
    <?php
            
                $category_query="SELECT * FROM categories WHERE id=$id";
                $category_result=mysqli_query($connection,$category_query);
                $category=mysqli_fetch_assoc($category_result); 
    ?>
    <h2><?= $category['title'] ?></h2>
</header>


<?php if ((mysqli_num_rows($posts)) > 0) : ?>
<section class="posts <?= $featured ? '' : 'section__extra-margin' ?>">
  <div class="container posts__container">
    <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
      <article class="post">
        <div class="post__thumbnail" style="width: 300px; height: 200px;">
          <img src="./images/<?= $post['thumbnail'] ?>" >
        </div>
        <div class="post__info">
          <?php // fetch category from categories using category_id
          $category_id = $post['category_id'];
          $category_query = "SELECT * FROM categories WHERE id=$category_id";
          $category_result = mysqli_query($connection, $category_query);
          $category = mysqli_fetch_assoc($category_result);
          ?>
          <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id'] ?>" class="category__button"><?= $category['title'] ?></a>
          <h2 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h2>
          <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>">

            <p class="post__body" style="min-height: 100px;">
              <?= substr(html_entity_decode($post['body']), 0, 120) ?>...
            </p>
          </a>

          <div class="post__author">
            <?php
            // Fetch author from users table using author id
            $author_id = $post['author_id'];
            $author_query = "SELECT * FROM users WHERE id=$author_id";
            $author_result = mysqli_query($connection, $author_query);
            $author = mysqli_fetch_assoc($author_result);
            $author_firstname = $author['firstname'];
            $author_lastname = $author['lastname'];
            ?>
            <div class="post__author-avatar">
              <img src="./images/<?= $author['avatar'] ?>" alt="" />
            </div>
            <div class="post__author-info">
              <h5>By: <?= "{$author_firstname} {$author_lastname}" ?></h5>
              <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
            </div>
          </div>
        </div>
      </article>
            <?php endwhile ?>

       

    </div>

</section>
<?php else : ?>
    <div class="alert__message error lg">
        <p>
            No posts found for this category
        </p>
    </div>
<?php endif ?>
<!--=====================================================================
==========================END OF THE POSTS===============================
=================================================================== -->
<section class="category__buttons">
    <div class="container category__buttons-container">
        <?php 
        $all_categories_query="SELECT * FROM categories ";
        $all_categories_result=mysqli_query($connection,$all_categories_query);

        ?>
        <?php while ( $category=mysqli_fetch_assoc($all_categories_result) ) : ?>
        <a href="<?=ROOT_URL?>category-posts.php?id=<?=$category['id']?>" class="category__button"><?=$category['title']?></a>
        <?php endwhile?>
    </div>
  </section>
<!--=======================END OF CATEGORY ===================================-->


<?php
include './partials/footer.php';
?>