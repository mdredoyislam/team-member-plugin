<?php
/**
 * Plugin Name: Team Member
 * Text Domain: redoyislam
 * Domain Path: /languages
 * Plugin URI: https://www.redoyislam.xyz/wordpress/plugins/mdredoyislamcustomplugins
 * Assets URI: 
 * Author: MD REDOY ISLAM
 * Author URI: https://www.redoyislam.xyz/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html 
 * Description: Custom Team Member Without Post Type
 * Requires PHP: 7.2
 * Requires at least: 5.2
 * Version: 1.0
 *
 */
function cptui_register_my_cpts() {

	/**
	 * Post Type: Team Members.
	 */

	$labels = [
		"name" => __( "Team Members", "wp-theme-dev" ),
		"singular_name" => __( "Team Member", "wp-theme-dev" ),
		"menu_name" => __( "Team Members", "wp-theme-dev" ),
		"all_items" => __( "All Members", "wp-theme-dev" ),
		"add_new" => __( "Add New Member", "wp-theme-dev" ),
		"add_new_item" => __( "Add New Member", "wp-theme-dev" ),
		"edit_item" => __( "Edit Member", "wp-theme-dev" ),
		"new_item" => __( "Add New Member", "wp-theme-dev" ),
		"view_item" => __( "View Member", "wp-theme-dev" ),
		"view_items" => __( "View Members", "wp-theme-dev" ),
		"search_items" => __( "Search Members", "wp-theme-dev" ),
		"not_found" => __( "Team Members Hash Not Found!", "wp-theme-dev" ),
		"featured_image" => __( "Member Profile Image", "wp-theme-dev" ),
		"set_featured_image" => __( "Set Profile Image", "wp-theme-dev" ),
		"remove_featured_image" => __( "Remove Profile Image", "wp-theme-dev" ),
		"use_featured_image" => __( "Use Profile Image", "wp-theme-dev" ),
	];

	$args = [
		"label" => __( "Team Members", "wp-theme-dev" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "team_members", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 5,
		"menu_icon" => "dashicons-admin-users",
		"supports" => [ "title", "editor", "thumbnail", "excerpt" ],
		"taxonomies" => [ "post_tag", "member_type" ],
		"show_in_graphql" => false,
	];

	register_post_type( "team_members", $args );
}
add_action( 'init', 'cptui_register_my_cpts' );
function cptui_register_my_taxes() {

	/**
	 * Taxonomy: Member Types.
	 */

	$labels = [
		"name" => __( "Member Types", "wp-theme-dev" ),
		"singular_name" => __( "Member Type", "wp-theme-dev" ),
	];

	
	$args = [
		"label" => __( "Member Types", "wp-theme-dev" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'member_type', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "member_type",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "member_type", [ "team_members" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes' );
//Short Code Register
function team_members_shortcode ($args) { 
?>
<div id="team_member">
	<div class="container">
		<div class="row">
			<?php
				$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
				$TeamQuery = new WP_Query( array(
					'post_type'        => 'team_members',
					'order'            => 'DESC',
					'posts_per_page'   => 3,
					'paged'            => $paged
				) );
				while($TeamQuery->have_posts()):$TeamQuery->the_post();
			?>
			<div class="col-md-4">
				<div class="card text-center">
					<?php the_post_thumbnail('full',array('class'=>'img-thumbnail rounded-circle')) ?>
					<div class="card-body">
						<h5 class="card-title"><?php the_title(); ?></h5>
						<p class="card-text">Designation</p>
					</div>
				</div>
			</div>
			<?php
				endwhile;
				/* Restore original Post Data */
				wp_reset_postdata();
			?>
		</div>
	</div>
</div>
<?php }
add_shortcode( 'team_members', 'team_members_shortcode' );
?>
