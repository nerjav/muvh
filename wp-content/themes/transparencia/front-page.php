<?php get_header() ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php if ( 'post' == get_post_type() ) { ?>
<?php } ?>

<div class="fondo">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
            <h1 class="h-2"><?php the_title() ?></h1>
        </div>
    </div>
</div>
</div>


<main id="main-content" class="mt-5 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-sm-9 ">
                <?php the_content(); ?>

            </div>
                <div class="col-sm-3 ">
                     <?php get_sidebar(); ?>          

                </div>



</main>
<?php endwhile; else: ?>
<?php endif; ?>
<?php get_footer() ?>