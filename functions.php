<?php

function register_my_menus() {
    register_nav_menus(
        array(
            'footer' => __( 'Footer Menu' )
        )
    );
}

add_action( 'init', 'register_my_menus' );

function get_tag_id_by_slug($tag_slug) {
    global $wpdb;
    // $tag_ID = $wpdb->get_var("SELECT * FROM ".$wpdb->terms." WHERE  `name` =  '".$tag_name."'");
    $term = get_term_by('slug', $tag_slug, 'post_tag');

    $tag_ID = $term->term_id;

    return $tag_ID;
}

function create_post_type() {

    $labels = array(
        'name' => _x('Scholars', 'post type general name'),
        'singular_name' => _x('Scholar', 'post type singular name'),
        'add_new' => _x('Add New', 'Scholar'),
        'add_new_item' => __('Add New Scholar'),
        'edit_item' => __('Edit Scholar'),
        'new_item' => __('New Scholar'),
        'view_item' => __('View Scholar'),
        'search_items' => __('Search Scholars'),
        'not_found' =>  __('No Scholars found'),
        'not_found_in_trash' => __('No Scholars found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Scholars'
      );

      $args = array(
        'labels'        => $labels,
        'description'   => 'Scholar Profiles',
        'public'        => true,
        'menu_position' => 4,
        'supports'      => array( 'title', 'editor', 'custom-fields' ),
        'has_archive'   => true,
        'rewrite' => array('slug' => 'scholars')
    );
    register_post_type( 'islawmix_scholars', $args ); 
}

add_action( 'init', 'create_post_type' );

function retrieve_scholar_posts( $attributes ) {
    $args = shortcode_atts( array(
        'post_type' => 'post',
        'posts_per_page' => '5',
        'order' => 'DESC',
        'tag' => '',
    ), $attributes );

    if (!empty($attributes['tag'])) {
        $the_query = new WP_Query( $args );

        if ( $the_query->have_posts() )  {

            $html = '<div class="scholar_related_posts">
                    <h1>Recent Related Posts:</h1>';

            while ( $the_query->have_posts() ) : $the_query->the_post();

                /* Include the post format-specific template for the content. If you want to
                 * this in a child theme then include a file called called content-___.php
                 * (where ___ is the post format) and that will be used instead.
                 */
                
                $html .= '<h2>
                    <a href="'.get_permalink().'" rel="bookmark">'.get_the_title().'</a>
                </h2>
                <p>'.get_the_excerpt().'</p>';

            endwhile;

            $tag_id = get_tag_id_by_slug($attributes['tag']);

            $html .= '<div class="view_all"><a href="'.get_tag_link($tag_id).'">View All Related Posts</a></div>
                    </div>';

            wp_reset_postdata();
        }
    }

    return $html;
}

add_shortcode( 'scholar_posts', 'retrieve_scholar_posts' );

function kriesi_pagination($pages = '', $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}

function my_category_template( $template ) {
 
    if( is_category( array( 'islamic-law-in-the-news' ) ) ) // We can search for categories by ID
        $template = locate_template( array( 'category-roundup.php', 'category.php' ) );
    elseif( is_category( array( 'editors-picks' ) ) ) // We can search for multiple categories by slug as well
        $template = locate_template( array( 'category-editors-picks.php', 'category.php' ) );
    
    return $template;
}

add_filter( 'category_template', 'my_category_template' );

function islamix_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Home Sidebar', 'twentytwelve' ),
        'id' => 'sidebar-4',
        'description' => __( 'Appears on Home page, which has its own widgets', 'twentytwelve' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
}

add_action( 'widgets_init', 'islamix_widgets_init' );

/**
 * Extends the default WordPress body class to denote:
 * 1. Using a full-width layout, when no active widgets in the sidebar
 *    or full-width template.
 * 2. Front Page template: thumbnail in use and number of sidebars for
 *    widget areas.
 * 3. White or empty background color to change the layout and spacing.
 * 4. Custom fonts enabled.
 * 5. Single or multiple authors.
 *
 * @since Twenty Twelve 1.0
 *
 * @param array Existing class values.
 * @return array Filtered class values.
 */
function islawmix_body_class( $classes ) {
    $background_color = get_background_color();

    if ( (! is_active_sidebar( 'sidebar-4' ) && ! is_active_sidebar( 'sidebar-1' )) || is_page_template( 'page-templates/front-page.php' ) || ! is_home()) {
        $classes[] = 'full-width';
    }

    if ( is_page_template( 'page-templates/front-page.php' ) ) {
        $classes[] = 'template-front-page';
        if ( has_post_thumbnail() )
            $classes[] = 'has-post-thumbnail';
        if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) )
            $classes[] = 'two-sidebars';
    }

    if ( empty( $background_color ) )
        $classes[] = 'custom-background-empty';
    elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) )
        $classes[] = 'custom-background-white';

    // Enable custom font class only if the font CSS is queued to load.
    if ( wp_style_is( 'twentytwelve-fonts', 'queue' ) )
        $classes[] = 'custom-font-enabled';

    if ( ! is_multi_author() )
        $classes[] = 'single-author';

    return $classes;
}

/**
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since Twenty Twelve 1.0
 */
function islawmix_content_width() {
    if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() || (! is_active_sidebar( 'sidebar-1') && ! is_active_sidebar( 'sidebar-1')) || ! is_home() ) {
        global $content_width;
        $content_width = 960;
    }
}

function my_child_theme_setup() {
    remove_filter( 'body_class', 'twentytwelve_body_class' );
    add_filter( 'body_class', 'islawmix_body_class' );

    remove_action( 'template_redirect', 'twentytwelve_content_width' );
    add_action( 'template_redirect', 'islawmix_content_width' );
}

add_action( 'after_setup_theme', 'my_child_theme_setup' );

function list_covering_islamic_law_posts() {
    $the_query = new WP_Query( 'category_name=covering-islamic-law');

    // The Loop
    while ( $the_query->have_posts() ) :
        $the_query->the_post();
        get_template_part( 'content', get_post_format());
    endwhile;
}
add_shortcode( 'covering_islamic_law', 'list_covering_islamic_law_posts' );

?>