<?php
/**
 * Theme widgets.
 *
 * @package Trade_Line
 */

if ( ! function_exists( 'trade_line_load_widgets' ) ) :

	/**
	 * Load widgets.
	 *
	 * @since 1.0.0
	 */
	function trade_line_load_widgets() {

		// Social widget.
		register_widget( 'Trade_Line_Social_Widget' );

		// Featured Page widget.
		register_widget( 'Trade_Line_Featured_Page_Widget' );

		// Call To Action widget.
		register_widget( 'Trade_Line_Call_To_Action_Widget' );

		// Advanced Recent Posts widget.
		register_widget( 'Trade_Line_Advanced_Recent_Posts_Widget' );

		// Latest News widget.
		register_widget( 'Trade_Line_Latest_News_Widget' );

		// Services widget.
		register_widget( 'Trade_Line_Services_Widget' );

		// Teams widget.
		register_widget( 'Trade_Line_Teams_Widget' );

	}

endif;

add_action( 'widgets_init', 'trade_line_load_widgets' );


if ( ! class_exists( 'Trade_Line_Social_Widget' ) ) :

	/**
	 * Social widget Class.
	 *
	 * @since 1.0.0
	 */
	class Trade_Line_Social_Widget extends WP_Widget {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			$opts = array(
				'classname'                   => 'trade_line_widget_social',
				'description'                 => esc_html__( 'Social Icons Widget', 'trade-line' ),
				'customize_selective_refresh' => true,
			);
			parent::__construct( 'trade-line-social', esc_html__( 'Trade Line: Social', 'trade-line' ), $opts );
		}

		/**
		 * Echo the widget content.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments including before_title, after_title,
		 *                        before_widget, and after_widget.
		 * @param array $instance The settings for the particular instance of the widget.
		 */
		function widget( $args, $instance ) {

			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			echo $args['before_widget'];

			// Render title.
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			$nav_menu_locations = get_nav_menu_locations();
			$menu_id = 0;
			if ( isset( $nav_menu_locations['social'] ) && absint( $nav_menu_locations['social'] ) > 0 ) {
				$menu_id = absint( $nav_menu_locations['social'] );
			}
			if ( $menu_id > 0 ) {

				$menu_items = wp_get_nav_menu_items( $menu_id );

				if ( ! empty( $menu_items ) ) {
					echo '<ul class="size-medium">';
					foreach ( $menu_items as $m_key => $m ) {
						echo '<li>';
						echo '<a href="' . esc_url( $m->url ) . '" target="_blank">';
						echo '<span class="title screen-reader-text">' . esc_attr( $m->title ) . '</span>';
						echo '</a>';
						echo '</li>';
					}
					echo '</ul>';
				}
			}
			echo $args['after_widget'];

		}

		/**
		 * Update widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $new_instance New settings for this instance as input by the user via
		 *                            {@see WP_Widget::form()}.
		 * @param array $old_instance Old settings for this instance.
		 * @return array Settings to save or bool false to cancel saving.
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title'] = sanitize_text_field( $new_instance['title'] );

			return $instance;
		}

		/**
		 * Output the settings update form.
		 *
		 * @since 1.0.0
		 *
		 * @param array $instance Current settings.
		 */
		function form( $instance ) {

			// Defaults.
			$instance = wp_parse_args( (array) $instance, array(
				'title' => '',
			) );
			$title = esc_attr( $instance['title'] );

			// Fetch navigation.
			$nav_menu_locations = get_nav_menu_locations();
			$is_menu_set = false;
			if ( isset( $nav_menu_locations['social'] ) && absint( $nav_menu_locations['social'] ) > 0 ) {
				$is_menu_set = true;
			}
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'trade-line' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>

			<?php if ( true !== $is_menu_set ) :  ?>
				<p>
					<?php echo esc_html__( 'Social menu is not set. Please create menu and assign it to Social Menu.', 'trade-line' ); ?>
				</p>
			<?php endif ?>
		<?php
		}
	}

endif;

if ( ! class_exists( 'Trade_Line_Featured_Page_Widget' ) ) :

	/**
	 * Call To Action widget Class.
	 *
	 * @since 1.0.0
	 */
	class Trade_Line_Featured_Page_Widget extends WP_Widget {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			$opts = array(
				'classname'                   => 'trade_line_widget_featured_page',
				'description'                 => esc_html__( 'Displays single featured Page or Post', 'trade-line' ),
				'customize_selective_refresh' => true,
			);
			parent::__construct( 'trade-line-featured-page', esc_html__( 'Trade Line: Featured Page', 'trade-line' ), $opts );
		}

		/**
		 * Echo the widget content.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments including before_title, after_title,
		 *                        before_widget, and after_widget.
		 * @param array $instance The settings for the particular instance of the widget.
		 */
		function widget( $args, $instance ) {

			$title                    = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$use_page_title           = ! empty( $instance['use_page_title'] ) ? $instance['use_page_title'] : false ;
			$featured_page            = ! empty( $instance['featured_page'] ) ? $instance['featured_page'] : 0;
			$featured_post            = ! empty( $instance['featured_post'] ) ? $instance['featured_post'] : 0;
			$content_type             = ! empty( $instance['content_type'] ) ? $instance['content_type'] : 'full';
			$featured_image           = ! empty( $instance['featured_image'] ) ? $instance['featured_image'] : 'disable';
			$featured_image_alignment = ! empty( $instance['featured_image_alignment'] ) ? $instance['featured_image_alignment'] : 'left';

			// ID validation.
			$our_post_object = null;
			$our_id = '';
			if ( absint( $featured_post ) > 0 ) {
				$our_id = absint( $featured_post );
			}
			if ( absint( $featured_page ) > 0 ) {
				$our_id = absint( $featured_page );
			}
			if ( absint( $our_id ) > 0 ) {
				$raw_object = get_post( $our_id );
				if ( ! in_array( $raw_object->post_type, array( 'attachment', 'nav_menu_item', 'revision' ) ) ) {
					$our_post_object = $raw_object;
				}
			}
			if ( ! $our_post_object ) {
				// No valid object; bail now!
				return;
			}

			global $post;
			// Setup global post
			$post = $our_post_object;
			setup_postdata( $post );

			// Override title if checkbox is selected.
			if ( true === $use_page_title ) {
				$title = get_the_title( $post );
			}

			echo $args['before_widget'];

			// Render title.
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			// Display featured image.
			if ( 'disable' !== $featured_image && has_post_thumbnail() ) {
				the_post_thumbnail( esc_attr( $featured_image ), array( 'class' => 'align' . esc_attr( $featured_image_alignment ) ) );
			}
			?>
			<div class="featured-page-widget entry-content">
				<?php
				if ( 'short' === $content_type ) {
					the_excerpt();
				} else {
					the_content();
				}
				?>
			</div>
			<?php
			// Reset.
			wp_reset_postdata();
			echo $args['after_widget'];

		}

		/**
		 * Update widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $new_instance New settings for this instance as input by the user via
		 *                            {@see WP_Widget::form()}.
		 * @param array $old_instance Old settings for this instance.
		 * @return array Settings to save or bool false to cancel saving.
		 */
		function update( $new_instance, $old_instance ) {

			$instance = $old_instance;
			$instance['title']                    = sanitize_text_field( $new_instance['title'] );
			$instance['use_page_title']           = isset( $new_instance['use_page_title'] );
			$instance['featured_page']            = absint( $new_instance['featured_page'] );
			$instance['featured_post']            = absint( $new_instance['featured_post'] );
			if ( $instance['featured_post'] <= 0 ) {
				$instance['featured_post'] = '';
			}
			$instance['content_type']             = esc_attr( $new_instance['content_type'] );
			$instance['featured_image']           = esc_attr( $new_instance['featured_image'] );
			$instance['featured_image_alignment'] = esc_attr( $new_instance['featured_image_alignment'] );
			return $instance;
		}

		/**
		 * Output the settings update form.
		 *
		 * @since 1.0.0
		 *
		 * @param array $instance Current settings.
		 */
		function form( $instance ) {

			// Defaults.
			$instance = wp_parse_args( (array) $instance, array(
				'title'                    => '',
				'use_page_title'           => 1,
				'featured_page'            => '',
				'featured_post'            => '',
				'content_type'             => 'full',
				'featured_image'           => 'disable',
				'featured_image_alignment' => 'left',
			) );

			$title                    = esc_attr( $instance['title'] );
			$use_page_title           = esc_attr( $instance['use_page_title'] );
			$featured_page            = absint( $instance['featured_page'] );
			$featured_post            = esc_attr( $instance['featured_post'] );
			$content_type             = esc_attr( $instance['content_type'] );
			$featured_image           = esc_attr( $instance['featured_image'] );
			$featured_image_alignment = esc_attr($instance['featured_image_alignment']);
			?>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'trade-line' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $title ; ?>" />
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'use_page_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'use_page_title' ) ); ?>" type="checkbox" <?php checked( isset( $instance['use_page_title'] ) ? $instance['use_page_title'] : 0 ); ?> />&nbsp;
				<label for="<?php echo esc_attr( $this->get_field_id( 'use_page_title' ) ); ?>"><?php _e( 'Use Page/Post Title as Widget Title', 'trade-line' ); ?></label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'featured_page' ) ); ?>"><?php esc_html_e( 'Select Page:', 'trade-line' ); ?></label>
				<?php
				wp_dropdown_pages( array(
					'id'               => $this->get_field_id( 'featured_page' ),
					'name'             => $this->get_field_name( 'featured_page' ),
					'selected'         => $featured_page,
					'show_option_none' => __( '&mdash; Select &mdash;', 'trade-line' ),
					)
				);
				?>
			</p>
		  	<h4><?php _ex( 'OR', 'Featured Page Widget', 'trade-line' ); ?></h4>
		  	<p>
		  		<label for="<?php echo esc_attr( $this->get_field_id( 'featured_post' ) ); ?>"><?php esc_html_e( 'Enter Post ID:', 'trade-line' ); ?></label>
		  		<input id="<?php echo esc_attr( $this->get_field_id( 'featured_post' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'featured_post' ) ); ?>" type="number" value="<?php echo esc_attr( $featured_post ); ?>" style="max-width:65px;" />
		  	</p>
		  	<p>
		  		<label for="<?php echo esc_attr( $this->get_field_id( 'content_type' ) ); ?>"><?php esc_html_e( 'Show Content:', 'trade-line' ); ?></label>
		  		<select id="<?php echo esc_attr( $this->get_field_id( 'content_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content_type' ) ); ?>">
		  			<option value="short"<?php selected( $content_type, 'short' ) ?>><?php _e( 'Short', 'trade-line' ) ?></option>
		  			<option value="full"<?php selected( $content_type, 'full' ) ?>><?php _e( 'Full', 'trade-line' ) ?></option>
		  		</select>

		  	</p>
		  	<p>
		  		<label for="<?php echo esc_attr( $this->get_field_id( 'featured_image' ) ); ?>"><?php esc_html_e( 'Featured Image:', 'trade-line' ); ?></label>
		  		<?php
		  		$this->dropdown_image_sizes( array(
		  			'id'       => $this->get_field_id( 'featured_image' ),
		  			'name'     => $this->get_field_name( 'featured_image' ),
		  			'selected' => $featured_image,
		  			)
		  		);
		  		?>
		  	</p>
		  	<p>
		  	  <label for="<?php echo $this->get_field_id( 'featured_image_alignment' ); ?>"><?php _e( 'Image Alignment:', 'trade-line' ); ?></label>
		  	  <?php
		  	  $dropdown_args = array(
		  	  	'id'       => $this->get_field_id( 'featured_image_alignment' ),
		  	  	'name'     => $this->get_field_name( 'featured_image_alignment' ),
		  	  	'selected' => $featured_image_alignment,
		  	  	);
		  	  trade_line_render_select_dropdown( $dropdown_args, 'trade_line_get_image_alignment_options' );
		  	  ?>
		  	</p>

		<?php
		}

		/**
		 * Render image size dropdown.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args Arguments.
		 * @return string Rendered content.
		 */
		function dropdown_image_sizes( $args ) {
			$defaults = array(
				'id'       => '',
				'name'     => '',
				'selected' => 0,
				'echo'     => 1,
			);

			$r = wp_parse_args( $args, $defaults );
			$output = '';

			$choices = trade_line_get_image_sizes_options();

			if ( ! empty( $choices ) ) {

				$output = "<select name='" . esc_attr( $r['name'] ) . "' id='" . esc_attr( $r['id'] ) . "'>\n";
				foreach ( $choices as $key => $choice ) {
					$output .= '<option value="' . esc_attr( $key ) . '" ';
					$output .= selected( $r['selected'], $key, false );
					$output .= '>' . esc_html( $choice ) . '</option>\n';
				}
				$output .= "</select>\n";
			}

			if ( $r['echo'] ) {
				echo $output;
			}
			return $output;

		}
	}

endif;

if ( ! class_exists( 'Trade_Line_Call_To_Action_Widget' ) ) :

	/**
	 * Call To Action widget Class.
	 *
	 * @since 1.0.0
	 */
	class Trade_Line_Call_To_Action_Widget extends WP_Widget {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			$opts = array(
				'classname'                   => 'trade_line_widget_call_to_action',
				'description'                 => esc_html__( 'Call To Action Widget', 'trade-line' ),
				'customize_selective_refresh' => true,
			);
			parent::__construct( 'trade-line-call-to-action', esc_html__( 'Trade Line: Call To Action', 'trade-line' ), $opts );
		}

		/**
		 * Echo the widget content.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments including before_title, after_title,
		 *                        before_widget, and after_widget.
		 * @param array $instance The settings for the particular instance of the widget.
		 */
		function widget( $args, $instance ) {

			$title                  = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$text                   = ! empty( $instance['text'] ) ? $instance['text'] : '';
			$primary_button_text    = ! empty( $instance['primary_button_text'] ) ? esc_html( $instance['primary_button_text'] ) : '';
			$primary_button_url     = ! empty( $instance['primary_button_url'] ) ? esc_url( $instance['primary_button_url'] ) : '';
			$open_url_in_new_window = ! empty( $instance['open_url_in_new_window'] ) ? $instance['open_url_in_new_window'] : false ;

			echo $args['before_widget'];

				// Render title.
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			?>
			<div class="call-to-action-content">
				<?php echo ! empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?>
			</div><!-- .call-to-action-content -->
			<div class="call-to-action-buttons">
				<?php
				$target_text = '';
				if ( $open_url_in_new_window ) {
					$target_text = ' target="_blank" ';
				}
				?>
				<?php if ( ! empty( $primary_button_text ) ) :  ?>
					<a href="<?php echo esc_url( $primary_button_url ); ?>" <?php echo esc_attr( $target_text ) ?> class="button cta-button cta-button-primary"><?php echo esc_attr( $primary_button_text ); ?></a>
				<?php endif ?>
			</div><!-- .call-to-action-buttons -->

			<?php
			echo $args['after_widget'];

		}

		/**
		 * Update widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $new_instance New settings for this instance as input by the user via
		 *                            {@see WP_Widget::form()}.
		 * @param array $old_instance Old settings for this instance.
		 * @return array Settings to save or bool false to cancel saving.
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title'] = sanitize_text_field( $new_instance['title'] );

			if ( current_user_can( 'unfiltered_html' ) ) {
				$instance['text'] = $new_instance['text'];
			} else {
				$instance['text'] = wp_kses_post( $new_instance['text'] );
			}

			$instance['filter']                 = isset( $new_instance['filter'] );
			$instance['primary_button_text']    = sanitize_text_field( $new_instance['primary_button_text'] );
			$instance['primary_button_url']     = esc_url( $new_instance['primary_button_url'] );
			$instance['open_url_in_new_window'] = isset( $new_instance['open_url_in_new_window'] );

			return $instance;
		}

		/**
		 * Output the settings update form.
		 *
		 * @since 1.0.0
		 *
		 * @param array $instance Current settings.
		 */
		function form( $instance ) {

			// Defaults.
			$instance = wp_parse_args( (array) $instance, array(
				'title'                  => '',
				'text'                   => '',
				'filter'                 => 1,
				'primary_button_text'    => esc_html__( 'Read more', 'trade-line' ),
				'primary_button_url'     => '',
				'open_url_in_new_window' => 0,
			) );

			$title                  = esc_attr( $instance['title'] );
			$text                   = esc_textarea( $instance['text'] );
			$filter                 = esc_attr( $instance['filter'] );
			$primary_button_text    = esc_attr( $instance['primary_button_text'] );
			$primary_button_url     = esc_url( $instance['primary_button_url'] );
			$open_url_in_new_window = esc_attr( $instance['open_url_in_new_window'] );
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'trade-line' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $title ; ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Text:', 'trade-line' ); ?></label>
				<textarea class="widefat" rows="5" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"><?php echo $text; ?></textarea>
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'filter' ) ); ?>" type="checkbox" <?php checked( isset( $instance['filter'] ) ? $instance['filter'] : 0 ); ?> />&nbsp;
				<label for="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>"><?php _e( 'Automatically add paragraphs', 'trade-line' ); ?></label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'primary_button_text' ) ); ?>"><?php esc_html_e( 'Button Text:', 'trade-line' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'primary_button_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'primary_button_text' ) ); ?>" type="text" value="<?php echo esc_attr( $primary_button_text ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'primary_button_url' ) ); ?>"><?php esc_html_e( 'Button URL:', 'trade-line' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'primary_button_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'primary_button_url' ) ); ?>" type="text" value="<?php echo esc_url( $primary_button_url ); ?>" />
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'open_url_in_new_window' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'open_url_in_new_window' ) ); ?>" type="checkbox" <?php checked( isset( $instance['open_url_in_new_window'] ) ? $instance['open_url_in_new_window'] : 0 ); ?> />&nbsp;
				<label for="<?php echo esc_attr( $this->get_field_id( 'open_url_in_new_window' ) ); ?>"><?php _e( 'Open URL in New Window', 'trade-line' ); ?></label>
			</p>
		<?php
		}
	}

endif;

if ( ! class_exists( 'Trade_Line_Advanced_Recent_Posts_Widget' ) ) :

	/**
	 * Advanced Recent Posts Widget Class
	 *
	 * @since 1.0.0
	 */
	class Trade_Line_Advanced_Recent_Posts_Widget extends WP_Widget {

	    function __construct() {
			$opts = array(
						'classname'                   => 'trade_line_widget_advanced_recent_posts',
						'description'                 => __( 'Advanced Recent Posts Widget. Displays recent posts with thumbnail.', 'trade-line' ),
						'customize_selective_refresh' => true,
	              );

			parent::__construct( 'trade-line-advanced-recent-posts', __( 'Trade Line: Recent Posts Advanced', 'trade-line' ), $opts );
	    }

	    function widget( $args, $instance ) {

			$title             = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$post_category     = ! empty( $instance['post_category'] ) ? $instance['post_category'] : 0;
			$featured_image    = ! empty( $instance['featured_image'] ) ? $instance['featured_image'] : 'thumbnail';
			$image_width       = ! empty( $instance['image_width'] ) ? $instance['image_width'] : 90;
			$post_number       = ! empty( $instance['post_number'] ) ? $instance['post_number'] : 4;
			$excerpt_length    = ! empty( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 10;
			$disable_date      = ! empty( $instance['disable_date'] ) ? $instance['disable_date'] : false ;
			$disable_comment   = ! empty( $instance['disable_comment'] ) ? $instance['disable_comment'] : false ;
			$disable_excerpt   = ! empty( $instance['disable_excerpt'] ) ? $instance['disable_excerpt'] : false ;

	        echo $args['before_widget'];

	        // Title
	        if ( $title ) {
	        	echo $args['before_title'] . $title . $args['after_title'];
	        }

	        ?>
	        <?php
	          $qargs = array(
	            'posts_per_page' => esc_attr( $post_number ),
	            'no_found_rows'  => true,
	            );
	          if ( absint( $post_category ) > 0  ) {
				  $qargs['category'] = $post_category;
				}

				$all_posts = get_posts( $qargs );
	        ?>
	        <?php if ( ! empty( $all_posts ) ) :  ?>

				<?php global $post; ?>

	        <div class="advanced-recent-posts-widget">

				<?php foreach ( $all_posts as $key => $post ) :  ?>
					<?php setup_postdata( $post ); ?>

					<div class="advanced-recent-posts-item">

						<?php if ( 'disable' !== $featured_image && has_post_thumbnail() ) :  ?>
					      <div class="advanced-recent-posts-thumb">
					        <a href="<?php the_permalink(); ?>">
								<?php
					            $img_attributes = array(
					              'class' => 'alignleft',
					              'style' => 'max-width:' . esc_attr( $image_width ). 'px;',
					            );
					            the_post_thumbnail( esc_attr( $featured_image ), $img_attributes );
								?>
					        </a>
					      </div><!-- .advanced-recent-posts-thumb -->
					    <?php endif ?>
					    <div class="advanced-recent-posts-text-wrap">
					    	<h3 class="advanced-recent-posts-title">
					    		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					    	</h3><!-- .advanced-recent-posts-title -->

					    	<?php if ( false === $disable_date ) :  ?>
					    		<div class="advanced-recent-posts-meta">

					    			<?php if ( false === $disable_date ) :  ?>
					    				<span class="advanced-recent-posts-date"><?php the_time( get_option( 'date_format' ) ); ?></span><!-- .advanced-recent-posts-date -->
					    			<?php endif ?>

					    		</div><!-- .advanced-recent-posts-meta -->
					    	<?php endif ?>

					    	<?php if ( false === $disable_excerpt ) :  ?>
					    		<div class="advanced-recent-posts-summary">
					    			<p><?php echo trade_line_the_excerpt( esc_attr( $excerpt_length ), $post ); ?></p>
					    		</div><!-- .advanced-recent-posts-summary -->
					    	<?php endif; ?>
					    </div><!-- .advanced-recent-posts-text-wrap -->

					</div><!-- .advanced-recent-posts-item .col-sm-3 -->

				<?php endforeach ?>

	        </div><!-- .advanced-recent-posts-widget -->

				<?php wp_reset_postdata(); // Reset ?>

	        <?php endif; ?>
	        <?php
	        	        echo $args['after_widget'];

	    }

	    function update( $new_instance, $old_instance ) {
	        $instance = $old_instance;

	        $instance['title']             = sanitize_text_field( $new_instance['title'] );
	        $instance['post_category']     = absint( $new_instance['post_category'] );
	        $instance['post_number']       = absint( $new_instance['post_number'] );
	        $instance['excerpt_length']    = absint( $new_instance['excerpt_length'] );
	        $instance['featured_image']    = esc_attr( $new_instance['featured_image'] );
	        $instance['image_width']       = absint( $new_instance['image_width'] );
	        $instance['disable_date']      = isset( $new_instance['disable_date'] );
	        $instance['disable_excerpt']   = isset( $new_instance['disable_excerpt'] );

	        return $instance;
	    }

	    function form( $instance ) {
	        // Defaults
	        $instance = wp_parse_args( (array) $instance, array(
				'title'             => '',
				'post_category'     => '',
				'featured_image'    => 'thumbnail',
				'image_width'       => 90,
				'post_number'       => 4,
				'excerpt_length'    => 10,
				'disable_date'      => 0,
				'disable_excerpt'   => 1,
	        ) );

	        $title             = esc_attr( $instance['title'] );
	        $post_category     = absint( $instance['post_category'] );
	        $featured_image    = esc_attr( $instance['featured_image'] );
	        $image_width       = absint( $instance['image_width'] );
	        $post_number       = absint( $instance['post_number'] );
	        $excerpt_length    = absint( $instance['excerpt_length'] );
	        $disable_date      = esc_attr( $instance['disable_date'] );
	        $disable_excerpt   = esc_attr( $instance['disable_excerpt'] );

	        ?>
	        <p>
	           <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'trade-line' ); ?></label>
	           <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	        </p>
	        <p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'post_category' ) ); ?>"><?php _e( 'Select Category:', 'trade-line' ); ?></label>
				<?php
				$cat_args = array(
				    'orderby'         => 'name',
				    'hide_empty'      => 0,
				    'taxonomy'        => 'category',
				    'name'            => $this->get_field_name( 'post_category' ),
				    'id'              => $this->get_field_id( 'post_category' ),
				    'selected'        => $post_category,
				    'show_option_all' => __( 'All Categories','trade-line' ),
				  );
				wp_dropdown_categories( $cat_args );
				?>
	        </p>
	        <p>
	          <label for="<?php echo $this->get_field_id( 'featured_image' ); ?>"><?php _e( 'Select Image Size:', 'trade-line' ); ?></label>
				<?php
	            $this->dropdown_image_sizes( array(
					'id'       => $this->get_field_id( 'featured_image' ),
					'name'     => $this->get_field_name( 'featured_image' ),
					'selected' => $featured_image,
					)
	            );
				?>
	        </p>
	        <p>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'image_width' ) ); ?>"><?php _e( 'Image Width:', 'trade-line' ); ?></label>
	        	<input id="<?php echo esc_attr( $this->get_field_id( 'image_width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_width' ) ); ?>" type="number" value="<?php echo esc_attr( $image_width ); ?>" min="1" style="max-width:50px;" />&nbsp;<em><?php _e( 'px', 'trade-line' ); ?></em>
	        </p>
	        <p>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'post_number' ) ); ?>"><?php _e( 'Number of Posts:', 'trade-line' ); ?></label>
	        	<input id="<?php echo esc_attr( $this->get_field_id( 'post_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_number' ) ); ?>" type="number" value="<?php echo esc_attr( $post_number ); ?>" min="1" style="max-width:50px;" />
	        </p>
	        <p>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>"><?php _e( 'Excerpt Length:', 'trade-line' ); ?></label>
	        	<input id="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_length' ) ); ?>" type="number" value="<?php echo esc_attr( $excerpt_length ); ?>" min="1" style="max-width:50px;" />&nbsp;<small><?php _e( 'in number', 'trade-line' ); ?></small>
	        </p>
	        <p>
	        	<input id="<?php echo esc_attr( $this->get_field_id( 'disable_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_date' ) ); ?>" type="checkbox" <?php checked( isset( $instance['disable_date'] ) ? $instance['disable_date'] : 0 ); ?> />&nbsp;</label>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'disable_date' ) ); ?>"><?php _e( 'Disable Date in Post', 'trade-line' ); ?>

	    	</p>
	    	<p>
	    		<input id="<?php echo esc_attr( $this->get_field_id( 'disable_excerpt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_excerpt' ) ); ?>" type="checkbox" <?php checked( isset( $instance['disable_excerpt'] ) ? $instance['disable_excerpt'] : 0 ); ?> />&nbsp;
	    		<label for="<?php echo esc_attr( $this->get_field_id( 'disable_excerpt' ) ); ?>"><?php _e( 'Disable Post Excerpt', 'trade-line' ); ?> </label>
			</p>
	        <?php
		}

	    function dropdown_image_sizes( $args ) {
			$defaults = array(
	        'id'       => '',
	        'name'     => '',
	        'selected' => 0,
	        'echo'     => 1,
			);

			$r       = wp_parse_args( $args, $defaults );
			$output  = '';
			$choices = trade_line_get_image_sizes_options( true, array( 'thumbnail', 'disable' ), false );

			if ( ! empty( $choices ) ) {

				$output = "<select name='" . esc_attr( $r['name'] ) . "' id='" . esc_attr( $r['id'] ) . "'>\n";
				foreach ( $choices as $key => $choice ) {
					$output .= '<option value="' . esc_attr( $key ) . '" ';
					$output .= selected( $r['selected'], $key, false );
					$output .= '>' . esc_html( $choice ) . '</option>\n';
				}
				$output .= "</select>\n";
			}

			if ( $r['echo'] ) {
				echo $output;
			}
			return $output;

	    }
	}

endif;

if ( ! class_exists( 'Trade_Line_Latest_News_Widget' ) ) :

	/**
	 * Latest News Widget Class
	 *
	 * @since 1.0.0
	 */
	class Trade_Line_Latest_News_Widget extends WP_Widget {

	    function __construct() {
			$opts = array(
						'classname'                   => 'trade_line_widget_latest_news',
						'description'                 => __( 'Latest News Widget. Displays latest posts in grid.', 'trade-line' ),
						'customize_selective_refresh' => true,
	              );

			parent::__construct( 'trade-line-latest-news', esc_html__( 'Trade Line: Latest News', 'trade-line' ), $opts );
	    }


	    function widget( $args, $instance ) {

			$title             = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$post_category     = ! empty( $instance['post_category'] ) ? $instance['post_category'] : 0;
			$post_column       = ! empty( $instance['post_column'] ) ? $instance['post_column'] : 4;
			$featured_image    = ! empty( $instance['featured_image'] ) ? $instance['featured_image'] : 'medium';
			$excerpt_length    = ! empty( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 40;
			$more_text         = ! empty( $instance['more_text'] ) ? $instance['more_text'] : __( 'Read more','trade-line' );
			$disable_date      = ! empty( $instance['disable_date'] ) ? $instance['disable_date'] : false ;
			$disable_comment   = ! empty( $instance['disable_comment'] ) ? $instance['disable_comment'] : false ;
			$disable_excerpt   = ! empty( $instance['disable_excerpt'] ) ? $instance['disable_excerpt'] : false ;
			$disable_more_text = ! empty( $instance['disable_more_text'] ) ? $instance['disable_more_text'] : false ;

	        echo $args['before_widget'];

	        // Title.
	        if ( $title ) {
	        	echo $args['before_title'] . $title . $args['after_title'];
	        }

	        ?>
	        <?php
	          $qargs = array(
	            'posts_per_page' => esc_attr( $post_column ),
	            'no_found_rows'  => true,
	            );
	          if ( absint( $post_category ) > 0  ) {
				  $qargs['category'] = absint( $post_category );
				}

				$all_posts = get_posts( $qargs );

	        ?>
	        <?php if ( ! empty( $all_posts ) ) :  ?>

				<?php global $post; ?>

	          <div class="latest-news-widget latest-news-col-<?php echo esc_attr( $post_column ); ?>">

	            <div class="inner-wrapper">

					<?php foreach ( $all_posts as $key => $post ) :  ?>
	                <?php setup_postdata( $post ); ?>

	                <div class="latest-news-item">
		                <div class="latest-news-wrapper">
		                <?php if ( 'disable' !== $featured_image && has_post_thumbnail() ) :  ?>
		                  <div class="latest-news-thumb">
		                    <a href="<?php the_permalink(); ?>">
								<?php
		                        $img_attributes = array( 'class' => 'aligncenter' );
		                        the_post_thumbnail( esc_attr( $featured_image ), $img_attributes );
								?>
		                    </a>
		                  </div><!-- .latest-news-thumb -->
		                <?php endif ?>
		                <div class="latest-news-text-wrap">
		                  <h3 class="latest-news-title">
		                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
		                  </h3><!-- .latest-news-title -->

							<?php if ( false === $disable_date || ( false === $disable_comment && comments_open( get_the_ID() ) ) ) :  ?>
		                    <div class="latest-news-meta">

								<?php if ( false === $disable_date ) :  ?>
		                        <span class="latest-news-date"><?php the_time( get_option( 'date_format' ) ); ?></span><!-- .latest-news-date -->
								<?php endif ?>

								<?php if ( false === $disable_comment ) :  ?>
		                        <?php
		                        if ( comments_open( get_the_ID() ) ) {
									echo '<span class="latest-news-comments">';
									comments_popup_link( '<span class="leave-reply">' . __( 'No Comment', 'trade-line' ) . '</span>', __( '1 Comment', 'trade-line' ), __( '% Comments', 'trade-line' ) );
									echo '</span>';
		                        }
		                        ?>
								<?php endif ?>

		                    </div><!-- .latest-news-meta -->
							<?php endif ?>

							<?php if ( false === $disable_excerpt ) :  ?>
		                    <div class="latest-news-summary"><p><?php echo trade_line_the_excerpt( esc_attr( $excerpt_length ), $post ); ?></p></div><!-- .latest-news-summary -->
							<?php endif ?>
							<?php if ( false === $disable_more_text ) :  ?>
		                    <div class="latest-news-read-more"><a href="<?php the_permalink(); ?>" class="read-more" title="<?php the_title_attribute(); ?>"><?php echo esc_html( $more_text ); ?></a></div><!-- .latest-news-read-more -->
							<?php endif ?>
		                </div><!-- .latest-news-text-wrap -->
		                </div>
	                </div>

					<?php endforeach ?>

	            </div><!-- .row -->

	          </div><!-- .latest-news-widget -->

				<?php wp_reset_postdata(); // Reset ?>

	        <?php endif; ?>
	        <?php
	        echo $args['after_widget'];

	    }

	    function update( $new_instance, $old_instance ) {
	        $instance = $old_instance;

	        $instance['title']             = sanitize_text_field( $new_instance['title'] );
	        $instance['post_category']     = absint( $new_instance['post_category'] );
	        $instance['post_column']       = absint( $new_instance['post_column'] );
	        $instance['excerpt_length']    = absint( $new_instance['excerpt_length'] );
	        $instance['featured_image']    = esc_attr( $new_instance['featured_image'] );
	        $instance['disable_date']      = isset( $new_instance['disable_date'] );
	        $instance['disable_comment']   = isset( $new_instance['disable_comment'] );
	        $instance['disable_excerpt']   = isset( $new_instance['disable_excerpt'] );
	        $instance['disable_more_text'] = isset( $new_instance['disable_more_text'] );
	        $instance['more_text']         = sanitize_text_field( $new_instance['more_text'] );

	        return $instance;
	    }

	    function form( $instance ) {

	        // Defaults.
	        $instance = wp_parse_args( (array) $instance, array(
				'title'             => '',
				'post_category'     => '',
				'post_column'       => 4,
				'featured_image'    => 'medium',
				'excerpt_length'    => 40,
				'more_text'         => __( 'Read more', 'trade-line' ),
				'disable_date'      => 0,
				'disable_comment'   => 0,
				'disable_excerpt'   => 0,
				'disable_more_text' => 0,

	        ) );
	        $title             = esc_attr( $instance['title'] );
	        $post_category     = absint( $instance['post_category'] );
	        $post_column       = absint( $instance['post_column'] );
	        $featured_image    = esc_attr( $instance['featured_image'] );
	        $excerpt_length    = absint( $instance['excerpt_length'] );
	        $more_text         = sanitize_text_field( $instance['more_text'] );
	        $disable_date      = esc_attr( $instance['disable_date'] );
	        $disable_comment   = esc_attr( $instance['disable_comment'] );
	        $disable_excerpt   = esc_attr( $instance['disable_excerpt'] );
	        $disable_more_text = esc_attr( $instance['disable_more_text'] );

	        ?>
	        <p>
	          <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'trade-line' ); ?></label>
	          <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	        </p>
	        <p>
	          <label for="<?php echo  esc_attr( $this->get_field_id( 'post_category' ) ); ?>"><?php _e( 'Select Category:', 'trade-line' ); ?></label>
				<?php
	            $cat_args = array(
	                'orderby'         => 'name',
	                'hide_empty'      => 0,
	                'taxonomy'        => 'category',
	                'name'            => $this->get_field_name( 'post_category' ),
	                'id'              => $this->get_field_id( 'post_category' ),
	                'selected'        => $post_category,
	                'show_option_all' => __( 'All Categories','trade-line' ),
	              );
	            wp_dropdown_categories( $cat_args );
				?>
	        </p>
	        <p>
	          <label for="<?php echo esc_attr( $this->get_field_id( 'post_column' ) ); ?>"><?php _e( 'Number of Columns:', 'trade-line' ); ?></label>
				<?php
	            $this->dropdown_post_columns( array(
					'id'       => $this->get_field_id( 'post_column' ),
					'name'     => $this->get_field_name( 'post_column' ),
					'selected' => $post_column,
					)
	            );
				?>
	        </p>
	        <p>
	          <label for="<?php echo esc_attr( $this->get_field_id( 'featured_image' ) ); ?>"><?php _e( 'Select Image Size:', 'trade-line' ); ?></label>
				<?php
	            $this->dropdown_image_sizes( array(
					'id'       => $this->get_field_id( 'featured_image' ),
					'name'     => $this->get_field_name( 'featured_image' ),
					'selected' => $featured_image,
					)
	            );
				?>
	        </p>
	        <p>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>"><?php _e( 'Excerpt Length:', 'trade-line' ); ?></label>
	        	<input id="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_length' ) ); ?>" type="number" value="<?php echo esc_attr( $excerpt_length ); ?>" min="1" style="max-width:50px;" />&nbsp;<small><?php _e( 'in words', 'trade-line' ); ?></small>
	        </p>
	        <p>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'more_text' ) ); ?>"><?php _e( 'Read More Text:', 'trade-line' ); ?></label>
	        	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'more_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'more_text' ) ); ?>" type="text" value="<?php echo esc_attr( $more_text ); ?>" />
	        </p>
	        <p>
	        	<input id="<?php echo esc_attr( $this->get_field_id( 'disable_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_date' ) ); ?>" type="checkbox" <?php checked( isset( $instance['disable_date'] ) ? $instance['disable_date'] : 0 ); ?> />&nbsp;
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'disable_date' ) ); ?>"><?php _e( 'Disable Date in Post', 'trade-line' ); ?></label>
	        </p>
	        <p>
	        	<input id="<?php echo esc_attr( $this->get_field_id( 'disable_comment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_comment' ) ); ?>" type="checkbox" <?php checked( isset( $instance['disable_comment'] ) ? $instance['disable_comment'] : 0 ); ?> />&nbsp;
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'disable_comment' ) ); ?>"><?php _e( 'Disable Comment in Post', 'trade-line' ); ?></label>
	        </p>
	        <p>
	        	<input id="<?php echo esc_attr( $this->get_field_id( 'disable_excerpt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_excerpt' ) ); ?>" type="checkbox" <?php checked( isset( $instance['disable_excerpt'] ) ? $instance['disable_excerpt'] : 0 ); ?> />&nbsp;
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'disable_excerpt' ) ); ?>"><?php _e( 'Disable Post Excerpt', 'trade-line' ); ?></label>
	        </p>
	        <p>
	        	<input id="<?php echo esc_attr( $this->get_field_id( 'disable_more_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_more_text' ) ); ?>" type="checkbox" <?php checked( isset( $instance['disable_more_text'] ) ? $instance['disable_more_text'] : 0 ); ?> />&nbsp;
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'disable_more_text' ) ); ?>"><?php _e( 'Disable Read More Text', 'trade-line' ); ?></label>
	        </p>
	        <?php
	    }


	    function dropdown_post_columns( $args ) {
			$defaults = array(
	        'id'       => '',
	        'name'     => '',
	        'selected' => 0,
	        'echo'     => 1,
			);

			$r = wp_parse_args( $args, $defaults );
			$output = '';

			$choices = array(
			'3' => 3,
			'4' => 4,
			);

			if ( ! empty( $choices ) ) {

				$output = "<select name='" . esc_attr( $r['name'] ) . "' id='" . esc_attr( $r['id'] ) . "'>\n";
				foreach ( $choices as $key => $choice ) {
					$output .= '<option value="' . esc_attr( $key ) . '" ';
					$output .= selected( $r['selected'], $key, false );
					$output .= '>' . esc_html( $choice ) . '</option>\n';
				}
				$output .= "</select>\n";
			}

			if ( $r['echo'] ) {
				echo $output;
			}
			return $output;

	    }

	    function dropdown_image_sizes( $args ) {
			$defaults = array(
	        'id'       => '',
	        'name'     => '',
	        'selected' => 0,
	        'echo'     => 1,
			);

			$r = wp_parse_args( $args, $defaults );
			$output = '';

			$choices = trade_line_get_image_sizes_options( true, array( 'disable', 'thumbnail', 'medium' ), false );

			if ( ! empty( $choices ) ) {

				$output = "<select name='" . esc_attr( $r['name'] ) . "' id='" . esc_attr( $r['id'] ) . "'>\n";
				foreach ( $choices as $key => $choice ) {
					$output .= '<option value="' . esc_attr( $key ) . '" ';
					$output .= selected( $r['selected'], $key, false );
					$output .= '>' . esc_html( $choice ) . '</option>\n';
				}
				$output .= "</select>\n";
			}

			if ( $r['echo'] ) {
				echo $output;
			}
			return $output;

	    }
	}

endif;


if ( ! class_exists( 'Trade_Line_Services_Widget' ) ) :

	/**
	 * Service Widget Class
	 *
	 * @since 1.0.0
	 */
	class Trade_Line_Services_Widget extends WP_Widget {

		function __construct() {
			$opts = array(
					'classname'                   => 'trade_line_widget_services',
					'description'                 => __( 'Show your services with icon and read more link.', 'trade-line' ),
					'customize_selective_refresh' => true,
			  );
			parent::__construct( 'trade-line-services', __( 'Trade Line: Services', 'trade-line' ), $opts );
		}


		function widget( $args, $instance ) {

			$title             = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$excerpt_length    = ! empty( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 20;
			$more_text         = ! empty( $instance['more_text'] ) ? $instance['more_text'] : __( 'Read more', 'trade-line' );
			$disable_excerpt   = ! empty( $instance['disable_excerpt'] ) ? $instance['disable_excerpt'] : false ;
			$disable_more_text = ! empty( $instance['disable_more_text'] ) ? $instance['disable_more_text'] : false ;

			$block_page_1      = ! empty( $instance['block_page_1'] ) ? $instance['block_page_1'] : '';
			$block_icon_1      = ! empty( $instance['block_icon_1'] ) ? $instance['block_icon_1'] : 'fa-cogs';

			$block_page_2      = ! empty( $instance['block_page_2'] ) ? $instance['block_page_2'] : '';
			$block_icon_2      = ! empty( $instance['block_icon_2'] ) ? $instance['block_icon_2'] : 'fa-cogs';

			$block_page_3      = ! empty( $instance['block_page_3'] ) ? $instance['block_page_3'] : '';
			$block_icon_3      = ! empty( $instance['block_icon_3'] ) ? $instance['block_icon_3'] : 'fa-cogs';

			$block_page_4      = ! empty( $instance['block_page_4'] ) ? $instance['block_page_4'] : '';
			$block_icon_4      = ! empty( $instance['block_icon_4'] ) ? $instance['block_icon_4'] : 'fa-cogs';

			echo $args['before_widget'];

			// Title.
			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			// Arrange data.
			$service_arr = array();
			for ( $i = 0; $i < 4 ; $i++ ) {
				$block = ( $i + 1 );
				$service_arr[ $i ] = array(
				'page' => ${'block_page_' . $block},
				'icon' => ${'block_icon_' . $block},
				);
			}
			// Clean up data.
			$refined_arr = array();
			foreach ( $service_arr as $key => $item ) {
				if ( ! empty( $item['page'] ) && get_post( $item['page'] ) ) {
					$refined_arr[] = $item;
				}
			}

			// Render content
			if ( ! empty( $refined_arr ) ) {
				$extra_args = array(
				'excerpt_length'    => $excerpt_length,
				'more_text'         => $more_text,
				'disable_excerpt'   => $disable_excerpt,
				'disable_more_text' => $disable_more_text,
				);
				$this->render_widget_content( $refined_arr, $extra_args );
			}

			echo $args['after_widget'];

		}

		function render_widget_content( $service_arr, $args = array() ) {

			$service_column = count( $service_arr );

			?>
			<div class="service-block-list service-col-<?php echo esc_attr( $service_column ); ?>">
	    	<div calss="inner-wrapper">

		    	<?php foreach ( $service_arr as $key => $service ) :  ?>
		    		<?php $obj = get_post( $service['page'] ); ?>

		    		<div class="service-block-item">
		    			<div class="service-block-inner">

		    				<i class="<?php echo 'fa ' . esc_attr( $service['icon'] ); ?>"></i>
		    				<div class="service-block-inner-content">
		    					<h3 class="service-item-title">
		    						<a href="<?php echo esc_url( get_permalink( $obj->ID ) ); ?>">
		    							<?php echo esc_html( $obj->post_title ); ?>
		    						</a>
		    					</h3>
		    					<?php if ( true != $args['disable_excerpt'] ) :  ?>
		    						<div class="service-block-item-excerpt">
		    							<p><?php echo esc_html( trade_line_the_excerpt( $args['excerpt_length'], $obj ) ); ?></p>
		    						</div><!-- .service-block-item-excerpt -->
		    					<?php endif ?>

		    					<?php if ( true != $args['disable_more_text'] ) :  ?>
		    						<a href="<?php echo esc_url( get_permalink( $obj -> ID ) ); ?>" class="read-more"><?php echo esc_html( $args['more_text'] ); ?></a>
		    					<?php endif ?>

		    				</div><!-- .service-block-inner-content -->

		    			</div><!-- .service-block-inner -->
		    		</div><!-- .service-block-item -->

		    	<?php endforeach ?>
	    	</div>
	    </div><!-- .service-block-list -->

		<?php

		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title']             = sanitize_text_field( $new_instance['title'] );

			$instance['block_page_1']      = esc_html( $new_instance['block_page_1'] );
			$instance['block_icon_1']      = esc_attr( $new_instance['block_icon_1'] );

			$instance['block_page_2']      = esc_html( $new_instance['block_page_2'] );
			$instance['block_icon_2']      = esc_attr( $new_instance['block_icon_2'] );

			$instance['block_page_3']      = esc_html( $new_instance['block_page_3'] );
			$instance['block_icon_3']      = esc_attr( $new_instance['block_icon_3'] );

			$instance['block_page_4']      = esc_html( $new_instance['block_page_4'] );
			$instance['block_icon_4']      = esc_attr( $new_instance['block_icon_4'] );

			$instance['excerpt_length']    = absint( $new_instance['excerpt_length'] );
			$instance['disable_excerpt']   = isset( $new_instance['disable_excerpt'] );
			$instance['disable_more_text'] = isset( $new_instance['disable_more_text'] );
			$instance['more_text']         = sanitize_text_field( $new_instance['more_text'] );

			return $instance;
		}

		function form( $instance ) {

			// Defaults.
			$instance = wp_parse_args( (array) $instance, array(
				'title'             => '',

				'block_page_1'      => '',
				'block_icon_1'      => 'fa-cogs',

				'block_page_2'      => '',
				'block_icon_2'      => 'fa-cogs',

				'block_page_3'      => '',
				'block_icon_3'      => 'fa-cogs',

				'block_page_4'      => '',
				'block_icon_4'      => 'fa-cogs',

				'excerpt_length'    => 20,
				'more_text'         => __( 'Read more', 'trade-line' ),
				'disable_excerpt'   => 0,
				'disable_more_text' => 0,

			) );
			$title             = esc_attr( $instance['title'] );

			$block_page_1      = esc_html( $instance['block_page_1'] );
			$block_icon_1      = esc_attr( $instance['block_icon_1'] );

			$block_page_2      = esc_html( $instance['block_page_2'] );
			$block_icon_2      = esc_attr( $instance['block_icon_2'] );

			$block_page_3      = esc_html( $instance['block_page_3'] );
			$block_icon_3      = esc_attr( $instance['block_icon_3'] );

			$block_page_4      = esc_html( $instance['block_page_4'] );
			$block_icon_4      = esc_attr( $instance['block_icon_4'] );

			$excerpt_length    = absint( $instance['excerpt_length'] );
			$more_text         = esc_attr( $instance['more_text'] );
			$disable_excerpt   = esc_attr( $instance['disable_excerpt'] );
			$disable_more_text = esc_attr( $instance['disable_more_text'] );

			?>
		  <p>
        	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'trade-line' ); ?></label>
        	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
        	<label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>"><?php _e( 'Excerpt Length:', 'trade-line' ); ?></label>
        	<input id="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_length' ) ); ?>" type="number" value="<?php echo esc_attr( $excerpt_length ); ?>" min="1" style="max-width:50px;" />&nbsp;<small><?php _e( 'in words', 'trade-line' ); ?></small>
        </p>
        <p>
        	<input id="<?php echo esc_attr( $this->get_field_id( 'disable_excerpt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_excerpt' ) ); ?>" type="checkbox" <?php checked( isset( $instance['disable_excerpt'] ) ? $instance['disable_excerpt'] : 0 ); ?> />&nbsp;
        	<label for="<?php echo esc_attr( $this->get_field_id( 'disable_excerpt' ) ); ?>"><?php _e( 'Disable Excerpt', 'trade-line' ); ?></label>
    	</p>
    	<p>
	    	<label for="<?php echo esc_attr( $this->get_field_id( 'more_text' ) ); ?>"><?php _e( 'Read More Text:', 'trade-line' ); ?></label>
	    	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'more_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'more_text' ) ); ?>" type="text" value="<?php echo esc_attr( $more_text ); ?>" />
    	</p>

    	<p>
	    	<input id="<?php echo esc_attr( $this->get_field_id( 'disable_more_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'disable_more_text' ) ); ?>" type="checkbox" <?php checked( isset( $instance['disable_more_text'] ) ? $instance['disable_more_text'] : 0 ); ?> />&nbsp;
	    	<label for="<?php echo esc_attr( $this->get_field_id( 'disable_more_text' ) ); ?>"><?php _e( 'Disable Read More Text', 'trade-line' ); ?></label>
		</p>

		<hr style="border-top:2px #aaa solid;" />
		<h4 class="block-heading"><?php printf( __( 'Block %d','trade-line' ), 1 ); ?></h4>
		<p>
			<label for="<?php echo $this->get_field_id( 'block_page_1' ); ?>"><?php _e( 'Page:', 'trade-line' ); ?></label>
			<?php
			wp_dropdown_pages( array(
				'id'               => $this->get_field_id( 'block_page_1' ),
				'name'             => $this->get_field_name( 'block_page_1' ),
				'selected'         => $block_page_1,
				'show_option_none' => __( '&mdash; Select &mdash;', 'trade-line' ),
				)
			);
			?>
		  </p>
		  <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'block_icon_1' ) ); ?>"><?php _e( 'Icon:', 'trade-line' ); ?></label>
			<input  id="<?php echo esc_attr( $this->get_field_id( 'block_icon_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'block_icon_1' ) ); ?>" type="text" value="<?php echo esc_attr( $block_icon_1 ); ?>" style="max-width:100px;" />&nbsp;<em><?php _e( 'eg: fa-cogs', 'trade-line' ); ?>&nbsp;<a href="<?php echo esc_url( 'http://fontawesome.io/cheatsheet/' ); ?>" target="_blank" title="<?php _e( 'View Reference', 'trade-line' ); ?>"><?php _e( 'Reference', 'trade-line' ); ?></a></em>
		  </p>

		  <h4 class="block-heading"><?php printf( __( 'Block %d','trade-line' ), 2 ); ?></h4>
		  <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'block_page_2' ) ); ?>"><?php _e( 'Page:', 'trade-line' ); ?></label>
			<?php
			wp_dropdown_pages( array(
				'id'               => $this->get_field_id( 'block_page_2' ),
				'name'             => $this->get_field_name( 'block_page_2' ),
				'selected'         => $block_page_2,
				'show_option_none' => __( '&mdash; Select &mdash;', 'trade-line' ),
				)
			);
			?>

		  </p>
		  <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'block_icon_2' ) ); ?>"><?php _e( 'Icon:', 'trade-line' ); ?></label>
			<input  id="<?php echo esc_attr( $this->get_field_id( 'block_icon_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'block_icon_2' ) ); ?>" type="text" value="<?php echo esc_attr( $block_icon_2 ); ?>"  style="max-width:100px;" />&nbsp;<em><?php _e( 'eg: fa-cogs', 'trade-line' ); ?>&nbsp;<a href="<?php echo esc_url( 'http://fontawesome.io/cheatsheet/' ); ?>" target="_blank" title="<?php _e( 'View Reference', 'trade-line' ); ?>"><?php _e( 'Reference', 'trade-line' ); ?></a></em>
		  </p>

		  <h4 class="block-heading"><?php printf( __( 'Block %d','trade-line' ), 3 ); ?></h4>
		  <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'block_page_3' ) ); ?>"><?php _e( 'Page:', 'trade-line' ); ?></label>
			<?php
			wp_dropdown_pages( array(
				'id'               => $this->get_field_id( 'block_page_3' ),
				'name'             => $this->get_field_name( 'block_page_3' ),
				'selected'         => $block_page_3,
				'show_option_none' => __( '&mdash; Select &mdash;', 'trade-line' ),
				)
			);
			?>

		  </p>
		  <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'block_icon_3' ) ); ?>"><?php _e( 'Icon:', 'trade-line' ); ?></label>
			<input  id="<?php echo esc_attr( $this->get_field_id( 'block_icon_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'block_icon_3' ) ); ?>" type="text" value="<?php echo esc_attr( $block_icon_3 ); ?>"  style="max-width:100px;" />&nbsp;<em><?php _e( 'eg: fa-cogs', 'trade-line' ); ?>&nbsp;<a href="<?php echo esc_url( 'http://fontawesome.io/cheatsheet/' ); ?>" target="_blank" title="<?php _e( 'View Reference', 'trade-line' ); ?>"><?php _e( 'Reference', 'trade-line' ); ?></a></em>
		  </p>

		  <h4 class="block-heading"><?php printf( __( 'Block %d','trade-line' ), 4 ); ?></h4>
		  <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'block_page_4' ) ); ?>"><?php _e( 'Page:', 'trade-line' ); ?></label>
			<?php
			wp_dropdown_pages( array(
				'id'               => $this->get_field_id( 'block_page_4' ),
				'name'             => $this->get_field_name( 'block_page_4' ),
				'selected'         => $block_page_4,
				'show_option_none' => __( '&mdash; Select &mdash;', 'trade-line' ),
				)
			);
			?>

		  </p>
		  <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'block_icon_4' ) ); ?>"><?php _e( 'Icon:', 'trade-line' ); ?></label>
			<input  id="<?php echo esc_attr( $this->get_field_id( 'block_icon_4' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'block_icon_4' ) ); ?>" type="text" value="<?php echo esc_attr( $block_icon_4 ); ?>"  style="max-width:100px;" />&nbsp;<em><?php _e( 'eg: fa-cogs', 'trade-line' ); ?>&nbsp;<a href="<?php echo esc_url( 'http://fontawesome.io/cheatsheet/' ); ?>" target="_blank" title="<?php _e( 'View Reference', 'trade-line' ); ?>"><?php _e( 'Reference', 'trade-line' ); ?></a></em>
		  </p>

			<?php
		}
	}

endif;


if ( ! class_exists( 'Trade_Line_Teams_Widget' ) ) :

	/**
	 * Teams  Widget Class
	 *
	 * @since 1.0.0
	 */
	class Trade_Line_Teams_Widget extends WP_Widget {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
	    function __construct() {
	    	$opts = array(
				'classname'                   => 'trade_line_widget_teams',
				'description'                 => __( 'Teams widget', 'trade-line' ),
				'customize_selective_refresh' => true,
			);
			parent::__construct( 'trade-line-teams', esc_html__( 'Trade Line: Teams', 'trade-line' ), $opts );
	    }

	    /**
	     * Echo the widget content.
	     *
	     * @since 1.0.0
	     *
	     * @param array $args     Display arguments including before_title, after_title,
	     *                        before_widget, and after_widget.
	     * @param array $instance The settings for the particular instance of the widget.
	     */
	    function widget( $args, $instance ) {

			$title           = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$post_category   = ! empty( $instance['post_category'] ) ? $instance['post_category'] : 0;
			$teams_column    = ! empty( $instance['teams_column'] ) ?  $instance['teams_column'] : 4 ;
			$excerpt_length  = ! empty( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 20;
			$number_of_teams = ! empty( $instance['number_of_teams'] ) ? $instance['number_of_teams'] : 4;

	        echo $args['before_widget'];

	        // Title.
	        if ( $title ) {
	        	echo $args['before_title'] . $title . $args['after_title'];
	        }
	        ?>
	        <?php
	        $qargs = array(
				'no_found_rows'  => true,
				'meta_key'       => '_thumbnail_id',
				'posts_per_page' => esc_attr( $number_of_teams ),
			);
	        if ( absint( $post_category ) > 0  ) {
	        	$qargs['category'] = absint( $post_category );
	        }

	        $all_posts = get_posts( $qargs );
	        ?>
	        <?php if ( ! empty( $all_posts ) ) :  ?>

			<?php global $post; ?>

			<div class="our-team-widget our-team-col-<?php echo esc_attr( $teams_column ); ?>">
				<div class="inner-wrapper">

					<?php foreach ( $all_posts as $key => $post ) :  ?>
						<?php setup_postdata( $post ); ?>
						<div class="our-team-item">
							<?php if ( has_post_thumbnail() ) :  ?>
								<div class="thumb-summary-wrap">
									<div class="our-team-thumb">
										<a href="<?php the_permalink(); ?>">
											<?php
											the_post_thumbnail( 'medium', array( 'class' => 'aligncenter' ) );
											?>
										</a>

									</div><!-- .our-team-item-->
								<div class="our-team-summary"><p><?php echo trade_line_the_excerpt( esc_attr( $excerpt_length ), $post ); ?></p></div><!-- .latest-news-summary -->
								</div><!-- .thumb-summary-wrap -->
							<?php endif ?>
							<div class="our-team-text-wrap">
								<h3 class="our-team-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
								<div class="team-designation">
									<?php
									$posttags = get_the_tags();
									if ( $posttags ) {
										echo $posttags[0]->name;
									}
									?>
								</div>
							</div><!-- .our-team-text-wrap -->
						</div>

					<?php endforeach ?>
				</div><!-- .inner-wrapper -->
			</div><!-- .our-team-widget -->

			<?php wp_reset_postdata(); ?>

	        <?php endif; ?>
	        <?php
	        echo $args['after_widget'];

	    }

	    /**
	     * Update widget instance.
	     *
	     * @since 1.0.0
	     *
	     * @param array $new_instance New settings for this instance as input by the user via
	     *                            {@see WP_Widget::form()}.
	     * @param array $old_instance Old settings for this instance.
	     * @return array Settings to save or bool false to cancel saving.
	     */
	    function update( $new_instance, $old_instance ) {
	        $instance = $old_instance;

			$instance['title']           = sanitize_text_field( $new_instance['title'] );
			$instance['post_category']   = absint( $new_instance['post_category'] );
			$instance['excerpt_length']  = absint( $new_instance['excerpt_length'] );
			$instance['teams_column']    = absint( $new_instance['teams_column'] );
			$instance['number_of_teams'] = absint( $new_instance['number_of_teams'] );

	        return $instance;
	    }

	    /**
	     * Output the settings update form.
	     *
	     * @since 1.0.0
	     *
	     * @param array $instance Current settings.
	     */
	    function form( $instance ) {

	        // Defaults.
	        $instance = wp_parse_args( (array) $instance, array(
				'title'           => '',
				'post_category'   => '',
				'teams_column'    => 4,
				'excerpt_length'  => 20,
				'number_of_teams' => 4,
	        ) );

			$title           = esc_attr( $instance['title'] );
			$post_category   = absint( $instance['post_category'] );
			$excerpt_length  = absint( $instance['excerpt_length'] );
			$teams_column    = esc_attr( $instance['teams_column'] );
			$number_of_teams = esc_attr( $instance['number_of_teams'] );

	        ?>
	        <p>
	          <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'trade-line' ); ?></label>
	          <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	        </p>
	        <p>
	          <label for="<?php echo $this->get_field_id( 'post_category' ); ?>"><?php _e( 'Select Category:', 'trade-line' ); ?></label>
				<?php
				$cat_args = array(
					'orderby'         => 'name',
					'hide_empty'      => 0,
					'taxonomy'        => 'category',
					'name'            => $this->get_field_name( 'post_category' ),
					'id'              => $this->get_field_id( 'post_category' ),
					'selected'        => $post_category,
					'show_option_all' => __( 'All Categories','trade-line' ),
				);
				wp_dropdown_categories( $cat_args );
				?>
	        </p>
	        <p>
				<label for="<?php echo $this->get_field_id( 'teams_column' ); ?>"><?php esc_html_e( 'Number of Columns', 'trade-line' ); ?>
					<select id="<?php echo esc_attr( $this->get_field_id( 'teams_column' ) ); ?>" name="<?php echo $this->get_field_name( 'teams_column' ); ?>" >
						<option value="3" <?php selected( $teams_column, 3 ); ?>><?php echo sprintf( __( ' %d Columns', 'trade-line' ), 3 )?></option>
						<option value="4" <?php selected( $teams_column, 4 ); ?>><?php echo sprintf( __( ' %d Columns', 'trade-line' ), 4 )?></option>
					</select>
				</label>
			</p>

			<p>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'number_of_teams' ) ); ?>"><?php _e( 'Number of posts to display', 'trade-line' ); ?></label>
	        	<input id="<?php echo esc_attr( $this->get_field_id( 'number_of_teams' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number_of_teams' ) ); ?>" type="number" value="<?php echo esc_attr( $number_of_teams ); ?>" min="1" style="max-width:50px;" />&nbsp;<small><?php _e( 'in number', 'trade-line' ); ?></small>
	        </p>

	        <p>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>"><?php _e( 'Excerpt Length:', 'trade-line' ); ?></label>
	        	<input id="<?php echo esc_attr( $this->get_field_id( 'excerpt_length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt_length' ) ); ?>" type="number" value="<?php echo esc_attr( $excerpt_length ); ?>" min="1" style="max-width:50px;" />&nbsp;<small><?php _e( 'in number', 'trade-line' ); ?></small>
	        </p>

	        <?php
	    }
	}

endif;
