
<div class="row">
    <div class="col-lg-6">
        <h2>Search Classrooms</h2>
        <p>
            <label for="amount">Seats</label>
            <input class="border-0 text-info" type="text" id="amount" readonly="" />
        </p>
        <div class="capacities form-group">
            <div id="slider-range"></div>
        </div>
        <form>
            <h3 class="text-bright-light h4">Location</h3>
            <h4 class="h5">Campus</h4>
            <select class="form-control" id="campus">
                <?php foreach($arrCampuses as $objCampus){ ?>
                    <option value="<?php echo $objCampus; ?>"><?php echo $objCampus; ?></option>
                <?php } ?>
            </select>
            <h4 class="h5">Building</h4>
            <select class="form-control" id="building">
                <option value="any">Any Building</option>
                <?php foreach($arrBuildings as $objBuilding){ ?>
                    <option value="<?php echo $objBuilding->getId(); ?>"><?php echo $objBuilding->getName(); ?></option>
                <?php } ?>

            </select>

            <h3 class="text-bright-light h4">Classroom Technology</h3>
            <?php foreach($arrTechnologies as $objTechnology) { ?>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="technology" id="<?php echo $objTechnology->getId(); ?>" value="<?php echo $objTechnology->getId(); ?>">
                    <label class="form-check-label" for="<?php echo $objTechnology->getId(); ?>"><?php echo $objTechnology->getName() ; ?></label>
                </div>
            <?php } ?>



        </form>
        <button type="submit" class="btn btn-primary mt-4" id="search" onclick="search()">Search</button>
    </div>
    <div class="col-lg-6" id="results">
        <h2>Results</h2>
    </div>
</div>



<!-- three.js -->
<script src="https://cdn.jsdelivr.net/npm/three/build/three.min.js"></script>

<!-- photosphereviewer -->
<script src="https://cdn.jsdelivr.net/npm/@photo-sphere-viewer/core/index.min.js"></script>

<script src="https://classroomsupport.usu.edu/_resources/dev/classroom-search/class-search.js"></script>