<?php get_header(); ?>

<?php if (have_posts()): while (have_posts()) : the_post(); ?>
<script>
function afficher_cacher($id) {
    if (document.getElementById($id).style.display=='none') {
        document.getElementById($id).style.display='block';
    }
    else {
        document.getElementById($id).style.display='none';
    }
    return true;
}
</script>

<div class="pageTitles">

	<h1><?php the_title(); ?></h1>

</div>

<!-- <div class='aboutPageContent'> -->
	<div class="grid-container">
		<div class="grid-6">
			<h3><img class="alignnone size-full wp-image-113334" src="http://new.knowledgebank.org.nz/wp-content/uploads/node/113332/images/stoneycroft.jpg" alt="stoneycroft" /></h3>
		</div>
		<div class="grid-6">

			<span class="bouton" id="bouton_texte" onclick="afficher_cacher('texte')"><h3>Who Are We?</h3></span>

			<ul><div id="texte" class="texte">
			The Hawke's Bay Knowledge Bank is a living record of Hawke's Bay and its people. It combines a robust, secure and widely-compatible digital archive with a new generation of multimedia and social tools. The aim of the trust is to create a digital encyclopedia of people and places, education, cultural, sporting, industrial and commercial achievements of yesterday linked with those of today.

			We want to enrich our stored material with the knowledge of the community through user comments, tagging and sharing of information. Click here to find how you can contribute.</div></ul>

			<span class="bouton" id="bouton_texte1" onclick="afficher_cacher('texte1')"><h3>Why Do We Do This?</h3></span>
			<ul><div id="texte1" class="texte">
			There's a wealth of fading photographs, letters, recordings and much more stashed away in old shoeboxes and family collections. Most of it doesn't belong in a museum, but it is most certainly worth keeping. Modern technologies allow us to capture and preserve this valuable community resource for future generations, on a much larger scale and at a lower cost than preserving the physical objects.
			</div></ul>
			<span class="bouton" id="bouton_texte2" onclick="afficher_cacher('texte2')"><h3>What Do We Do?</h3></span>
			<ul><div id="texte2" class="texte">
			The first step is 'digitising' or capturing the information from whatever format it is in now - photographic glass plates, film, photographs, or even as memories in someone's head. We then put the electronic copy into a digital archive - a system for carefully describing and linking these historical objects, preserving as much information as we can. Finally, we invite you to browse and contribute your own knowledge in the form of user comments and tagging. This will add to the pool of relevant information about the subjects others are interested in. If you're interested in helping with digitising some of the material we'll be processing, or can offer your time or skills in other ways, please get in touch.
			</div></ul>
			<span class="bouton" id="bouton_texte3" onclick="afficher_cacher('texte3')"><h3>The Technology We Use</h3></span>
			<ul><div id="texte3" class="texte">
			The Knowledge Bank trustees, Dr David Barry, Peter Dunkerley, Angus Gordon, Heugh Chappell and James Morgan, opted for open-source software to show that it could be used effectively as a long-lasting and unique public service while keeping costs to a minimum. The trustees also believe the project can provide a model for other regions in New Zealand. Some of the key people giving their time to the project are the following: Linda Ward, database manager; Grant Ancell, supervisor; Chris Johnson, archivist; Robyn Warren, researcher; Lily Baker, genealogist; Nikki Beattie, 3D modeller; Chris Webb, website and development manager; Tom Chamberlain, IT consultant and engineer; Cedric Knowles, accountant; Dianne Sye, researcher; Peter Trask, researcher, Robyn Warren and Bronwyn Arlidge, data input supervision. The Hawke's Bay Digital Archive trustees and working team took into account streamlining and standardisation of procedures, consistency of training and operation for volunteers from all walks of life. Utilising open-source software allowed the trustees to keep to a budget also stretched by the vast costs of restoring the fabric of Stoneycroft Homestead. The material is being preserved for posterity, but will always be available to the public on a daily basis. The material is being backed up and replicated across sites within New Zealand. We use the following technologies to preserve and record all our digital history; Ubuntu Desktop, Ubuntu Server, Ubuntu Cloud, VMWare, Veeam, Drupal, Apache Solr, OwnCloud, HandBrake, Zimbra, LTSP, Asterisk and Google Applications.
			<div class="sponsorsImage"><img class="alignnone size-medium wp-image-113338" src="http://new.knowledgebank.org.nz/wp-content/uploads/node/113332/images/logos-300x65.jpg" alt="logos" /></div>
			All logos are registered trademarks of their respective owners. No official endorsement of the Hawke's Bay Knowledge Bank is claimed or implied.
			</div></ul>
			<span class="bouton" id="bouton_texte4" onclick="afficher_cacher('texte4')"><h3>We value your contributions</h3></span>
			<ul><div id="texte4" class="texte">
			We're always interested in hearing about family or individual collections which might not have been shared as widely as they could. If you have a cache of old photographs, film, slides or other materials which you think could be of interest to the wider public, please get in touch. Note: Due to space constraints we cannot store physical collections longer than it takes to digitise them. Materials will be returned to the donor or disposed-of according to the donor's wishes after they are digitised.
			</div></ul>

		</div>
	</div>

<!-- <?php the_content(); ?> -->

<!-- </div> -->

<?php endwhile; endif; ?>

<?php get_footer(); ?>

