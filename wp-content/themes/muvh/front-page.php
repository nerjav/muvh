<?php get_header() ?>
<main id="main-content" class="mt-1">
    <div class="box boxsom">
        <div class="container">


            <?php echo do_shortcode("[recent_post_slider design='design-2' show_read_more ='false' limit = '4 ' show_author = 'false'] "); ?>


        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">


                        <div class="bloques">
                            <?php get_sidebar(); ?>
                        </div>

                    </div>

                    <div class="col-sm-7">
                        <div class="bloque1">
                            <h6 class="pt-3 pb-1">Últimas noticias publicadas</h6>
                            <?php

include('plantilla_noticias.php');
$args = null;
wp_reset_query(); 
?>
                            <br>
                            <p style="text-align: center;"><a class="btn btn-primary"
                                    href="https://www.muvh.gov.py/?page_id=97">Ver Más +</a></p>


                        </div>
                    </div>
                </div>

            </div>

            <div class="col-sm-3 contentsidebar">
                <div class="bloques">
                    <h3>Buscar en el sitio</h3>
                    <form id="header-search" action="<?php echo esc_url(home_url('/')); ?>" method="GET">
                        <input type="text" name="s" id="search-input" value="<?php the_search_query(); ?>"
                            class="form-control">
                        <input name="submit" type="submit" value="buscar" class="btn btn-outline-secondary buscar">
                    </form>
                </div>
                <div
                    class="ccm-custom-style-container ccm-custom-style-contenido3135-491 ccm-block-custom-template-listado-clasico">
                    <div class="ccm-block-page-list-clasico">
                        <div class="ccm-block-page-list-header">
                            <h6 class="pb-3">Principales secciones</h6>
                            <?php wp_nav_menu(array(
                                           'theme_location' =>'listados',
                                           'menu_id'=>'sd-menu',
                                        )); ?>


                        </div>
                    </div>
                </div>
                <div class="row">
                    <h6 class="pb-3">Otros Accesos</h6>

                    <?php dynamic_sidebar('accesibility-sidebar-izq') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col-sm-12">
            <h6 class="pt-3 pb-1">Programas Habitacionales</h6>
            <?php echo do_shortcode('[logo-slider]'); ?>

        </div>
    </div>

</main>

<?php get_footer() ?>