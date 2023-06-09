<a class="btn btn-bright-light" href="<?php echo $baseUrl ?>"><i class="fas fa-arrow-left"></i> Back To Admin Home</a>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <h1>Add Building</h1>
        <form method="post">
            <div class="form-group">
                <label for="create-building">Building Name</label>
                <input type="text" class="form-control" id="building-name" name="building-name" required >
            </div>
            <div class="form-group">
                <label for="create-building">Building Code</label>
                <input type="text" class="form-control" id="building-code" name="building-code" required >
                <small id="building-code" class="form-text text-muted">This will show up as "building-code room-name" in the search results.</small>

            </div>
            <div class="form-group">
                <label for="create-building">Campus</label>
                <input type="text" class="form-control" id="building-code" name="building-code" required >
                <small id="building-code" class="form-text text-muted">This will show up as "building-code room-name" in the search results.</small>

            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success" name="submit-add-building">Create Building</button>

            </div>
        </form>
    </div>
</div>




