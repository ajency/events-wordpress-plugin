<table class="table table-hover">
    <thead>
    <tr>
<!--        <?php /*foreach ($this->headers as $header) : */?>
            <th><?php /*echo $header */?></th>
        --><?php /*endforeach; */?>

        <th>Name</th>
    </tr>
    </thead>
    <tbody>


    <?php
query_posts($this->query);
while ( have_posts() ) { the_post();
?>

            <tr>
                <td><?php get_the_title(); ?></td>
            </tr>
<?php } ?>

    </tbody>
</table>

<?php wp_reset_query(); ?>