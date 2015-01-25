<!-- Post #1 -->
<div class="one-third column masonry-item">
  <article id="post-<?php the_ID(); ?>" <?php post_class('from-the-blog'); ?>>
   <div class="embed">
    <?php
      $video = get_post_meta($post->ID, '_format_video_embed', true);
      if(wp_oembed_get($video)) { echo wp_oembed_get($video); } else { echo $video;}
    ?>
  </div>
    <section class="from-the-blog-content">
      <a href="<?php the_permalink(); ?>"><h5><?php the_title(); ?></h5></a>
      <i><?php echo __('By','trizzy'). ' <a class="author-link" itemprop="url" rel="author" href="'.get_author_posts_url(get_the_author_meta('ID' )).'">'; the_author_meta('display_name'); echo'</a>'; echo ' '; _e('on','trizzy');  echo ' '; echo get_the_date(); ?></i>
      <span>
        <?php
        $excerpt = get_the_excerpt();
        $limit = ot_get_option('pp_masonry_excerpt',20);
        $short_excerpt = string_limit_words($excerpt,$limit);
        echo $short_excerpt.'..';
        ?>
      </span>
      <a href="<?php the_permalink(); ?>" class="button gray"><?php _e('Read More','trizzy') ?></a>
    </section>

  </article>
</div>




