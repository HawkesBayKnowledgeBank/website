<?php get_header(); ?>

<?php if (have_posts()): while (have_posts()) : the_post(); ?>

<div class="pageTitles">
	
	<h1><?php the_title(); ?></h1>

</div>

<div class='aboutPageContent'>

<?php the_content(); ?>


<p>Can you help? We appreciate any and all donations towards preserving our local history. You can donate securely online via Paypal and Give a Little </p>

<a class='give-a-little-icon' href="https://givealittle.co.nz/donate/org/hbknowledgebank"> </a>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="XB7762YFFER6A">
<input type="image" class="paypal-icon">
<!-- <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1"> -->
</form>

<!-- <a class='paypal-icon' href=""> </a>  -->
<br>

<!-- PayPal – The safer, easier way to pay online! <br><br> -->

<p>Alternatively you can send your check to</p>

<p>Hawke’s Bay Knowledge Bank <br>
PO Box 2025<br>
Stortford Lodge<br>
Hastings</p>

<p>The Hawke’s Bay Knowledge Bank is a registered Charity, No. CC4697 </p>

<p>Every donation of more than $5 you personally make to the Knowledge Bank entitles you to a tax credit that is one third the value of the donation. For example, a donation of $1,500 entitles you to a $500 tax credit. Companies can claim a deduction for all donations to Hawke’s Bay Knowledge Bank funds, reducing their taxable income. Take a look at the IRD information for individuals and for companies.</p>




</div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>