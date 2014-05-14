<?php get_header(); ?>

    <?php if ( have_posts() ) : ?>


        <?php /* Start the Loop */ ?>
        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="section-header travel-container">
                    <?php the_title( '<h2>', '</h2>' ); ?>
                    <div class="col-1-5">
                        <time class="entry-date published" datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); ?></time>
                    </div>
                </header><!-- .section-header -->
                
                <?php if($content = get_the_content()) : ?>
                <div class="travel-content-row travel-container">
                    <div class="col-3-5 text-one-col">
                        <?php the_content(); ?>

                        <?php if(is_main_site()) : ?>
                            <?php if($site_list = get_blog_list( 0, 'all' ) ) : ?>
                                <ul id="site-selector">
                                <?php foreach ($site_list as $site) : ?>
                                    <?php if($site['path'] !== '/') : ?>
                                        <?php $site_info = get_blog_details($site["blog_id"]); ?>
                                        <li><a href="<?php echo $site_info->siteurl; ?>"><?php echo $site_info->blogname; ?></a></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if( have_rows('travel_rows') ): ?>
                    <?php while ( have_rows('travel_rows') ) : the_row(); ?>
                        <div class="travel-content-row">
                        <?php if(get_sub_field('travel_row_type') === "images" ) : ?>

                            <?php $the_images = get_sub_field('travel_images'); ?>
                            <?php // if there's only one image and it's full width ?>
                            <?php if(count($the_images) == 1 && $the_images[0]['travel_image_size'] === "fullwidth" ) : ?>
                                <?php while(have_rows('travel_images')) : the_row(); ?>
                                    <div class="image-container <?php the_sub_field('travel_image_size') ?>">
                                        <img src="<?php the_sub_field('travel_image'); ?>">
                                    </div>
                                <?php endwhile; ?>

                            <?php else : ?>
                                <div class="travel-container">
                                <?php while(have_rows('travel_images')) : the_row(); ?>
                                    <?php $row_size = get_sub_field('travel_image_size'); ?>
                                    <?php if(get_sub_field('travel_image_caption') && get_sub_field('travel_image')) : ?>
                                        <?php if($row_size == 'col-3-5') : ?>
                                            <div class="col-1-5">
                                                <div class="row-caption">
                                                    <?php the_sub_field('travel_image_caption'); ?>
                                                </div>
                                            </div>
                                            <div class="col-2-5">
                                                <div class="image-container">
                                                    <img src="<?php the_sub_field('travel_image'); ?>">
                                                </div>
                                            </div>
                                        <?php elseif($row_size == 'col-4-5') : ?>
                                            <div class="col-1-5">
                                                <div class="row-caption">
                                                    <?php the_sub_field('travel_image_caption'); ?>
                                                </div>
                                            </div>
                                            <div class="col-3-5">
                                                <div class="image-container">
                                                    <img src="<?php the_sub_field('travel_image'); ?>">
                                                </div>
                                            </div>
                                        <?php elseif($row_size == 'col-5-5') : ?>
                                            <div class="col-2-5">
                                                <div class="row-caption">
                                                    <?php the_sub_field('travel_image_caption'); ?>
                                                </div>
                                            </div>
                                            <div class="col-3-5">
                                                <div class="image-container">
                                                    <img src="<?php the_sub_field('travel_image'); ?>">
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <div class="<?php echo $row_size; ?>">
                                                <div class="image-container">
                                                    <img src="<?php the_sub_field('travel_image'); ?>">
                                                </div>
                                                <div class="row-caption">
                                                    <?php the_sub_field('travel_image_caption'); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php elseif(get_sub_field('travel_image')) : ?>
                                        <div class="<?php echo $row_size; ?>">
                                            <div class="image-container">
                                                <img src="<?php the_sub_field('travel_image'); ?>">
                                            </div>
                                        </div>
                                    <?php elseif(get_sib_field('travel_image_caption')) : ?>
                                        <div class="<?php echo $row_size; ?>">
                                            <div class="row-caption">
                                                <?php the_sub_field('travel_image_caption'); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                <?php endwhile; ?>
                                </div>
                            <?php endif; ?>
                            
                        <?php else : ?>
                            <div class="travel-container">
                                <div class="col-3-5 text-one-col">
                                    <?php the_sub_field('travel_text'); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>



            </article><!-- #post-## -->

        <?php endwhile; ?>

    <?php else : ?>

        <?php get_template_part( 'content', 'none' ); ?>

    <?php endif; ?>

<?php get_footer(); ?>
