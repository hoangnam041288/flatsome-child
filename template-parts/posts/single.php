<?php if ( have_posts() ) { while ( have_posts() ) { the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="article-inner <?php flatsome_blog_article_classes(); ?>">
	<?php
		if(flatsome_option('blog_post_style') == 'default' || flatsome_option('blog_post_style') == 'inline'){
			get_template_part('template-parts/posts/partials/entry-header', flatsome_option('blog_posts_header_style') );
		}
		get_template_part( 'template-parts/posts/content', 'single' );
	?>
	</div><!-- .article-inner -->
</article><!-- #<?php the_ID(); echo '-View:'.get_post_meta(get_the_ID(),'namdh_post_views_count', true); #print_r(pvc_get_most_viewed_posts()); ?> -->
<?php
	}
	// ADS: Hiển thị trên PC/Mobile
	#echo do_shortcode('[block id="ads-pc4x2-mobile2x2-style-02"]');

	// Bài Trước/Tiếp Theo
	echo '<div style="overflow: hidden;">';
	echo (get_previous_post()->ID)?'<p style="float:left;"><strong><i class="fa fa-chevron-left" aria-hidden="true"></i> Bài Trước</strong></p>':'';
	echo (get_next_post()->ID)?'<p style="float:right;"><strong>Bài Tiếp Theo <i class="fa fa-chevron-right" aria-hidden="true"></i></strong></p>':'';
	echo '</div>';

	// Tùy Chọn Hiển Thị Mobile/PC
	$be_medium_post = 'type="row" col_spacing="small" columns="2" columns__sm="2" image_height="45%"';
	$show_date = (wp_is_mobile()) ? 'false' : 'true';
	$post_ids = 'ids="'.get_previous_post()->ID.','.get_next_post()->ID.'"';
	echo do_shortcode('[be_medium_post '.$be_medium_post.' '.$post_ids.' show_date="'.$show_date.'" show_category="true" excerpt="false"]');
	$namdh_get_cat = get_the_category()[0];
	
	// Thêm danh mục bài liên quan
	echo '<div style="overflow: hidden;"><p><strong>'.$namdh_get_cat->name.':</strong></p></div>';
	echo do_shortcode('[be_medium_post type="row" col_spacing="small" cat="'.$namdh_get_cat->term_id.'" posts="8" columns="4" columns__sm="2" image_height="56.25%" show_date="true" show_category="false" excerpt="false"]');

	// ADS: Hiển thị trên PC
	#echo do_shortcode('[block id="ads-pc4x2"]');
	} else {
		get_template_part( 'no-results', 'index' );
	}
?>