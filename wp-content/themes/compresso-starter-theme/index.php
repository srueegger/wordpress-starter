<?php
get_header();
if ( have_posts() ) : while ( have_posts() ) : the_post();
?>
<main id="site_main">
  <div <?php post_class( 'container' ); ?>>
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10">
        <?php the_title( '<h1 class="text-primary">', '</h1>' ); ?>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10">
        <?php the_content() ?>
      </div>
    </div>
  </div>
</main>
<?php
endwhile; endif;
get_footer();