<?php
/**
 * @var array $services []
 * @var array $customerTypes []
 * @var array $citizenTitles []
 */
?>

<?php include(APP_DIR . 'views' . DIR_SEPARATOR . 'header.php'); ?>

    <div class="container create_customer">

        <div class="row">
            <div class="cell"><a href="<?php echo BASE_URL; ?>default">Back</a></div>
            <div class="cell"><a href="<?php echo BASE_URL; ?>customer/listQueue">Queue list</a></div>
            <div class="clear"></div>
        </div>

        <?php if ($services && $customerTypes) : ?>
            <h3>Add Customer Details</h3>

            <form class="form_customer" role="form" method="post" action="../customer/create">
                <div class="row">
                    <label class="control-label">Services</label>

                    <div class="row-input">
                        <?php if ($services) : ?>
                            <div class="radio">
                                <?php foreach ($services as $id => $service) : ?>
                                    <label for="service_<?= $id ?>" class="radio_label">
                                        <input type="radio" name="service" id="service_<?= $id ?>"
                                               value="<?= $id ?>"><?= ucfirst($service) ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <span class="error" id="msg_service"></span>
                    </div>
                </div>
                <div class="row">
                    <label class="control-label">Choose Customer Type</label>

                    <div class="row-input">
                        <?php if ($customerTypes) : ?>
                            <div class="radio" id="customerType">
                                <?php foreach ($customerTypes as $id => $customerType) : ?>
                                    <label for="type_<?= $id ?>" class="radio_label">
                                        <input type="radio" name="customerType" class="customerType"
                                               id="type_<?= $id ?>"
                                               value="<?= $id ?>"><?= ucfirst($customerType) ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <span class="error" id="msg_types"></span>
                    </div>
                </div>


                <?php
                if ($customerTypes) {
                    foreach ($customerTypes as $customerType) {
                        switch ($customerType) {
                            case "citizen" :
                                ?>
                                <div class="customer" id="<?=$customerType?>">
                                    <?php if ($citizenTitles) : ?>
                                        <div class="row">
                                            <div class="row-input">
                                                <label for="title" class="control-label">Title</label>
                                                <select class="form-control" id="title" name="title">
                                                    <?php foreach ($citizenTitles as $title) : ?>
                                                        <option value="<?= $title ?>"><?= ucfirst($title) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="row">
                                        <label for="firstname" class="control-label">FirstName</label>

                                        <div class="row-input">
                                            <input type="text" class="form-control" id="firstname" name="firstname"
                                                   placeholder="Enter Firstname">
                                            <span class="error" id="msg_firstname"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="lastname" class="control-label">LastName</label>

                                        <div class="row-input">
                                            <input type="text" class="form-control" id="lastname" name="lastname"
                                                   placeholder="Enter Lastname">
                                            <span class="error" id="msg_lastname"></span>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                break;
                            case "organisation" :
                                ?>
                                <div class="customer" id="<?=$customerType?>">
                                    <div class="row">
                                        <label for="name" class="control-label">Name</label>

                                        <div class="row-input">
                                            <input type="text" class="form-control" id="name" name="name"
                                                   placeholder="Enter Name">
                                            <span class="error" id="msg_name"></span>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                break;
                            default :
                                break;
                        }
                    }
                }
                ?>

                <div class="row">
                    <div class="row-input">
                        <input id="submit" name="submit" type="submit" value="Save" class="btn btn-primary">
                    </div>
                </div>
            </form>
        <?php else : ?>
            <p>Can't create customers. <br/>No services or customer type found!</p>
            <p>Please check README.md to import data properly</p>
        <?php endif; ?>
    </div>

<?php include(APP_DIR . 'views' . DIR_SEPARATOR . 'footer.php'); ?>