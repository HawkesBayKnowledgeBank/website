<?php get_header(); ?>
<?php $filters = knowledgebank_get_filters(); ?>
<?php
    global $wp_query;

    $title = 'Bibliography';


?>

    <main role="main">

            <section class="layer intro intro-default">
                <div class="inner">
                    <div class="intro-copy dark inner-700">
                        <?php get_template_part('sections/breadcrumbs'); ?>
                        <h1><?php echo $title; ?></h1>
                          <p>An index of publications relating to Hawke's Bay and its history. We do not hold digital copies of the books themselves, but this index may assist you in finding copies.</p>
                    </div><!-- .intro-copy -->
                </div><!-- .inner -->
            </section>

            <?php include_once(get_template_directory() . '/sections/term-filters.php'); //include rather than get_template_part so we can share $filters ?>

            <?php
                $extra_classes = array();

            ?>
            <section class="layer results table">
                <div class="inner">

                        <?php if(have_posts()): ?>

                            <table>
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Author(s)</th>
                                        <th>Publication date</th>
                                    </tr>
                                </thead>

                                <?php while(have_posts()): the_post(); ?>

                                    <?php
                                        $book = $post;
                                        $author = get_field('author', $book->ID);
                                        if(!empty($author)){
                                            $author_strings = array();
                                            foreach($author as $person){
                                                $record = false;
                                                if(!empty($person['record'])) {
                                                    $record = $person['record'];
                                                    unset($person['record']);
                                                }
                                                $name = implode(' ', $person);
                                                if(!empty($record)){
                                                    $author_strings[] = sprintf('<a href="%s">%s</a>', get_permalink($record->ID), $name);
                                                }
                                                else{
                                                    $author_strings[] = $name;
                                                }
                                            }
                                            $author = implode(", ", $author_strings);
                                        }

                                        $yearpublished = get_field('yearpublished', $book->ID);

                                    ?>
                                    <tr>
                                        <td data-title="Title"><a href="<?php echo get_permalink($book->ID); ?>"><?php echo $book->post_title; ?></a></td>
                                        <td data-title="Author"><?php echo $author; ?></td>
                                        <td data-title="Year"><?php echo $yearpublished; ?></td>
                                    </tr>


                                <?php endwhile; ?>

                            </table>

                        <?php else: ?>

                            <p>No results found</p>


                        <?php endif; ?>

                    <ul class="pagination">
                        <?php knowledgebank_numeric_posts_nav(); ?>
                    </ul>

                </div><!-- .inner -->
            </section>

    </main>

<?php get_footer(); ?>
