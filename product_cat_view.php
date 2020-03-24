<?php
$prod_cat_args = array(
    'taxonomy'    => 'product_cat',
    'orderby'     => 'id', // здесь по какому полю сортировать
    'hide_empty'  => false, // скрывать категории без товаров или нет
    'parent'      => 0 // id родительской категории
  );

$woo_categories = get_categories( $prod_cat_args );
  foreach ( $woo_categories as $woo_cat ) {
      $woo_cat_id = $woo_cat->term_id; //category ID
      $woo_cat_name = $woo_cat->name; //category name
      $woo_cat_slug = $woo_cat->slug; //category slug
      $category_thumbnail_id = get_woocommerce_term_meta($woo_cat_id, 'thumbnail_id', true);
      $thumbnail_image_url = wp_get_attachment_url($category_thumbnail_id);
      echo '<img src="' . $thumbnail_image_url . '"/>';
      echo '<h2>';
      echo '<a href="' . get_term_link( $woo_cat_id, 'product_cat' ) . '">' . $woo_cat_name . '</a>';
      echo '</h2>';
      echo "</div>\n";
  }

