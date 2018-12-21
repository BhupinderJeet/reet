<?php
/* Template Name: Custom Post View */
get_header();


 $args = array( 'posts_per_page' => 5, 'category' => $_GET['id'], 'order'=>'Asc');
 $myposts = get_posts( $args );
?>

<div class="category_top_header">
	<div class="custom_container">
		<div class="cate_title">
			<h1><?php echo get_cat_name( $_GET['id'] ); ?></h1>
			<p>I want to know more about</p>
			</div>
		
		
		<ul class="post_listing">
		<?php foreach ( $myposts as $post ) : ?>
			<li>
				<a href="#" class="post_img_thm" id="<?php echo $post->ID; ?>">
					<?php echo get_the_post_thumbnail( $post->ID, 'thumbnail', array( 'class' => 'img-responsive img_post' )); ?>
				</a>
				<h4><?php echo the_title(); ?></h4>
			</li>
		<?php endforeach; ?>
		</ul>
		
	</div>
</div>

<section class="post_gallery_detail">
	
<section>

<?php get_footer(); ?>

<?php
// functions.php 

function get_category_gallery() {
	$post_id = intval($_POST['post_id']);
	
	if( $post_id == 0 ) {
		echo "Invalid Input";
		die();
	}
	// get the post
	$my_post = get_post( $post_id );

	// check if post exists
	if ( !is_object( $my_post ) ) {
		echo 'There is no post with the ID ' . $post_id;
		die();
	}

	$html_post = '<div class="custom_container">
	<div class="poste_title"><h2>';
	$html_post .= $my_post->post_title;
	$html_post .= '</h2></div><div class="post_gallery">';
	$html_post .= apply_filters( 'the_content', get_post_field('post_content', $post_id) );
	$html_post .= '</div></div>';
	
	echo $html_post;
	die();
	// apply_filters( 'the_content', get_post_field('post_content', $post_id) );
	// $my_post->post_content;
	
}

add_action( 'wp_ajax_get_category_gallery', 'get_category_gallery' );
add_action( 'wp_ajax_nopriv_get_category_gallery', 'get_category_gallery' );


// footer.php code
?>
<script>
	$(document).ready(function() {
		$('.post_img_thm').click(function() {
			var post_id = $(this).attr('id');
			
			$.ajax({
				type: 'POST',
				url: "<?php echo get_home_url(); ?>/wp-admin/admin-ajax.php",
				data: {
					'post_id' : post_id,
					'action' : 'get_category_gallery'
				},
				success: function(result) {
					$('.post_gallery_detail').html(result);
				},
				error: function() {
					alert(error);
				}

			});
		
		});
	});
</script>