<h1 class="section-title section-title-normal mb-half"><span class="section-title-main"><?php
	echo (is_category()) ? single_cat_title() : single_post_title();
?><span></h1>
<h2 class="h4 thin-font"><?php
	$cat = get_queried_object();
	echo UXBP_string_more($cat->description,50);
?></h2>
<?php
	if(is_category()){
		$args = array(
			'child_of'           => $cat->term_id,
			'taxonomy'           => $cat->taxonomy,
			'orderby'            => 'name',
			'order'              => 'DASC',
			'style'              => 'list',
			'show_option_all'    => '',
			'feed'               => '',
			'feed_type'          => '',
			'feed_image'         => '',
			'exclude'            => '',
			'exclude_tree'       => '',
			'include'            => '',
			'title_li'           => '',
			'show_option_none'   => '',
			'hierarchical'       => 1,
			'use_desc_for_title' => 1,
			'echo'               => 1,
			'hide_empty'         => 0,
			'depth'              => 0,
			'current_category'   => 0,
			'show_count'         => 0,
			'pad_counts'         => 0,
			'number'             => null,
			'walker'             => null,
		);
		echo '<ul class="nav mt-half mb-half">',wp_list_categories( $args ),'</ul>';
	}
	
	if ( have_posts() ) {
	// Lấy danh sách Post trên trang hiện tại
	$ids = array();
	$show = array(5,3,5,3,4,4);
	while ( have_posts() ) { the_post(); array_push($ids, get_the_ID()); }
	$ids_cut = $ids;
	$ids_count = count($ids_cut);

	// Random kiễu hiển thị
	#shuffle($show);
	foreach ($show as $key) {
		$spic = UXBP_array_slice($ids_cut,$key);
		$ids_get = $spic['ids_get'];
		$ids_cut = $spic['ids_cut'];
		$ids = implode(',', $ids_get);
		switch ($key) {
			case '5':
				$case_5 = UXBP_array_slice($ids_get,1);
				$case_51 = $case_5['ids_get'];
				$case_54 = $case_5['ids_cut'];
				$ids_51 = implode(',', $case_51);
				$ids_54 = implode(',', $case_54);
				if ($ids_54) { $col_54 = '[col span="7" span__sm="12"][be_medium_post type="row" columns="2" ids="'.$ids_54.'" image_height="50%" title_length="40" excerpt_length="15" show_category="false"][/col]'; }
				echo do_shortcode('[row][col span="5" span__sm="12"][be_medium_post type="row" columns="1" ids="'.$ids_51.'" title_size="xxlarge" title_length="100" excerpt_length="210" show_category="false" image_height="75%" image_size="original"][/col]'.$col_54.'[/row]');
				break;
			default:
				if ($key==3) { $tl = '50'; $ih = '75%'; } else { $tl = '30'; $ih = '100%'; }
				echo do_shortcode('[be_medium_post type="row" text_align="left" show_category="false" columns="'.$key.'" ids="'.$ids.'" title_length="'.$tl.'" excerpt_length="15" image_height="'.$ih.'"]');
				break;
		}
		if(count($ids_cut)<=0){break;}
	}
?>
<?php flatsome_posts_pagination(); } else { get_template_part( 'template-parts/posts/content','none'); } ?>