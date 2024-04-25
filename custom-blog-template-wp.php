<?php
/*
Template Name: Custom Template
*/

get_header();

// Arguments for retrieving the latest posts
$args = array(
    'post_type'      => 'post',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'posts_per_page' => 1, // Fetch all posts. Change this if you only want a specific number of posts
    'post_status'    => 'publish'
);

$result = new WP_Query($args);

function display_featured_posts() {
    $args = array(
        'posts_per_page' => 6,
        'category_name'  => 'web-development,writing' // Change 'featured' to your specific category slug
    );

    $featured_posts_query = new WP_Query($args);
    $content = '';

    if ($featured_posts_query->have_posts()) {
        while ($featured_posts_query->have_posts()) {
            $featured_posts_query->the_post();

            $content .= '<div class="single-posts">';
            $content .= '<h4><a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a></h4>';
            $content .= '<div class="meta-data-blog">';
            $content .= '<span class="authorsite">By ' . get_the_author() . '</span>';
            $content .= '<span class="authorsite">On ' . get_the_date('F j, Y') . '</span>';
            $content .= '</div></div>';
        }
        wp_reset_postdata();
    }

    return $content;
}

add_shortcode('DisplayFeaturedPosts', 'display_featured_posts');
?>


<section class="blog-body">
    <div class="blog-body-parent-container">
<div class="containers-left">
    <?php if ($result->have_posts()) : 
        while ($result->have_posts()) : $result->the_post(); 
            if (has_post_thumbnail()) { 
                the_post_thumbnail('medium');
            } ?>
           <div class="inner-bottom">
              <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
              <div class="left-exerpt-div"><?php echo custom_excerpt_by_words(20); ?></div>
              <p class="authorsite"><?php the_author(); ?>  <?php echo get_the_date('F j, Y'); ?></p> 
         </div>
            
            <?php
            $custom_field_value = get_post_meta(get_the_ID(), 'example_meta_key', true);
            if (!empty($custom_field_value)) {
                echo '<p>Custom Field Value: ' . esc_html($custom_field_value) . '</p>';
            }
        endwhile;
        wp_reset_postdata();
    endif;
    ?>
</div>


        <div class="containers-right">
			<div class="featured">
			 <span>Featured Posts</span>	
			</div>
            <?php echo display_featured_posts(); ?>
        </div>
    </div>
</section>

<section class="below-class">
    <div class="four-columns">
        <?php 
        // Define the WP_Query arguments
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => 4,  // Fetch four posts
            'orderby'        => 'rand',  // Order by random
            'post_status'    => 'publish'
        );

        // Create a new instance of WP_Query
        $the_query = new WP_Query($args);

        // Check if the query returns any posts
        if ($the_query->have_posts()) {
            // The Loop
            while ($the_query->have_posts()) {
                $the_query->the_post();
                ?>
                <div class="first-columns">
                    <?php if (has_post_thumbnail()) { 
                        the_post_thumbnail('medium');
                    } ?>
					<div class="inner-div">
						<h4><?php the_title(); ?></h4>
                    <div class="left-excerpt-div-one"><?php echo custom_excerpt_by_words(20); ?></div>
					<p class="authorsite"><?php the_author(); ?> <br> <?php echo get_the_date('F j, Y'); ?></p> 
					</div>
                    
                </div>
                <?php
            }
            // Reset Post Data after the loop
            wp_reset_postdata();
        } else {
            // No posts found
            echo '<p>No posts found.</p>';
        }
        ?>
    </div>
</section>



<?php
get_sidebar();
get_footer();
?>
