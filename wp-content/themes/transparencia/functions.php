<?php

function accesibility_theme_support()
{
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_image_size( 'post-tumbnail', 700, 450, true );
}
if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
}

add_action('after_setup_theme', 'accesibility_theme_support');

function accesibility_menus()
{
    $locations = array(
        'main' => 'Menú Principal',
    );

    register_nav_menus($locations);
}

add_action('init', 'accesibility_menus');

function accesibility_register_styles()
{
    $version = wp_get_theme()->get('Version');
    wp_enqueue_style('accesibility-boostrap', get_template_directory_uri() . '/assets/css/bootstrap.css');
    wp_enqueue_style('accesibility-sidebar-style', get_template_directory_uri() . '/assets/plugins/jquery.mCustomScrollbar.min.css', array('accesibility-boostrap'), '4.0.0', 'all');
    wp_enqueue_style('accesibility-style', get_template_directory_uri() . '/assets/css/style.css', array('accesibility-boostrap', 'accesibility-sidebar-style'), $version, 'all');
}

add_action('wp_enqueue_scripts', 'accesibility_register_styles');

function accesibility_register_scripts()
{
    $version = wp_get_theme()->get('Version');
    wp_enqueue_script('accesibility-jquery', 'https://code.jquery.com/jquery-3.2.1.slim.min.js', array(), '3.2.1', true);
    wp_enqueue_script('accesibility-popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', array(), '1.12.9', true);
    wp_enqueue_script('accesibility-boostrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', array('accesibility-jquery'), '4.0.0', true);
    wp_enqueue_script('accesibility-sidebar-js', 'https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js', array('accesibility-jquery'), '3.1.5', true);
    wp_enqueue_script('accesibility-bundle', get_template_directory_uri() . '/assets/js/bundle.js', array('accesibility-jquery', 'accesibility-boostrap-js','accesibility-sidebar-js'), $version, true);
}

add_action('wp_enqueue_scripts', 'accesibility_register_scripts');

/**
 * Register Custom Navigation Walker
 */
function register_navwalker()
{
    require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
    require_once get_template_directory() . '/class-wp-bootstrap-navwalker-sidebar.php';
}
add_action('after_setup_theme', 'register_navwalker');


function bootstrap_pagination(\WP_Query $wp_query = null, $echo = true, $params = [])
{
    if (null === $wp_query) {
        global $wp_query;
    }

    $add_args = [];

    //add query (GET) parameters to generated page URLs
    /*if (isset($_GET[ 'sort' ])) {
        $add_args[ 'sort' ] = (string)$_GET[ 'sort' ];
    }*/

    $pages = paginate_links(
        array_merge([
            'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'format'       => '?paged=%#%',
            'current'      => max(1, get_query_var('paged')),
            'total'        => $wp_query->max_num_pages,
            'type'         => 'array',
            'show_all'     => false,
            'end_size'     => 3,
            'mid_size'     => 1,
            'prev_next'    => true,
            'prev_text'    => __('« Anterior'),
            'next_text'    => __('Siguiente »'),
            'add_args'     => $add_args,
            'add_fragment' => ''
        ], $params)
    );

    if (is_array($pages)) {
        $pagination = '<nav class="nav-pagination" aria-label="Paginación de las Noticias"><ul class="pagination justify-content-center">';

        foreach ($pages as $page) {
            $pagination .= '<li class="page-item' . (strpos($page, 'current') !== false ? ' active' : '') . '" ' . (strpos($page, 'current') !== false ? ' aria-current="page"' : '') . '> ' . str_replace('page-numbers', 'page-link', $page) . '</li>';
        }

        $pagination .= '</ul></nav>';

        if ($echo) {
            echo $pagination;
        } else {
            return $pagination;
        }
    }

    return null;
}

function add_query_vars_filter($vars)
{
    $vars[] = "s";

    return $vars;
}

add_filter('query_vars', 'add_query_vars_filter');


/**
 * Retrieve category parents.
 *
 * @param int $id Category ID.
 * @param array $visited Optional. Already linked to categories to prevent duplicates.
 * @return string|WP_Error A list of category parents on success, WP_Error on failure.
 */
function custom_get_category_parents($id, $visited = array())
{
    $chain = '';
    $parent = get_term($id, 'category');
  
    if (is_wp_error($parent)) {
        return $parent;
    }
  
    $name = $parent->name;
  
    if ($parent->parent && ($parent->parent != $parent->term_id) && !in_array($parent->parent, $visited)) {
        $visited[] = $parent->parent;
        $chain .= custom_get_category_parents($parent->parent, $visited);
    }
  
    $chain .= '<li class="breadcrumb-item"><a href="' . esc_url(get_category_link($parent->term_id)) . '">' . $name. '</a>' . '</li>';
  
    return $chain;
}


function bootstrap_breadcrumb()
{
    global $post;
  
    $html = '<div aria-label="Breadcrumb"><ol class="breadcrumb pl-0 pt-0">';
  
    if ((is_front_page()) || (is_home())) {
        $html .= '<li class="breadcrumb-item active">Portada</li>';
    } else {
        $html .= '<li class="breadcrumb-item"><a href="'.esc_url(home_url('/')).'">Portada</a></li>';
    
        if (is_attachment()) {
            
            $parent = get_post($post->post_parent);
            $categories = get_the_category($parent->ID);
      
            if ($categories[0]) {
                $html .= custom_get_category_parents($categories[0]);
            }
      
            $html .= '<li class="breadcrumb-item"><a href="' . esc_url(get_permalink($parent)) . '">' . $parent->post_title . '</a></li>';
            $html .= '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
        } elseif (is_category()) {
            $category = get_category(get_query_var('cat'));
      
            if ($category->parent != 0) {
                $html .= custom_get_category_parents($category->parent);
            }
      
            $html .= '<li class="breadcrumb-item active">' . single_cat_title('', false) . '</li>';
        } elseif (is_page() && !is_front_page()) {
            $parent_id = $post->post_parent;
            $parent_pages = array();
      
            while ($parent_id) {
                $page = get_page($parent_id);
                $parent_pages[] = $page;
                $parent_id = $page->post_parent;
            }
      
            $parent_pages = array_reverse($parent_pages);
      
            if (!empty($parent_pages)) {
                foreach ($parent_pages as $parent) {
                    $html .= '<li class="breadcrumb-item"><a href="' . esc_url(get_permalink($parent->ID)) . '">' . get_the_title($parent->ID) . '</a></li>';
                }
            }
      
            $html .= '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
        } elseif (is_singular('post')) {
            $categories = get_the_category();
      
            if ($categories[0]) {
                $html .= custom_get_category_parents($categories[0]);
            }
      
            $html .= '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
        } elseif (is_tag()) {
            $html .= '<li class="breadcrumb-item active">' . single_tag_title('', false) . '</li>';
        } elseif (is_day()) {
            $html .= '<li class="breadcrumb-item"><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a></li>';
            $html .= '<li class="breadcrumb-item"><a href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '">' . get_the_time('m') . '</a></li>';
            $html .= '<li class="breadcrumb-item active">' . get_the_time('d') . '</li>';
        } elseif (is_month()) {
            $html .= '<li class="breadcrumb-item"><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a></li>';
            $html .= '<li class="breadcrumb-item active">' . get_the_time('F') . '</li>';
        } elseif (is_year()) {
            $html .= '<li class="breadcrumb-item active">' . get_the_time('Y') . '</li>';
        } elseif (is_author()) {
            $html .= '<li class="breadcrumb-item active">' . get_the_author() . '</li>';
        } elseif (is_search()) {
        } elseif (is_404()) {
        }
    }
  
    $html .= '</ol></div>';
  
    echo $html;
}


function accesibility_sidebar()
{
    register_sidebar(array(
        'name' => 'Barra Lateral Derecha',
        'id' => 'accesibility-sidebar',
        'class' => 'external-link',
        'description' => 'Sidebar',
        'before_widget' => '<div class="external-link">',
        'after_widget' => '</div>'
    ));
}

add_action('widgets_init', 'accesibility_sidebar');

function accesibility_footer()
{
    register_sidebar(array(
        'name' => 'Pie de Página Izquierda',
        'id' => 'accesibility-footer-1',
        'class' => 'external-link',
        'description' => 'Footer',
        'before_widget' => '<div class="external-link">',
        'after_widget' => '</div>'
    ));
    register_sidebar(array(
        'name' => 'Pie de Página Centro',
        'id' => 'accesibility-footer-2',
        'class' => 'external-link',
        'description' => 'Footer',
        'before_widget' => '<div class="external-link">',
        'after_widget' => '</div>'
    ));
    register_sidebar(array(
        'name' => 'Pie de Página Derecha',
        'id' => 'accesibility-footer-3',
        'class' => 'external-link',
        'description' => 'Footer',
        'before_widget' => '<div class="external-link">',
        'after_widget' => '</div>'
    ));
}

add_action('widgets_init', 'accesibility_footer');
/*  --------------------------------------------------- Filtros by Nestor Morel  ------------------------------------------------------ */
add_filter('use_block_editor_for_post', '__return_false');
register_nav_menu( 'listados', 'Menu que va al sidebar principal izquierdo' );



/*  --------------------------------------------------- Cambia las etiquetas de posts y entradas a Noticias ------------------------------------------------------ */
	/*  ###########################################################  Solicitud de Informaci�n ##################################################   */
		$labels = array(
			'name' => _x('Solicitudes', ''),
			'singular_name' => _x('Solicitud', ''),
			'add_new' => _x('Agregar Solicitud', ''),
			'add_new_item' => __('Agregar Solicitud Nº'),
			'edit_item' => __('Editar decreto'),
			'new_item' => __('Nueva decreto'),
			'view_item' => __('Ver decreto'),
			'search_items' => __('Buscar decretos'),
			'not_found' =>  __('Seccion en construcci&oacute;n'),
			'not_found_in_trash' => __('No hay documento en papelera'),
			'parent_item_colon' => '',
			'menu_name' => 'Solicitud a la Informaciòn'
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'solicitud'),
			'map_meta_cap' => true,
			//'capability_type' => array('decreto', 'decretos'),
			'has_archive' => true,
			//'menu_icon' => get_bloginfo('template_directory') . '/images/xfn-colleague-met.png',
			'hierarchical' => false,
			'menu_position' => 3,
			'supports' => array('title','thumbnail','editor','excerpt','comments')
		);
		register_post_type('solicitudes',$args);
			flush_rewrite_rules();



function change_post_menu_label() {
    global $menu;
    //echo var_dump($menu);
    global $submenu;
    $menu[5][0] = 'Noticias';
    $submenu['edit.php'][5][0] = 'Todas las Noticias';
    $submenu['edit.php'][10][0] = 'Nueva Noticia';
    $submenu['edit.php'][15][0] = 'Categorias'; // Change name for categories
    $submenu['edit.php'][16][0] = 'Palabras clave'; // Change name for tags
    echo '';
}

function change_post_object_label() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'Todos las Noticias';
        $labels->singular_name = 'Noticia';
        $labels->add_new = 'Agregar Noticia';
        $labels->add_new_item = 'Agregar Noticia';
        $labels->edit_item = 'Editar Noticia';
        $labels->new_item = 'Noticia';
        $labels->view_item = 'Ver Noticia';
        $labels->search_items = 'Buscar Noticias';
        $labels->not_found = 'Noticia no encontrada';
        $labels->not_found_in_trash = 'No hay Noticia en la papelera';
    }
    add_action( 'init', 'change_post_object_label' );
    add_action( 'admin_menu', 'change_post_menu_label' );

    register_sidebar( array(
        'id'          => 'lateral2',
        'name'        => __( 'Area de sidebar 2'),
        'description' => __( 'Para agregar banner x contenido' ),
        ) );
    
 // Quita el icono WP en la barra de admin

 function ls_admin_bar_remove() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu( 'wp-logo' );
    }
    
    add_action( 'wp_before_admin_bar_render', 'ls_admin_bar_remove', 0 );

    // Cambiar el pie de pagina del panel de Administración
function change_footer_admin() {
    $any = date('Y');
    echo '©'.$any.' Copyright · Desarrollada por DGSWG-DGTICS ';
   }
   add_filter('admin_footer_text', 'change_footer_admin');

   // Create the function to use in the action hook


   add_action('wp_dashboard_setup', 'wpdocs_remove_dashboard_widgets');
 
   /**
    * Remover cajitas del panel administracion 
    */
   function wpdocs_remove_dashboard_widgets(){
       remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // Right Now
       remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); // Recent Comments
       remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  // Incoming Links
       remove_meta_box('dashboard_plugins', 'dashboard', 'normal');   // Plugins
       remove_meta_box('dashboard_quick_press', 'dashboard', 'side');  // Quick Press
       remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');  // Recent Drafts
       remove_meta_box('dashboard_primary', 'dashboard', 'side');   // WordPress blog
       remove_meta_box('dashboard_secondary', 'dashboard', 'side');   // Other WordPress News
       // use 'dashboard-network' as the second parameter to remove widgets from a network dashboard.
   }

   add_action( 'do_meta_boxes', 'wpdocs_remove_plugin_metaboxes' );
 
   /**
    * Remove Editorial Flow meta box for users that cannot delete pages 
    */
   function wpdocs_remove_plugin_metaboxes(){
       if ( ! current_user_can( 'delete_others_pages' ) ) { // Only run if the user is an Author or lower.
           remove_meta_box( 'ef_editorial_meta', 'post', 'side' ); // Remove Edit Flow Editorial Metadata
       }
   }

/**
 * Elimina  News & Events widget from Network Dashboard
 */
function wpdocs_remove_network_dashboard_widgets() {
    remove_meta_box( 'dashboard_primary', 'dashboard-network', 'side' );
}
add_action( 'wp_network_dashboard_setup', 'wpdocs_remove_network_dashboard_widgets' );

/**
 * Remove native dashboard widgets
 */
add_action( 'wp_dashboard_setup', function(){

    global $wp_meta_boxes;

    remove_action( 'welcome_panel', 'wp_welcome_panel' );
    unset( $wp_meta_boxes['dashboard'] );

    /**
     * Remove others meta boxes added by plugins
     * Example: Yoast Seo
     */
    remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal' );

} );


function example_dashboard_widget_function() {
    // Display whatever it is you want to show
    echo '<div align="center"><img src="'.get_bloginfo('template_directory').'/images/muvhama.jpg" /></div>';
    ?>
  	<p style="font-size:24px; line-height: 1.3em;">Bienvenido al panel de administración del Portal Transparencia, 
  		puede navegar el menu lateral para administrar el contenido de su sitio</p>
 <?php
}

// Create the function use in the action hook
function example_add_dashboard_widgets() {
    wp_add_dashboard_widget('example_dashboard_widget', 'Bienvenida', 'example_dashboard_widget_function');
}
// Hoook into the 'wp_dashboard_setup' action to register our other functions
add_action('wp_dashboard_setup', 'example_add_dashboard_widgets' );
//remove_action('welcome_panel','wp_welcome_panel');














