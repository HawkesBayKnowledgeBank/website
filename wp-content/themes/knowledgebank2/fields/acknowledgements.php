<?php $acknowledgements = $field['value'];?>
<?php if(!empty($acknowledgements)): ?>
    <div class="col field field-acknowledgements" data-field-name="<?php echo $field['name']; ?>">
            <h4><?php echo $field['label'];?></h4>

            <?php
                //make a comma-separated string of acknowledgements, with the final one 'and' spearated
                //eg A, B, C and D

                if(count($acknowledgements) > 1){
                    $last = array_pop($acknowledgements);
                }
                $acknowledgements_str = '<em>' . implode('</em>, <em>',$acknowledgements) . '</em>';
                if(!empty($last)) $acknowledgements_str .= ' and <em>' . $last . '</em>';

                echo "<p>Published with permission of $acknowledgements_str</p>";
            ?>


    </div>
<?php endif; ?>
