<?php if (!empty(get_sub_field('cta'))) : ?>
    <div class="btn-container">
        <?php 
            $CTA_URL = (!empty(get_sub_field('cta_link')) ? get_sub_field('cta_link') : get_sub_field('external_link'));
        ?>
        <a class="btn-alt" data-text="<?php the_sub_field('cta'); ?>" href="<?php echo $CTA_URL; ?>"><span><?php the_sub_field('cta'); ?></span></a>
    </div>
<?php endif; ?>