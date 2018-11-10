<div class="entry-content single-page">
	<?php the_content(); ?>
	<?php wp_link_pages( array(
		'before' => '<div class="page-links">' . __( 'Pages:', 'flatsome' ),
		'after'  => '</div>',
	) ); ?>
</div><!-- .entry-content2 -->

<?php if(get_the_tags()) : ?>
<h5>Từ khóa:</h5>
<ul class="nav cloudTags fa-ul">
	<?php foreach(get_the_tags() as $tag): ?>
 	<li><i class="fa fa-tag fa-fw" aria-hidden="true"></i><a class="btn btn-warning" href="<?php bloginfo('url');?>/tu-khoa/<?php print_r($tag->slug);?>"><?php print_r($tag->name); ?></a></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>