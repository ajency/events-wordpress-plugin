<table class="table table-hover">
    <thead>
    <tr>
        <?php foreach ($this->headers as $header) : ?>
        <th><?php echo $header ?></th>
        <?php endforeach; ?>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($this->data as $data) : ?>
    <tr>
        <td><?php echo $data[0]; ?></td>
        <td><?php echo $data[1]; ?></td>
        <td><?php echo $data[2]; ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php
echo "<pre>";
print_r($this->data);
?>