<?php get_header() ?>
 <div class="fondo">
	<div class="container">
        
            
                <div class="title">
                    <h1 class="h-2"><?php the_title() ?></h1>
                <?php bootstrap_breadcrumb() ?>	
                </div>
 </div>
</div>

<main id="main-content" class="mt-5 mb-5">
                <section id="content">
<div class="container">  
                    <div class="row">
                        <div class="col-sm-12">
                                <?php the_content(); ?>
                            </div>                        
                        </div>
                    </div>
                </section>

            </div>
        </main>

<?php get_footer() ?>