<?php include '../Technology.php' ?>
<a class="btn btn-bright-light" href="<?php echo $baseUrl ?>"><i class="fas fa-arrow-left"></i> Back To Admin Home</a>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <h1>Update Classroom: <?php echo $strBuildingCode . " " . $objClassroomInfo['name'] ?></h1>
        <form method="post">
            <div class="form-group">
                <label for="classroom-name">Classroom Name</label>
                <input type="text" class="form-control" id="classroom-name" name="classroom-name" value="<?php echo $objClassroomInfo['name'] ?>" required >
            </div>
            <div class="form-group">
                <label for="classroom-image">Classroom Image Url</label>
                <input type="text" class="form-control" id="classroom-image" name="classroom-image" value="<?php echo $objClassroomInfo['room_image_url'] ?>" required >
            </div>
            <div class="form-group">
                <label for="equipment-image">Equipment Image Url</label>
                <input type="text" class="form-control" id="equipment-image" name="equipment-image" value="<?php echo $objClassroomInfo['equipment_image_url'] ?>" required >
            </div>
            <div class="form-group">
                <label for="classroom-capacity">Classroom Capacity</label>
                <input type="number" class="form-control" id="classroom-capacity" name="classroom-capacity" value="<?php echo $objClassroomInfo['seats'] ?>" required >
            </div>

            <?php
                foreach($arrAllTech as $k=>$objTech){
                    ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="<?php echo $objTech->getId(); ?>" id="<?php echo $k ?>" name="tech[]"
                            <?php
                                if(in_array($objTech->getId(), $arrClassTech)){
                                    echo 'checked';
                                }
                            ?>
                        >
                        <label class="form-check-label" for="<?php echo $k ?>">
                            <?php echo $objTech->getName() ?>
                        </label>
                    </div>

               <?php } ?>


            <div class="d-flex justify-content-end">
                <button type="submit" name="update-classroom" class="btn btn-success">Update Classroom</button>
            </div>
        </form>


    </div>
</div>


