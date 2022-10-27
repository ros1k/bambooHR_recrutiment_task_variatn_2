<?php
function custom_breadcrumbs()
{

    $separator = '<i class="fa fa-angle-right"></i>';
    $breadcrumbs_id = 'breadcrumbs';
    $breadcrumbs_class = 'breadcrumbs d-lg-flex justify-content-start align-items-baseline mb-0';
    $home_title = get_bloginfo('name');
    $custom_taxonomy = 'product_cat';
    global $post, $wp_query;
    if (!is_front_page()) {
        echo '<div class="breadcrumbs-holder">';
        echo '<div class="container px-0">';
        echo '<ul id="' . $breadcrumbs_id . '" class="' . $breadcrumbs_class . '">';
        echo '<li class="item-home"><a class="bread-link nice-link white-color bread-home" href="' . get_home_url() . '" title="' . $home_title . '"><i class="icon-home"></i>' . Start . '</a></li>';
        echo '<li class="separator mx-2 separator-home"> ' . $separator . ' </li>';
        if (is_archive() && !is_tax() && !is_category() && !is_tag() && !is_author() && !is_day() && !is_month() && !is_year()) {
            echo '<li class="item-current item-archive"><h2 class="bread-current bread-archive">' . post_type_archive_title('', false) . '</h2></li>';
        } else if (is_archive() && is_tax() && !is_category() && !is_tag()) {
            $post_type = get_post_type();
            if ($post_type != 'post') {


                $taxObj = get_taxonomy(get_queried_object()->taxonomy);
                $post_type_custom = $taxObj->object_type[0];
                $get_singular = get_post_type_object($post_type_custom);
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type_custom);
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat nice-link white-color bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $get_singular->label . '">' . $get_singular->label . '</a></li>';
                echo '<li class="separator mx-3"> ' . $separator . ' </li>';
            }
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><h2 class="bread-current bread-archive">' . $custom_tax_name . '</h2></li>';


        } else if (is_single()) {
            $post_type = get_post_type();
            if ($post_type != 'post') {
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat nice-link white-color bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator mx-3"> ' . $separator . ' </li>';
            }
            $category = get_the_category();
            if (!empty($category)) {
                $last_category = end(array_values($category));
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','), ',');
                $cat_parents = explode(',', $get_cat_parents);
                $cat_display = '';
                foreach ($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">' . $parents . '</li>';
                    $cat_display .= '<li class="separator mx-3"> ' . $separator . ' </li>';
                }
            }
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if (empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

                $taxonomy_terms = get_the_terms($post->ID, $custom_taxonomy);
                $cat_id = $taxonomy_terms[0]->term_id;
                $cat_nicename = $taxonomy_terms[0]->slug;
                $cat_link = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name = $taxonomy_terms[0]->name;
            }
            if (!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><h2 class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';
            } else if (!empty($cat_id)) {
                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat nice-link white-color bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator mx-3"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><h2 class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';
            } else {
                echo '<li class="item-current item-' . $post->ID . '"><h2 class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';
            }
        } else if (is_category()) {
            echo '<li class="item-current item-cat"><h2 class="bread-current bread-cat">Kategoria: ' . single_cat_title('', false) . '</h2></li>';
        } else if (is_page()) {
            if ($post->post_parent) {
                $anc = get_post_ancestors($post->ID);
                $anc = array_reverse($anc);
                if (!isset($parents)) $parents = null;
                foreach ($anc as $ancestor) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent nice-link white-color bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator mx-3 separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }
                echo $parents;
                echo '<li class="item-current item-' . $post->ID . '"><span title="' . get_the_title() . '"> ' . get_the_title() . '</span></li>';
            } else {
                echo '<li class="item-current item-' . $post->ID . '"><h2 class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</span></li>';

            }

        } else if (is_tag()) {

            $term_id = get_query_var('tag_id');
            $taxonomy = 'post_tag';
            $args = 'include=' . $term_id;
            $terms = get_terms($taxonomy, $args);
            $get_term_id = $terms[0]->term_id;
            $get_term_slug = $terms[0]->slug;
            $get_term_name = $terms[0]->name;
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><span class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">tag: ' . $get_term_name . '</span></li>';

        } elseif (is_day()) {

            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year nice-link white-color bread-year-' . get_the_time('Y') . '" href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' </a></li>';
            echo '<li class="separator mx-3 separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month nice-link white-color bread-month-' . get_the_time('m') . '" href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '" title="' . get_the_time('M') . '">' . get_the_time('m') . ' </a></li>';
            echo '<li class="separator mx-3 separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
            echo '<li class="item-current item-' . get_the_time('d') . '"><span class="bread-current bread-' . get_the_time('d') . '"> ' . get_the_time('d') . '</span></li>';

        } else if (is_month()) {
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year nice-link white-color bread-year-' . get_the_time('Y') . '" href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' </a></li>';
            echo '<li class="separator mx-3 separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><span class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('m') . ' </span></li>';

        } else if (is_year()) {
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><span class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' </span></li>';

        } else if ($wp_query->query_vars['author']) {
            global $author;
            $userdata = get_userdata($author);
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><span class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Autor: ' . $userdata->display_name . '</span></li>';

        } else if (get_query_var('paged')) {
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><span class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">' . __('Page') . ' ' . get_query_var('paged') . '</span></li>';

        } else if (is_search()) {
            echo '<li class="item-current item-current-' . get_search_query() . '"><span class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Wyniki wyszukiwania dla: ' . get_search_query() . '</span></li>';

        } elseif (is_404()) {
            echo '<li>' . 'Błąd 404' . '</li>';
        }
        echo '</ul>';
        echo '</div>';
        echo '</div>';
    }
}