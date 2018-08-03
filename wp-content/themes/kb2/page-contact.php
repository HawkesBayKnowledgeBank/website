<?php
/*
Template Name: Contact Form
*/
?>


<?php
$commentError ="";
$nameError="";
$emailError="";


//If the form is submitted
if(isset($_POST['submitted'])) {

	//Check to see if the honeypot captcha field was filled in
	if(trim($_POST['checking']) !== '') {
		$captchaError = true;
	} else {

		//Check to make sure that the name field is not empty
		if(trim($_POST['contactName']) === '') {
			$nameError = 'You forgot to enter your name.';
			$hasError = true;
		} else {
			$name = trim($_POST['contactName']);
		}

		//Check to make sure sure that a valid email address is submitted
		if(trim($_POST['email']) === '')  {
			$emailError = 'You forgot to enter your email address.';
			$hasError = true;
		} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
			$emailError = 'You entered an invalid email address.';
			$hasError = true;
		} else {
			$email = trim($_POST['email']);
		}

		//Check to make sure comments were entered
		if(trim($_POST['comments']) === '') {
			$commentError = 'You forgot to enter your comments.';
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
		}

		//If there is no error, send the email
		if(!isset($hasError)) {

			$emailTo = 'yohann.coupannec@gmail.com';
			$subject = 'Contact Form Submission from '.$name;
			$sendCopy = trim($_POST['sendCopy']);
			$body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
			$headers = 'From: My Site <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

			mail($emailTo, $subject, $body, $headers);

			if($sendCopy == true) {
				$subject = 'You emailed Your Name';
				$headers = 'From: Your Name <noreply@somedomain.com>';
				mail($email, $subject, $body, $headers);
			}

			$emailSent = true;

		}
	}
} ?>


<?php get_header(); ?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/scripts/contact-form.js"></script>

<div class="pageTitles">
	<h1><?php the_title(); ?></h1>
</div>
<div class="grid-container">
	<div class="grid-6">
		<div class="contact-title">
			<h3>Phone :</h3>
			<p>+64 6 833 5333</p>
			<h3>Email :</h3>
			<p><a href="mailto:james@knowledgebank.org.nz">james@knowledgebank.org.nz</a></p>
			<h3>Post :</h3>
			<p>Hawke's Bay Knowledge Bank<br />
			PO Box 2025<br />
			Stortford Lodge<br />
			Hastings 4153</p>
			<h3>Visit :</h3>
			<p>Members of the public are most welcome to visit us. Our usual opening hours are Monday - Friday, 10.30am - 5pm.</p>
			<p>901 Omahu Rd, Frimley, Hastings<br />
			(Corner of Omahu Rd and the Expressway)</p>
		</div>
	</div>

	<div class="grid-6">

	<?php if(isset($emailSent) && $emailSent == true) { ?>

		<div class="thanks">
			<h1>Thanks, <?=$name;?></h1>
			<p>Your email was successfully sent. I will be in touch soon.</p>
		</div>

	<?php } else { ?>

		<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
			<div class="forms">
				<?php the_content(); ?>
			</div>



			<?php endwhile; ?>
		<?php endif; ?>
	<?php } ?>
	</div>
</div>
<div class="grid-container">
 	<div class="grid-12">
 		<p><iframe class="google-maps" frameborder="0" height="250" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3073.2760226549185!2d176.81774800000005!3d-39.620988499999925!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6d69c9f72671ab9b%3A0x8dab3fc91d1b2806!2s901+Omahu+Rd%2C+Frimley%2C+Hastings+4120!5e0!3m2!1sen!2snz!4v1410767983286" width="1050"></iframe></p>
 	</div>
</div>




<?php get_footer(); ?>

