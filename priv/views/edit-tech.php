<script src="https://classroomsupport.usu.edu/_resources/scripts/classroom-search/admin.js"></script>
<a class="btn btn-bright-light" href="<?php echo $baseUrl ?>"><i class="fas fa-arrow-left"></i> Back To Admin Home</a>

<div class="container container-narrow">
    <h1>Edit Technologies</h1>
    <div class="row">
        <div class="col-lg-6 order-2 order-lg-1">
            <h2>Assets</h2>
            <p class="text-italic">Checked assets are active and unchecked assets are inactive</p>
            <form method="post">
                <?php
                foreach($arrAllTech as $k=>$objTech){
                    ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="<?php echo $objTech->getId(); ?>" id="<?php echo $k ?>" name="tech[]"
                            <?php
                            if($objTech->getStatus() == "active"){
                                echo 'checked';
                            }
                            ?>
                        >
                        <label class="form-check-label" for="<?php echo $k ?>">
                            <?php echo $objTech->getName() ?>
                        </label>
                        <a class="modal-opener text-danger"  data-toggle="modal" data-target="#exampleModal" href="#"
                           data-asset-id="<?php echo $objTech->getId() ?>"
                        >Delete</a>

                    </div>

                <?php } ?>
                <div class="d-flex justify-content-center mt-5">
                    <button type="submit" name="update-tech" class="btn btn-success">Update Assets</button>
                </div>
            </form>
        </div>
        <div class="col-lg-6 order-1 order-lg-2">
            <h2>Create a New Asset</h2>
            <form method="post">
                <div class="form-group">
                    <label for="asset-name">Asset Name</label>
                    <input type="text" class="form-control" id="asset-name" name="asset-name" required >
                </div>
                <div class="d-flex justify-content-center mt-5">
                    <button type="submit" name="create-tech" class="btn btn-success">Create Asset</button>
                </div>
            </form>

        </div>
    </div>
</div>



