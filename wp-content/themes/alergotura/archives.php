<?php

/**
 * Template Name: Archives Template
 * Description: A Page Template that lets us created a dedicated Archives page
 *
 * @package WordPress
 * @subpackage Alergotura
 * @since Twenty Eleven 1.0
 */

get_header(); ?>  
        <div id="primary">  
            <div id="content" role="main">  
					<div style="margin-bottom:22px;">          
					<h1 class="entry-title"><?php the_title(); ?></h1>  
                          <?php the_post(); the_content();  ?>  
  
                          <!-- The main functions of our Archives.php template will go below here -->  
  
                            <?php get_search_form(); ?>  
					</div>
					<div style="width:33%;float:left;">
					<h2>Arhiva pe ani</h2><ul>
						<?php $years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts ORDER BY post_date");
						foreach($years as $year) : ?>
						<li><a href="<?php echo get_year_link($year); ?> "><?php echo $year; ?></a></li>
						<?php endforeach; ?></ul></div>
                    
					<div style="width:33%;float:left;">
					<h2>Arhiva pe luni</h2>  
                    <ul>  
                 <?php wp_get_archives(); ?>  
                     </ul>  </div>
          
				<div style="width:33%;float:left;">
                <h2>Archiva pe teme</h2>  
                <ul>  
                  <?php wp_list_categories(); ?>  
                    </ul>  </div>
  
                          <!-- The main functions of our Archives.php template will go above here -->  
  
            </div><!-- #content -->  
        </div><!-- #primary -->  
  
<?php get_footer(); ?>  