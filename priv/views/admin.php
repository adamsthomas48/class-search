<div class="container container-narrow">
    <div class="row mb-3">
        <div class="col-lg-9 order-2 order-lg-1">
            <h1>Classroom Search Admin</h1>
        </div>
        <div class="col-lg-3 mt-3 order-1 order-lg-2">
            <a href="<?php echo $baseUrl ?>?edit_tech=true" class="btn btn-primary btn-block"> <i class="fas fa-pencil-alt"></i> Edit Technologies</a>
            <a href="<?php echo $baseUrl ?>?add_building=true" class="btn btn-success btn-block"> <i class="fas fa-plus"></i> Add New Building</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <ul class="listcol-md-2">
            <?php
            foreach($arrBuildings as $objBuilding){
                ?>
                <li><a <?php echo 'href="'. $baseUrl.'?building_id=' . $objBuilding->getId() . '"' ?>><?php echo $objBuilding->getName(); ?></a></li>

                <?php
            }
            ?>
            </ul>
        </div>
    </div>

</div>
