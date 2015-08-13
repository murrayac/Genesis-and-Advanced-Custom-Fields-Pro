<?php
/**
 * This file adds the Landing template to the Generate Pro Theme.
 *
 * @author StudioPress
 * @package Generate
 * @subpackage Customizations
 */

/*
Template Name: Event
*/

//* Force full width content layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

?>

<!-- Add our custom loop -->
<?php add_action( 'genesis_entry_footer', 'acf_loop' ); ?>

<?php function acf_loop() { ?>

	<style type="text/css">

	.acf-map {
		width: 100%;
		height: 400px;
		border: #ccc solid 1px;
		margin: 0;
	}

	</style>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	<script type="text/javascript">
	(function($) {

	/*
	*  render_map
	*
	*  This function will render a Google Map onto the selected jQuery element
	*
	*  @type	function
	*  @date	8/11/2013
	*  @since	4.3.0
	*
	*  @param	$el (jQuery element)
	*  @return	n/a
	*/

	function render_map( $el ) {

		// var
		var $markers = $el.find('.marker');

		// vars
		var args = {
			zoom		: 16,
			center		: new google.maps.LatLng(0, 0),
			mapTypeId	: google.maps.MapTypeId.ROADMAP
		};

		// create map	        	
		var map = new google.maps.Map( $el[0], args);

		// add a markers reference
		map.markers = [];

		// add markers
		$markers.each(function(){

	    	add_marker( $(this), map );

		});

		// center map
		center_map( map );

	}

	/*
	*  add_marker
	*
	*  This function will add a marker to the selected Google Map
	*
	*  @type	function
	*  @date	8/11/2013
	*  @since	4.3.0
	*
	*  @param	$marker (jQuery element)
	*  @param	map (Google Map object)
	*  @return	n/a
	*/

	function add_marker( $marker, map ) {

		// var
		var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

		// create marker
		var marker = new google.maps.Marker({
			position	: latlng,
			map			: map
		});

		// add to array
		map.markers.push( marker );

		// if marker contains HTML, add it to an infoWindow
		if( $marker.html() )
		{
			// create info window
			var infowindow = new google.maps.InfoWindow({
				content		: $marker.html()
			});

			// show info window when marker is clicked
			google.maps.event.addListener(marker, 'click', function() {

				infowindow.open( map, marker );

			});
		}

	}

	/*
	*  center_map
	*
	*  This function will center the map, showing all markers attached to this map
	*
	*  @type	function
	*  @date	8/11/2013
	*  @since	4.3.0
	*
	*  @param	map (Google Map object)
	*  @return	n/a
	*/

	function center_map( map ) {

		// vars
		var bounds = new google.maps.LatLngBounds();

		// loop through all markers and create bounds
		$.each( map.markers, function( i, marker ){

			var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

			bounds.extend( latlng );

		});

		// only 1 marker?
		if( map.markers.length == 1 )
		{
			// set center of map
		    map.setCenter( bounds.getCenter() );
		    map.setZoom( 16 );
		}
		else
		{
			// fit to bounds
			map.fitBounds( bounds );
		}

	}

	/*
	*  document ready
	*
	*  This function will render each map when the document is ready (page has loaded)
	*
	*  @type	function
	*  @date	8/11/2013
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/

	$(document).ready(function(){

		$('.acf-map').each(function(){

			render_map( $(this) );

		});

	});

	})(jQuery);
	</script>

	<!-- check if the flexible content field has rows of data -->
	<?php if( have_rows('flexible_content') ): ?>

	     <!-- loop through the rows of data -->
	    <?php while ( have_rows('flexible_content') ) : the_row(); ?>

	        <?php if( get_row_layout() == 'button' ): ?>

	        	<a class="button" href="<?php the_sub_field('link'); ?>"><?php the_sub_field('text'); ?></a>

	        <?php elseif( get_row_layout() == 'title' ): ?>

	        	<h2><?php the_sub_field('title'); ?></h2>

	        <?php elseif( get_row_layout() == 'category_titles'): ?>

	        	<h2><?php the_sub_field('category_title'); ?></h2>

        	<?php elseif( get_row_layout() == 'column_whole' ): ?>
        		
        		<div class="acf-columns">
        			<?php the_sub_field('whole'); ?>
    			</div>

			<?php elseif( get_row_layout() == 'columns_half_half' ): ?>

        		<div class="acf-columns">
	        		<div class="one-half first"><?php the_sub_field('half_first'); ?></div>
	        		<div class="one-half"><?php the_sub_field('half_last'); ?></div>
        		</div>

        	<?php elseif( get_row_layout() == 'columns_one_third_two_thirds' ): ?>

        		<div class="acf-columns">
	        		<div class="one-third first"><?php the_sub_field('one_third'); ?></div>
	        		<div class="two-thirds"><?php the_sub_field('two_thirds'); ?></div>
        		</div>

        	<?php elseif( get_row_layout() == 'columns_two_thirds_one_third' ): ?>

        		<div class="acf-columns">
	        		<div class="two-thirds first"><?php the_sub_field('two_thirds'); ?></div>
	        		<div class="one-third"><?php the_sub_field('one_third'); ?></div>
        		</div>
        		
        	<?php elseif( get_row_layout() == 'columns_one_third_one_third_one_third' ): ?>

        		<div class="acf-columns">
	        		<div class="one-third first"><?php the_sub_field('one_third_first'); ?></div>
	        		<div class="one-third"><?php the_sub_field('one_third_middle'); ?></div>
	        		<div class="one-third"><?php the_sub_field('one_third_last'); ?></div>
        		</div>

        	<?php elseif( get_row_layout() == 'google_map_content' ): ?>

        		<div class="acf-columns">
	        		<div class="two-thirds first">
		        		<?php 

						$location = get_sub_field('google_map');

						if( !empty($location) ):
						?>
						<div class="acf-map">
							<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
						</div>
						<?php endif; ?>
					</div>

	        		<div class="one-third"><?php the_sub_field('map_content'); ?></div>
	    		</div>

        	<?php elseif( get_row_layout() == 'google_content_map' ): ?>

        		<div class="acf-columns">
	        		<div class="one-third first"><?php the_sub_field('map_content'); ?></div>
        			        		
	        		<div class="two-thirds">
		        		<?php 

						$location = get_sub_field('google_map');

						if( !empty($location) ):
						?>
						<div class="acf-map">
							<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
						</div>
						<?php endif; ?>
					</div>
	    		</div>

	        <?php endif; ?>

	    <?php endwhile; ?>

	<?php else : ?>

	    <!-- no layouts found -->

	<?php endif; ?>

<?php } ?>

<?php

//* Run the Genesis loop
genesis();


