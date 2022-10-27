<?php get_header(); ?>
<div id="primary" class="content-area overflow-hidden">
<main id="main" class="site-main" role="main">
    <section class="content_gutenberg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php the_content();?>
                </div>
            </div>
        </div>
    </section>
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-12">
                <?php while( have_rows('hero')): the_row(); ?>
                    <div class="hero-top">
                        <h2 class="hero-top__title">
                            <?php if(get_sub_field('title')): echo get_sub_field('title') ;endif?>
                        </h2>
                        <p class="hero-top__text">
                            <?php if(get_sub_field('text')): echo get_sub_field('text') ;endif?>
                        </p>
                    </div>
                    <div class="hero-bottom">
                        <h2 class="hero-bottom__title"></h2>
                        <div class="hero-bottom-services">
                        <?php while( have_rows('services')): the_row(); 
                                $image = get_sub_field('image');
                                $title = get_sub_field('title');
                                $text = get_sub_field('text');
                                ?>
                                <div class="hero-bottom-services-single">
                                    <div class="hero-bottom-services-single-content">
                                        <h2 class="hero-bottom-services-single-content__title">
                                            <?php echo $title;?>
                                        </h2>
                                        <p class="hero-bottom-services-single-content__text">
                                            <?php echo $text;?>
                                        </p>
                                        <?php if($image) :?>
                                            <img src="<?php echo $image;?>" alt="" class="hero-bottom-services-single-content__img">
                                        <?php endif;?>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </section>
  


<?php get_footer(); ?>



