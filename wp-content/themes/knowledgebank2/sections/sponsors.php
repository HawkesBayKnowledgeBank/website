<section class="layer logos">
    <div class="inner">
        <div class="section-header center">
            <h4>Sponsors &amp; Supporters</h4>
            <p>We'd like to thank the following businesses and organisations for their support.</p>
        </div>
        <div class="grid">
            <?php
                $fid = get_option('page_on_front');
                $sponsors = get_field('sponsors', $fid);
            ?>
            <?php if(!empty($sponsors)): ?>
                <?php foreach($sponsors as $sponsor):  ?>
                        <?php if(!empty($sponsor['link'])): ?>
                            <a href="<?php echo $sponsor['link']; ?>">
                                <img src="<?php echo $sponsor['logo']['url']; ?>" alt="<?php echo $sponsor['logo']['alt']; ?>" />
                            </a>
                        <?php else: ?>
                            <span>
                                <img src="<?php echo $sponsor['logo']['url']; ?>" alt="<?php echo $sponsor['logo']['alt']; ?>" />
                            </span>
                        <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
