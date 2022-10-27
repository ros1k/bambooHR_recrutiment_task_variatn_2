<?php get_header(); ?>
    <div id="primary" class="content-area">
    <?php include 'partials/page-header.php';?>
    <main id="main" class="site-main" role="main">
        <div class="container">
            <div class="row">
                <div class="col-12 py-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="site-content">
                                <?php
                                if (have_posts()) :
                                    while (have_posts()) :
                                        the_post();
                                        the_content();
                                    endwhile;
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
wp_reset_query();
get_footer();
