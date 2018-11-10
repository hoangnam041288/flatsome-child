<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package flatsome
 */

get_header(); ?>
	<?php do_action('flatsome_before_404') ;?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main container pt" role="main">
			<section class="error-404 not-found mt mb">
				<div class="row">
					<div class="col medium-3"><span class="header-font" style="font-size: 6em; font-weight: bold; opacity: .3">404</span></div>
					<div class="col medium-9">
						<header class="page-title">
							<h1 class="page-title"><?php esc_html_e( 'Trang hoặc bài viết bạn đang tìm hiện không tồn tại!', 'flatsome' ); ?></h1>
						</header><!-- .page-title -->
						<div class="page-content">
							<p><?php esc_html_e( 'Xin lỗi vì sự cố này. Bạn có thể tìm kiếm thêm ở đây!', 'flatsome' ); ?></p>
							<?php get_search_form(); ?>
						</div><!-- .page-content -->
					</div>
				</div><!-- .row -->
				<?php
					echo "<h4>Tin khác:</h4>";
					echo do_shortcode('[be_medium_post type="row" col_spacing="small" posts="9" columns="3" columns__sm="2" image_height="56.25%" show_date="true" show_category="true" excerpt="true"]');
					echo do_shortcode('[block id="ads-pc4x2-mobile2x2-style-02"]');
				?>
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php do_action('flatsome_after_404') ;?>
<?php get_footer(); ?>
