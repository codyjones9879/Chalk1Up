<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="wrapper" class="clearfix" > 
<div id="maincol" >





<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


<h2 class="contentheader"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

<?php the_content('<p>Read more &raquo;</p>'); ?>


<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
<div id="postinfotext">
Author: <?php the_author_posts_link(); ?><br/>
Posted: <?php the_time('F jS, Y') ?><br/>
Categories: <?php the_category(', ') ?><br/>
Tags: <?php the_tags(''); ?><br/>
Comments: <a href="<?php comments_link(); ?>"><?php comments_number('No Comments','1 Comment','% Comments'); ?></a>.
</div>


<?php comments_template(); ?>

<?php endwhile; else: ?>
<p>No matching entries found.</p>
<?php endif; ?>


</div>
</div>

<?php get_footer(); ?>