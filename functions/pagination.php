<?php
function the_pagination() {
        global $wp_query;
        $big = 999999999;
        $links = paginate_links(array(
            'base' => str_replace($big,'%#%',esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'type' => 'array',
            'prev_text'    => '«',
            'next_text'    => '»',
            'total' => $wp_query->max_num_pages,
            'show_all'     => false,
            'end_size'     => false,
            'mid_size'     => 1,
            'add_args'     => false,
            'add_fragment' => '',
            'before_page_number' => '',
            'after_page_number' => ''
        ));

		if( is_array( $links ) ) {
            echo '<div class="blog-pagination text-center"><ul>';
            foreach ( $links as $link ) {
                if ( strpos( $link, 'current' ) !== false ) echo "<li>".$link."</li>";
                else echo "<li>".$link."</li>";
            }
            echo '</ul></div>';
		}
    }
