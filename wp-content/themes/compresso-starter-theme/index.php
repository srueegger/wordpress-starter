<?php
get_header();
if ( have_posts() ) : while ( have_posts() ) : the_post();
?>
<div <?php post_class( 'container' ); ?>>
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10">
      <?php the_title( '<h1>', '</h1>' ); ?>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10">
      <?php the_content() ?>
    </div>
  </div>
</div>
<?php
endwhile; endif;
get_footer();