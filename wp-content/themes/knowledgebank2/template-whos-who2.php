<?php /* Template Name: Who's Who v2 */ ?>

<?php get_header(); ?>


<main role="main">

    <section class="layer intro intro-default">
        <div class="inner">
            <div class="intro-copy dark inner-700">
                <?php get_template_part('sections/breadcrumbs'); ?>
                <h1><?php the_title(); ?></h1>
                <?php the_field('intro'); ?>
                <p>An index of Hawke's Bay people.</p>
            </div><!-- .intro-copy -->
        </div><!-- .inner -->
    </section>

    <section class="layer controls whos-who">
        <div class="inner">

            <form class="" action="" method="get">

                <div class="controls-grid">
                    <div class="control-option alphabet">
                        <label>Filter by last name</label>
                        <div class="alphabet-flex">
                            <?php $active = empty($_GET['letter']) ? 'active' : ''; ?>
                            <label class="<?php echo $active; ?>"><input type="radio" name="letter" value="" <?php echo $active ? 'checked' : ''; ?>/> All</label>
                            <?php foreach(range('a','z') as $page_letter): ?>
                                <?php $active = !empty($_GET['letter']) && $_GET['letter'] == $page_letter ? 'active' : ''; ?>
                                <label class="<?php echo $active; ?>"><input type="radio" name="letter" value="<?php echo $page_letter; ?>" <?php echo $active ? 'checked' : ''; ?>/> <?php echo $page_letter; ?></label>
                            <?php endforeach; ?>
                        </div>
                        <div class="dropdown">
                            <select>
                                <?php $active = empty($_GET['letter']) ? 'selected' : ''; ?>
                                <option value="" <?php echo $active; ?>>All</option>
                                <?php foreach(range('a','z') as $page_letter): ?>
                                    <?php $active = !empty($_GET['letter']) && $_GET['letter'] == $page_letter ? 'selected' : ''; ?>
                                    <option <?php echo $active; ?> value="<?php echo $page_letter; ?>"><?php echo strtoupper($page_letter); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div><!-- .control-option -->
                </div>

            </form>

        </div>
    </section>

    <section class="layer results table">
        <div class="inner">




            <table id="whos-who">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>DOB</th>
                        <th>DOD</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <script>

                var people_json = <?php knowledgebank_people_endpoint(); ?>;

            </script>

        </div><!-- .inner -->
    </section>

	</main>
<?php get_footer(); ?>
