<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Light Box 
 */
if($light_box == 4) {
	wp_enqueue_style('awl-ld-lightbox-css', PFG_PLUGIN_URL .'lightbox/ld-lightbox/css/lightbox.css');
	wp_enqueue_script('awl-ld-lightbox-js', PFG_PLUGIN_URL .'lightbox/ld-lightbox/js/lightbox.js', array('jquery'), '' , true);
}
if($light_box == 5) {
	wp_enqueue_style('awl-bootstrap-lightbox-css', PFG_PLUGIN_URL .'lightbox/bootstrap/css/ekko-lightbox.css');
	wp_enqueue_script('awl-bootstrap-lightbox-js', PFG_PLUGIN_URL .'lightbox/bootstrap/js/ekko-lightbox.js', array('jquery'), '' , true);
}

$allimages = array(  'p' => $pf_gallery_id, 'post_type' => 'awl_filter_gallery', 'orderby' => 'ASC');
$loop = new WP_Query( $allimages );
while ( $loop->have_posts() ) : $loop->the_post();
	$post_id = get_the_ID();
	$all_category = get_option('awl_portfolio_filter_gallery_categories');

	// collect all selected filters assigned on images
	$all_selected_filters = array();
	foreach ($filters as $filters_key => $filters_value) {
		if(is_array($filters_value)) {
			$all_selected_filters = array_merge($all_selected_filters, $filters_value);
		}
	} ?>
	<div class="portfolio-wraper pfg-bootstrap" version="<?php echo PFG_PLUGIN_VER ?>">
		<?php
		if($hide_filters == 0 ) {
			if($filter_position == 'center') {
				$filter_align = 'text-center';
			}
			if($filter_position == 'right') {
				$filter_align = 'text-right';
			}
			if($filter_position == 'left') {
				$filter_align = '';
			} ?>
			<div class="col-lg-12 col-md-12 col-xs-12 <?php echo esc_attr($filter_align); ?>">
				<ul id="all-simplefilter" class="filtr-control-<?php echo esc_attr($pf_gallery_id); ?> simplefilter simplefilter_<?php echo esc_attr($pf_gallery_id); ?>">
					<li id="all" class="active filtr-controls-<?php echo esc_attr($pf_gallery_id); ?>" data-filter="all"><?php esc_html_e($all_txt, 'portfolio-filter-gallery'); ?></li>
				</ul>
				<ul id="f-simplefilter-<?php echo $pf_gallery_id; ?>" class="filtr-control-<?php echo esc_attr($pf_gallery_id); ?> simplefilter simplefilter_<?php echo esc_attr($pf_gallery_id); ?>">
					<?php
					if(is_array($all_selected_filters) && count($all_selected_filters)) {
						$all_selected_filters = array_unique($all_selected_filters ); // remove same key
						foreach ($all_selected_filters as $filter_key) {
							?>
							<li data-filter="<?php echo esc_attr($filter_key); ?>" class="filtr-controls-<?php echo esc_attr($pf_gallery_id); ?>"><?php  esc_html_e($all_category[$filter_key], 'portfolio-filter-gallery'); ?></li>
							<?php
						}
					} ?>
				</ul>
			</div>
		<?php 
		} ?>
		<!-- Shuffle & Sort Controls -->
		<?php 
		if($search_box) { ?>
			<div class="col-md-12 filter-wrap <?php echo esc_attr($filter_align); ?>">
				<input type="text" class="filtr-controls-<?php echo esc_attr($pf_gallery_id); ?> filtr-search filtr_search_<?php echo esc_attr($pf_gallery_id); ?>" name="filtr-search" placeholder="<?php if($search_txt) echo ucwords(esc_html($search_txt)); else echo 'Search Images'; ?>" data-search></li>
			</div>
		<?php 
		} ?>
		
		<div class="row loading-wrapper text-center">
			<img src="<?php echo PFG_PLUGIN_URL ?>/img/loading-icon.gif" width="60">
		</div>
		<div class="filter_gallery_<?php echo $pf_gallery_id; ?> row filtr-container filters-div" style="opacity:0; display:none;">
			<?php
			if(isset($pf_gallery_settings['image-ids']) && count($pf_gallery_settings['image-ids']) > 0) {
				$count = 0;
				if($thumbnail_order == "DESC") {
					$pf_gallery_settings['image-ids'] = array_reverse($pf_gallery_settings['image-ids']);
				}
				if($thumbnail_order == "RANDOM") {
					shuffle($pf_gallery_settings['image-ids']);
				}			
				$no = 1;
				foreach($pf_gallery_settings['image-ids'] as $attachment_id) {
					//$attachment_id;
					$image_link_url =  $pf_gallery_settings['image-link'][$count];
					$image_type = $pf_gallery_settings['slide-type'][$count];
					$thumb = wp_get_attachment_image_src($attachment_id, 'thumb', true);
					$thumbnail = wp_get_attachment_image_src($attachment_id, 'thumbnail', true);
					$medium = wp_get_attachment_image_src($attachment_id, 'medium', true);
					$large = wp_get_attachment_image_src($attachment_id, 'large', true);
					$full = wp_get_attachment_image_src($attachment_id, 'full', true);
					$postthumbnail = wp_get_attachment_image_src($attachment_id, 'post-thumbnail', true);
					$attachment_details = get_post( $attachment_id );
					$href = get_permalink( $attachment_details->ID );
					$src = $attachment_details->guid;
					$title = $attachment_details->post_title;
					$description = $attachment_details->post_content;
					
					//set thumbnail size
					if($gal_thumb_size == "thumbnail") { $thumbnail_url = $thumbnail[0]; }
					if($gal_thumb_size == "medium") { $thumbnail_url = $medium[0]; }
					if($gal_thumb_size == "large") { $thumbnail_url = $large[0]; }
					if($gal_thumb_size == "full") { $thumbnail_url = $full[0]; }
					
					// seach attachment id in to $filters and get all filter ids
					//$pfg_filters = $pf_gallery_settings['filters'];
					foreach ($filters as $pfg_filters_key => $pfg_filters_values) {
					}
					if (array_key_exists($attachment_id, $filters)) {
						$filter_key_array = $filters[$attachment_id];
						$prefix = $filter_keys = '';
						if(count($filter_key_array) > 1) {
							foreach ($filter_key_array as $filter_key => $filter_value) {
								$filter_keys .= $prefix . $filter_value;
								$prefix = ', ';
							}
						} else {
							$filter_keys = $filter_key_array[0];						
						}
					}
					// SwipeBox Class
					if (array_key_exists($attachment_id, $filters)) {
						$filter_key_array2 = $filters[$attachment_id];
						$prefix2 = $filter_keys2 = '';
						foreach ($filter_key_array2 as $filter_key2 => $filter_value2) {
							$filter_keys2 .= $prefix2 . $filter_value2;
							$prefix2 = ' pfg-lightbox-';
						}
					}
					if(!isset($filter_keys)) {
						$filter_keys = 1;
					} 
					
					
					// Image Link and lightbox
					// Bootstrap Lighbox
					if($light_box == 5) {
						$a_attrs = 'href="'.$full[0].'" data-toggle="lightbox" data-gallery="multiimages" data-title="'.esc_html($title).'" data-alt="'.esc_html($title).'"';
					}
					// LD Lighbox
					if($light_box == 4) {
						$a_attrs = 'href="'.$full[0].'" class="pfg-lightbox-all pfg-lightbox-'.esc_html($filter_keys2).'" data-lightbox="pfg-lightbox"  data-title="'.esc_html($title).'" data-alt="'.esc_html($title).'"';
					}
					// No LightBox
					if($light_box == 0 ) {
						$a_attrs = 'href="#"';
					}
					// Image and video types
					if($image_type == 'image') {
						if($image_link_url) {
							$a_attrs = 'href="'.esc_url($image_link_url).'" target="'.esc_attr($url_target).'" title="'.esc_attr($title).'"';
						}
					}
					if($image_type == 'video') {
						$a_attrs = 'href="'.esc_url($image_link_url).'" data-title="'.esc_attr($title).'" data-alt="'.esc_attr($title).'" class="video-box-'.esc_attr($pf_gallery_id).'"';
					}
					
					//Content
					?>
					<a <?php _e($a_attrs, 'portfolio-filter-gallery'); ?> title="<?php echo esc_html_e($title, 'portfolio-filter-gallery'); ?>">
						<div data-category="<?php echo esc_html($filter_keys); ?>" data-sort="<?php echo esc_html($title); ?>" class="animateonload filtr-item filtr_item_<?php echo esc_html($pf_gallery_id); ?> single_one <?php echo esc_html($col_large_desktops); ?> <?php echo esc_html($col_desktops); ?> <?php echo esc_html($col_tablets); ?> <?php echo esc_html($col_phones); ?>">
							<?php
							// Type Image
							if($image_type == 'image') {
								?>
								<img class="<?php if($thumb_border == "yes") { ?> thumbnail <?php } ?> thumbnail_<?php echo esc_html($pf_gallery_id); ?> pfg-img pfg_img_<?php echo esc_html($pf_gallery_id); ?> img-responsive <?php echo esc_html($image_hover_effect); ?>" src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ); ?>">
								<?php 
								if($image_numbering) { ?>
									<div class="item-position item_position_<?php echo esc_html($pf_gallery_id); ?>"><?php echo esc_html($no); ?></div>
									<?php 
								} 
								if($title_thumb == "show") { ?>
									<span class="item-desc item_desc_<?php echo esc_html($pf_gallery_id); ?>"><?php esc_html_e($title, 'portfolio-filter-gallery'); ?></span>
									<?php 
								} ?>
								<?php
							}
							//Type Video
							if($image_type == 'video') {
								?>
								<figure class="snipv12">
									<img class="<?php if($thumb_border == "yes") { ?> thumbnail <?php } ?> thumbnail_<?php echo esc_html($pf_gallery_id); ?> pfg-img pfg_img_<?php echo esc_html($pf_gallery_id); ?> img-responsive <?php echo esc_html($image_hover_effect); ?>" src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ); ?>">
									<?php 
									if($image_numbering) { ?>
										<div class="item-position item_position_<?php echo esc_html($pf_gallery_id); ?>"><?php echo esc_html($no); ?></div>
										<?php 
									} if($title_thumb == "show") { ?>
										<span class="item-desc item_desc_<?php echo esc_html($pf_gallery_id); ?>"><?php esc_html_e($title, 'portfolio-filter-gallery'); ?></span>
										<?php 
									} if (!strpos($image_link_url, 'vimeo')) { ?>
										<i class=""><img src="<?php echo PFG_PLUGIN_URL ?>/img/p-youtube.png"></i>
										<?php
									} else { ?>
										<i class="fa fa-youtube-play"></i>
										<?php
									} ?>
								</figure>
								<?php
							}
							?>
						</div>
					</a>
					<?php 
					
					$no++;
					$count++;
				}// end of attachment foreach
			} else {
				_e('Sorry! No image gallery found ', 'portfolio-filter-gallery');
				echo ":[PFG id=$post_id]";
			} // end of if esle of images avaialble check into imager ?>
		</div>
	</div>
<?php
endwhile;
wp_reset_query(); ?>
<script>
jQuery(document).ready(function (jQuery) {
	jQuery('.filtr-item').addClass('animateonload');
	jQuery('#filter_gallery_<?php echo esc_js($pf_gallery_id); ?>').show();
	jQuery('.loading-wrapper').hide();
	jQuery(".loader_img").hide();
	jQuery(".lg_load_more").show();
	jQuery(".filtr-container").css("opacity", 1);
	//Filterizd Default options
	options = {
		animationDuration: 0.5,
		callbacks: {
			onFilteringStart: function() { },
			onFilteringEnd: function() { },
			onShufflingStart: function() { },
			onShufflingEnd: function() { },
			onSortingStart: function() { },
			onSortingEnd: function() { }
		},
		controlsSelector: '.filtr-controls-<?php echo esc_js($pf_gallery_id); ?>',
		filter: 'all',
		 filterOutCss: {
		  top:'0px',
			left:'0px',
			opacity: 0.001,
			transform: ''
		  },
		  filterInCss: {
			  top:'0px',
			left:'0px',
			opacity: 1,
			transform: ''
		  },
		layout: 'sameWidth',
		selector: '.filtr-item',
		setupControls: false
	}
	var filterizd = jQuery('.filter_gallery_<?php echo esc_js($pf_gallery_id); ?>').filterizr(options);
	//filterizd.filterizr('sort', 'domIndex', 'desc');
	jQuery('.filter_gallery_<?php echo $pf_gallery_id; ?>').imagesLoaded( function() {
		// images have already loaded, instantiate Filterizr
		jQuery('.filter_gallery_<?php echo $pf_gallery_id; ?>').filterizr(options);
	}); 
	<?php 
	if ( $sort_by_title == "asc" ) { ?>
		// Sort by title
		filterizd.filterizr('sort', 'sortData', 'asc');
		<?php
	} if ( $sort_by_title == "desc" ) { ?>
		// Sort by decending order
		filterizd.filterizr('sort', 'sortData', 'desc');
	<?php
	}  
	if ( $hide_filters == 0 ) {
		if ( $sort_filter_order == 1 ) { ?>
			/* Sort li to alphabetically: */
			function sortList(ul) {
				var ul = document.getElementById("f-simplefilter-<?php echo $pf_gallery_id; ?>");
				Array.from(ul.getElementsByTagName("LI"))
				.sort((a, b) => a.textContent.localeCompare(b.textContent))
				.forEach(li => ul.appendChild(li));
			}
			sortList("f-simplefilter-<?php echo $pf_gallery_id; ?>");
		/* Sort li to alphabetically: */
		<?php 
		} 
	} ?>
	
		//bootstrap-lightbox-js
		// delegate calls to data-toggle="lightbox"
		jQuery(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function(event) {
			event.preventDefault();
			return jQuery(this).ekkoLightbox({
				onShown: function() {
					/* if (window.console) {
						return console.log('Checking our the events huh?');
					} */
				},
				onNavigate: function(direction, itemIndex) {
					if (window.console) {
						return console.log('Navigating '+direction+'. Current item: '+itemIndex);
					}
				}
			});
		});
		
		jQuery('.filtr-control-<?php echo $pf_gallery_id; ?> [data-filter]').click(function() {
			//jQuery('.swiper-<?php echo $pf_gallery_id; ?>').swipebox('swipebox-destroy');
			var targetFilter = jQuery(this).data('filter');
			var lighbox_class_name = "pfg-lightbox-" + targetFilter;
			jQuery('.pfg-lightbox-' + targetFilter ).attr('data-lightbox', lighbox_class_name); // add data filter for parent filters
		});

		//Programatically call
		jQuery('#open-image').click(function (e) {
			e.preventDefault();
			jQuery(this).ekkoLightbox();
		});
		jQuery('#open-youtube').click(function (e) {
			e.preventDefault();
			jQuery(this).ekkoLightbox();
		});

		// navigateTo
		jQuery(document).delegate('*[data-gallery="navigateTo"]', 'click', function(event) {
			event.preventDefault();

			var lb;
			return jQuery(this).ekkoLightbox({
				onShown: function() {
					lb = this;
					jQuery(lb.modal_content).on('click', '.modal-footer a', function(e) {
						e.preventDefault();
						lb.navigateTo(2);
					});
				}
			});
		});
	

	// video player
	jQuery(function(){
      jQuery("a.video-box-<?php echo $pf_gallery_id; ?>").YouTubePopUp( { autoplay: 0 } ); // Disable autoplay
	});
	
});   
</script>