<?php /* plantilla utilizada para listar las noticias */ ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class="publicestirar clearfix">
       
        <?php if(has_post_thumbnail(get_the_ID())){ ?> <a href="<?php the_permalink(); ?>"> 
            <a href="<?php the_permalink(); ?>" class="">
            <?php echo get_the_post_thumbnail( get_the_ID(), 'bloqecitos_thumb foto_portada_item descriptivo' ); ?>
            <div class="modulo">    <h4> <a href="<?php the_permalink(); ?>"style="font-size:20px; font-weight: bold;font-family: 'Montserrat';">  <?php the_title(); ?></a></h4>
            </a>
        <?php } ?> 
            
        <?php include('infonoti.php'); ?>
  
        <?php the_excerpt(); ?>
    </div>
        <br class="clearfix">
    </div>
<?php endwhile; else: ?>
    <h1>No hay contenido en esta seccion.</h1>
<?php endif; ?>

<br>

</br>
