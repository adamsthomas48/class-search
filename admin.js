$(document).ready(function() {

    $('#exampleModal').on('show.bs.modal', function (event) {
        var assetId = $(event.relatedTarget).data('asset-id');

        var modal= $(this);
        modal.find('#delete-button').attr('onclick', 'deleteAsset(' + assetId + ')');
    })

});

$(document).ready(function() {

    $('#delete-classroom').on('show.bs.modal', function (event) {
        var classroomId = $(event.relatedTarget).data('classroom-id');

        var modal= $(this);
        modal.find('#delete-button').attr('onclick', 'deleteClassroom(' + classroomId + ')');
    })

});

/**
 * Deletes an asset from the database
 *
 * @param assetId
 */
function deleteAsset(assetId) {
    $.get("/_resources/dev/classroom-search/admin-controller.php", {assetId: assetId, deleteAsset: true}, function(data) {
        location.reload();
    });
}

/**
 * Deletes a classroom from the database
 *
 * @param classroomId
 */
function deleteClassroom(classroomId) {
    $.get("/_resources/dev/classroom-search/admin-controller.php", {classroomId: classroomId, deleteClassroom: true}, function(data) {
        location.reload();
    });
}