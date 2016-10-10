
<?php $file = get_field('master'); ?>

<?php if( $file ): ?>

<div class="LicenceBox">
	<div class="">	

		<?php 

			$attachment = get_attached_file( $file['id'] ) ;
			$filesize   = size_format( filesize( $attachment ) ); 
			
		?>

		<a data-href="<?php echo $file['url']; ?>" href="#donation-modal" class="download master popup-modal">Download original digital file <span class="filesize"><?php echo $filesize; ?></span></a>			
		
		<div id="donation-modal" class="white-popup-block mfp-hide">
			<a class="popup-modal-dismiss" href="#">×</a>
			<div class="grid-container">

				<div class="grid-8">

					<h2>The material you are downloading comes to you from the Hawke's Bay Knowledge Bank.</h2>
					<p>The Knowledge Bank has been established for your benefit and the benefit of your descendants for all the years ahead.</p>
					<p>Collecting, collating and preserving the province's history comes at a cost to volunteers of time, effort and money. <p>If you find something of value here, please play your part with a generous donation toward our costs. We appreciate your support.</p>

				</div>

				<div class="grid-4">

					
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="Q7N2YUWUPRVAC">
						<input type="image" src="/wp-content/themes/kb2/img/pp.png" border="0" name="submit" class="pp" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>

					<p><a href="<?php echo $file['url']; ?>" class="download">Download <span class="filesize"><?php echo $filesize; ?></span></a></p>
					
				</div>

			</div>
			
		</div><!-- #donation-modal -->

	</div>
	<div class="grid-container bottom_margin">
		<?php $licence = get_field( 'licence' );?>
		<?php if( !empty( $licence ) ) : ?>
		<div class="grid-6">

					<?php if ($licence=="a-nc"): ?>
						<a class="NoCommercial" href="https://creativecommons.org/licenses/by-nc/4.0/"></a>
						<p>This work is licensed under a <a href="http://creativecommons.org/licenses/by-nc/4.0/" rel="license"> Creative Commons Attribution-NonCommercial 4.0 International License</a> </p>
					<?php endif; ?>

		</div>
		<?php endif; ?>
		
		<?php $allow_commercial_licence = get_field( 'allow_commercial_licence' );?>
		<?php if( !empty( $allow_commercial_licence ) ) : ?>
		<div class="grid-6">

			<?php if ($allow_commercial_licence==true): ?>
				<h4>Commercial licencing</h4>
				<p><strong>$15 NZD</strong> - Single commercial use licence</p>
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
	              <input type="hidden" name="cmd" value="_s-xclick">
	              <input type="hidden" name="item_number" value="<?php echo $post->ID; ?>">
	              <input type="hidden" name="item_name" value="Single Use Licence (<?php echo $post->post_title; ?> - <?php echo get_permalink($post->ID); ?>)">
	              
	              <input type="hidden" name="hosted_button_id" value="2GLR6UD6GLX78">
	              <input type="submit" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" value="Buy Now"/>			              
	              <p><a href="/licensing">About commercial licensing.</a></p>
	              <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1" hidden="" style="display: none !important;">
	            </form>						

			<?php endif; ?>
			
		</div>
		<?php endif; ?>		
	</div>
</div>


<?php endif; ?> 