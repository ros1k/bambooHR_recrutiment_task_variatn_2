<div class="page-header d-flex justify-content-start align-items-center dark-header" style="background-image: url(
<?php if (is_archive()): the_field('page-header-bg', 'option');
elseif (is_home()):
    the_field('page-header-bg', get_option( 'page_for_posts' ));
else:
    if (get_field('page-header-bg')):
        the_field('page-header-bg');
    else:
        the_post_thumbnail_url();
    endif;
endif; ?>);">
    <div class="container-fluid py-5">
        <h1 class="page-header-title">
            <?php
            if (is_archive() && !is_tag() && !is_date()):
                echo post_type_archive_title( '', false );
            elseif (is_tag()):
                echo single_tag_title();
            elseif (is_date()):
                if (is_month()):
                    echo single_month_title(' ', true);
                elseif (is_year()):
                    echo get_the_date('Y');
                endif;
            elseif (is_home()):
                echo wp_title('');
            else:
                the_title();
            endif;
            ?>
        </h1>
        <?php
        require_once 'breadcrumbs.php';
        if (!is_home()):
            echo custom_breadcrumbs();
        endif;
        ?>

    </div>
</div>