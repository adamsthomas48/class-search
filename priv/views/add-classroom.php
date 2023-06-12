<a class="btn btn-bright-light" href="<?php echo $baseUrl ?>"><i class="fas fa-arrow-left"></i> Back To Admin Home</a>
<div class="row justify-content-center">
	<div class="col-lg-6">
		<h1>Add New Classroom</h1>
		<form method="post">
			<div class="form-group">
				<label for="room-name">Room Name</label>
				<input type="text" class="form-control" id="room-name" name="room-name" required>
			</div>
			<div class="form-group">
				<label for="room-image-url">Room Image URL</label>
				<input type="text" class="form-control" id="room-image-url" name="room-image-url" required>
				<small id="room-image-help" class="form-text text-muted">Upload the image to the classroom-technology-images folder, publish the image and then get the image url. It will look like this (https://classroomsupport.usu.edu/classroom-technology-images/aste_106_e.jpg)
				</small>
			</div>
			<div class="form-group">
				<label for="equipment-image-url">Equipment Image URL</label>
				<input type="text" class="form-control" id="equipment-image-url" name="equipment-image-url" required>
				<small id="equipment-image-help" class="form-text text-muted">Upload the image to the classroom-technology-images folder, publish the image and then get the image url. It will look like this (https://classroomsupport.usu.edu/classroom-technology-images/aste_106_e.jpg)
				</small>
			</div>

            <div class="form-group">
                <label for="image-type">Image Type</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="image-type" id="2d-image" value="2D" required>
                    <label class="form-check-label" for="2d-image">
                        2D
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="image-type" id="3d-image" value="3D" required>
                    <label class="form-check-label" for="3d-image">
                        3D
                    </label>
                </div>
            </div>


            <div class="form-group">
				<label for="seat-capacity">Seat Capacity</label>
				<input type="number" class="form-control" id="seat-capacity" name="seat-capacity" required>
			</div>

            <?php
            foreach($arrAllTech as $k=>$objTech){
                ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="<?php echo $objTech->getId(); ?>" id="<?php echo $k ?>" name="tech[]">
                    <label class="form-check-label" for="<?php echo $k ?>">
                        <?php echo $objTech->getName() ?>
                    </label>
                </div>

            <?php } ?>


			<div class="d-flex justify-content-end">
				<button type="submit" name="submit-add-classroom" class="btn btn-success">Create Classroom</button>
			</div>
		</form>
	</div>
</div>

