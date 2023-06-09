<h4 class="h5">Building</h4>
<select class="form-control" id="building">
    <option value="any">Any Building</option>
    <?php foreach($arrBuildings as $objBuilding){ ?>
        <option value="<?php echo $objBuilding->getId(); ?>"><?php echo $objBuilding->getName(); ?></option>
    <?php } ?>

</select>