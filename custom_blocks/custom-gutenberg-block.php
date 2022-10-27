<?php

$id = 'gutenberg-slider-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'gutenberg-slider';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
if( $is_preview ) {
    $className .= ' is-admin';
}

?>


<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="gutenberg-slider__header">
        <?php if(get_field('title')): ?>
            <h1 class="title"><?php the_field('title')?></h1>
        <?php endif;?>
        <?php if(get_field('text')):?>
            <p class="text"><?php the_field('text')?></p>
        <?php endif;?>
    </div>
    <div class="gutenberg-slider__wrapper">
        <?php if( have_rows('slider') ): ?>
            <div class="slides">
                <?php while( have_rows('slider') ): the_row(); ?>
                    <div class="slide box">
                        <div class="slide-content box-content">
                            <h2 class="slide-content__title box-content__title">
                                <?php echo get_sub_field('title');?>
                            </h2>
                            <p class="slide-content__text box-content__text">
                                <?php echo get_sub_field('text')?>
                            </p>
                            <?php if(get_sub_field('image')) :?>
                                <img src="<?php echo get_sub_field('image')?>" alt="" class="slide-content__img box-content__image">
                            <?php endif;?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>Please add some slides.</p>
        <?php endif; ?>
    </div>
</div> 