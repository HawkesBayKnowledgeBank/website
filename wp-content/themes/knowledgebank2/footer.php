			<!-- footer -->
			<footer class="layer footer dark">
					<div class="inner">
						<div class="grid column-4">
							<div class="col">
								<a href="/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/knowledgebank_logo_center_reversed.svg" alt="Knowledge Bank"></a>
							</div>
							<div class="col">
								<h5>Quicklinks</h5>
								<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => '' ) ); ?>

							</div>
							<div class="col">

								<?php the_field('footer_column_left','option'); ?>

								<?php if(get_field('footer_column_left_buttons','option')): ?>
									<div class="button-group">
										<?php $buttons = get_field('footer_column_left_buttons','option'); ?>
										<?php foreach($buttons as $button): ?>
											<?php
												$target = !empty($button['target']) ? 'target="_blank"' : '';
												echo vsprintf('<a href="%s" class="button" %s>%s</a>', array($button['url'], $target, $button['label']));
											?>
										<?php endforeach; ?>
									</div><!-- .button-group -->
								<?php endif; ?>

							</div>
							<div class="col">

								<?php the_field('footer_column_right','option'); ?>

								<?php if(get_field('footer_column_right_buttons','option')): ?>
									<div class="button-group">
										<?php $buttons = get_field('footer_column_right_buttons','option'); ?>
										<?php foreach($buttons as $button): ?>
											<?php
												$target = !empty($button['target']) ? 'target="_blank"' : '';
												echo vsprintf('<a href="%s" class="button" %s>%s</a>', array($button['url'], $target, $button['label']));
											?>
										<?php endforeach; ?>
									</div><!-- .button-group -->
								<?php endif; ?>

							</div>
						</div>
						<p class="footer-meta">© 2018 - <?php echo date('Y'); ?> Hawke's Bay Digital Archives Trust <span class="spacer">|</span>
							<a href="http://mogul.nz/" target="_blank">Website by Mogul</a> <span class="spacer">|</span>
							<a href="/login">Login</a></p>

					</div>
				</footer>
			<!-- /footer -->

		<?php wp_footer(); ?>

		<!-- analytics -->
		<script>
		(function(f,i,r,e,s,h,l){i['GoogleAnalyticsObject']=s;f[s]=f[s]||function(){
		(f[s].q=f[s].q||[]).push(arguments)},f[s].l=1*new Date();h=i.createElement(r),
		l=i.getElementsByTagName(r)[0];h.async=1;h.src=e;l.parentNode.insertBefore(h,l)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-36759475-1', 'knowledgebank.org.nz');
		ga('send', 'pageview');
		</script>

	</body>
</html>
