<?php
/**
 * @var array $customers []
 */
?>

<?php include(APP_DIR . 'views' . DIR_SEPARATOR . 'header.php'); ?>
    <div class="container queue">

        <div class="row">
            <div class="cell"><a href="<?php echo BASE_URL; ?>default">Back</a></div>
            <div class="cell"><a href="<?php echo BASE_URL; ?>customer/create">Create Customer</a></div>
            <div class="clear"></div>
        </div>

        <?php if($customers) : ?>

            <h3>Queue</h3>

        <table class="queue_table">
            <thead>
            <tr>
                <th>#</th>
                <th>Type</th>
                <th>Name</th>
                <th>Service</th>
                <th>Queueed At</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($customers as $key => $record) :
                ?>
                <tr>
                    <td class="scope"><?= $key + 1 ?></td>
                    <td><?= $record['customerType'] ?></td>
                    <td><?= $record['customerName'] ?></td>
                    <td><?= $record['service'] ?></td>
                    <td><?= $record['queueAt'] ?></td>
                </tr>
                <?php
            endforeach;
            ?>
            </tbody>
        </table>
    <?php else : ?>
            <p>No records found!</p>
    <?php endif; ?>
    </div>
<?php include(APP_DIR . 'views' . DIR_SEPARATOR . 'footer.php'); ?>