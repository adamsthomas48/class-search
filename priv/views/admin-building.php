<script src="https://classroomsupport.usu.edu/_resources/dev/classroom-search/admin.js"></script>

<a class="btn btn-bright-light" href="<?php echo $baseUrl ?>"><i class="fas fa-arrow-left"></i> Back To Admin Home</a>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="row mb-3">
            <div class="col-lg-9">
                <h1><?php echo $objBuildingInfo['building_name'] ?></h1>
            </div>
            <div class="col-lg-3 mt-3">
                <a href="<?php echo $baseUrl . '?add_classroom=true&building_id=' . $objBuildingInfo['id'] ?>" class="btn btn-success btn-block"> <i class="fas fa-plus"></i> Add New Classroom</a>

            </div>
        </div>
        <div class="row">
            <?php
            foreach($arrClassrooms as $classroom){
                ?>
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo $objBuildingInfo['filter_code'] .' ' . $classroom['name']; ?></h3>
                            <div class="d-flex justify-content-end mt-3">

                                <a href="<?php echo $baseUrl . "?update_classroom=true&classroom_id=" . $classroom['id'] . "&building_code=" . $objBuildingInfo['filter_code'];?>" class="btn btn-primary mr-2"><i class="fas fa-pencil-alt"></i> Update</a>

                                <a class="modal-opener btn btn-danger"  data-toggle="modal" data-target="#delete-classroom" href="#"
                                   data-classroom-id="<?php echo $classroom['id'] ?>">
                                    <i class="fas fa-trash-alt"></i> Delete Classroom
                                </a>


                            </div>

                        </div>

                    </div>
                </div>
                <?php
            }
            ?>

        </div>
    </div>

</div>


