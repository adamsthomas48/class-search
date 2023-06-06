let minCapacity  = 0;
let maxCapacity = 500;

/**
 * splitByNewLine
 * Takes a string and splits it on each new line to create an array of strings
 * 
 * @returns array
 */
function splitByNewline(string) {
    return string.split("\n");
}

/**
 * Instantiate the slider used to set the capacity range
 */
$( "#slider-range" ).slider({
    "range": true,
    "min": 0,
    "max": 500,
    "values": [0, 500],
    "slide": function( event, ui ) {
        $('#amount').val(ui.values[0] + " - " + ui.values[1]);
        minCapacity = parseInt(ui.values[0], 10);
        maxCapacity = parseInt(ui.values[1], 10);
    }
});
// Set the initial values of amounts to the slider
$('#amount').val($('#slider-range').slider('values', 0) + " - " + $('#slider-range').slider('values', 1));

$(document).ready(function() {
    search(); //Run search on page load to populate default results
    
    $('#exampleModal').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget)
        var roomName = link.data('roomname');
        var equipment = splitByNewline(link.data('equipment'));
        var roomUrl = link.data('room-url');
        var equipmentUrl = link.data('equipment-url');
        var capcity =link.data('capacity');

        var modal = $(this)
        modal.find('.modal-title').text('Classroom Title')
        modal.find('.modal-title').text(roomName);
        modal.find('#capacity').text("Capacity: "+ capcity + " seats");
        for (let i = 0; i < equipment.length - 1; i++) {
            let li = document.createElement("li");
            li.innerHTML = equipment[i];
            modal.find('#equipment').append(li);
        }
        
        var roomViewer = new PhotoSphereViewer.Viewer({
            container: document.querySelector('#room-image'),
            panorama: 'https://classroomsupport.usu.edu' + roomUrl,
            touchmoveTwoFingers: true,
        });

        var equipmentViewer = new PhotoSphereViewer.Viewer({
            container: document.querySelector('#equipment-image'),
            panorama: 'https://classroomsupport.usu.edu' + equipmentUrl,
            touchmoveTwoFingers: true,
        });
    })

    /**
     * On modal close, remove all the equipment, and images from the modal.
     */
    $('#exampleModal').on('hidden.bs.modal', function (event) {
        //room viewer and equipment viewer
        document.querySelector('#room-image').innerHTML = "";
        document.querySelector('#equipment-image').innerHTML = "";
        document.querySelector('#equipment').innerHTML = "";
    });
});


/**
 * search
 * Grabs the values from the search form and sends the inputs to the controller.
 * Returns the results from the database and displays them on the page.
 */
function search() {
    let resultsArea = document.getElementById("results");
    resultsArea.innerHTML = "";

    let building = document.getElementById("building").value;
    let technologies = [];

    var inputElements = document.getElementsByName('technology');

    for(var i=0; inputElements[i]; ++i){
        if(inputElements[i].checked){
            technologies.push(inputElements[i].value);
        }
    }

    $.get("/_resources/dev/classroom-search/controller.php", {search: true, building: building, technologies: technologies, minCapacity: minCapacity, maxCapacity: maxCapacity}, function(data) {
        let result = document.createElement("p");
        result.innerHTML = data;
        resultsArea.appendChild(result);
    });


}





