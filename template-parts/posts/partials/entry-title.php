<?php
	if(is_single()){
		echo '<h1 class="entry-title">'.get_the_title().'</h1>';
	} else {
		echo '<h2 class="entry-title"><a href="'.get_the_permalink().'" rel="bookmark" class="plain">'.get_the_title().'</a></h2>';
	}
?>
<h6 class="entry-category is-xsmall"><?php echo get_the_category_list( __( ', ', 'flatsome' ) ) ?></h6>
<!-- <div class="entry-divider is-divider small"></div> -->
<?php
	$single_post=is_singular('post');
	if($single_post&&get_theme_mod('blog_single_header_meta',1)) : ?>
	<div class="entry-meta uppercase is-xsmall">
		<?php namdh_posted_on(); ?>
	</div><!-- .entry-meta -->
	<?php elseif(!$single_post&&'post'==get_post_type() ) : ?>
	<div class="entry-meta uppercase is-xsmall">
		<?php flatsome_posted_on(); ?>
	</div><!-- .entry-meta -->
<?php endif; ?>
<?php
	function namdh_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}
		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);
		$posted_on = sprintf(
			esc_html_x( 'Bài Đăng %s', 'post date', 'flatsome' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);
		$byline = sprintf(
			esc_html_x( 'bởi %s', 'post author', 'flatsome' ),
			'<span class="meta-author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>');
		// echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';
		echo '<span class="posted-on">' . $posted_on . '</span>';
	}

?>