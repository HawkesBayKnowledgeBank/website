<section class="layer commenting-wrap">
    <div class="inner">
        <div class="commenting">
            <h4>Do you know something about this record?</h4>
            <p>Please note we cannot verify the accuracy of any information posted by the community.</p>
            <div id="disqus_thread"></div>
            <script>
                /**
                 *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT
                 *  THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR
                 *  PLATFORM OR CMS.
                 *
                 *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT:
                 *  https://disqus.com/admin/universalcode/#configuration-variables
                 */

                var disqus_config = function () {
                    // Replace PAGE_URL with your page's canonical URL variable
                    //this.page.url = https://knowledgebank.org.nz/<?php echo get_field('accession_number'); ?>;

                    // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                    <?php
                        $identifier = get_post_meta($post->ID, '_drupal_nid', true);
                        if(empty($identifier)) $identifier = $post->ID;
                    ?>
                    this.page.identifier = 'node/<?php echo $identifier; ?>';
                };


                (function() {  // REQUIRED CONFIGURATION VARIABLE: EDIT THE SHORTNAME BELOW
                    var d = document, s = d.createElement('script');

                    s.src = 'https://hawkesbayknowledgebank.disqus.com/embed.js';

                    s.setAttribute('data-timestamp', +new Date());
                    (d.head || d.body).appendChild(s);
                })();
            </script>
            <noscript>
                Please enable JavaScript to view the
                <a href="https://disqus.com/?ref_noscript" rel="nofollow">
                    comments powered by Disqus.
                </a>
            </noscript>
        </div><!-- .commenting -->
    </div>
</section>
