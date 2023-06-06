<h2>Results</h2>
<p class="mb-4"><?php echo count($arrResults) . " classrooms" ?></p>
<?php
$objCurrBuilding = "";
foreach($arrResults as $k => $objResult){
if($objResult->getBuildingName() != $objCurrBuilding){
if($k != 0){
    echo "</tbody></table>";
}
$objCurrBuilding = $objResult->getBuildingName();
echo "<h3 class='text-bright-light h4'>$objCurrBuilding</h3>";
?>
<table class="table table-sm">
    <thead>
    <tr>
        <th style="width: 20%">Seats</th>
        <th>Room</th>
    </tr>

    </thead>
    <tbody>

    <?php }?>


    <tr>
        <td><?php echo $objResult->getSeats() ?></td>
        <td><a class="modal-opener"  data-toggle="modal" data-target="#exampleModal" href="#"
               data-room-url="<?php echo $objResult->getRoomUrl() ?>"
               data-equipment-url="<?php echo $objResult->getEquipmentUrl() ?>"
               data-equipment="<?php echo $objResult->getEquipment() ?>"
               data-capacity="<?php echo $objResult->getSeats() ?>"

               data-roomname="<?php echo  $objResult->getBuildingName() . " " . $objResult->getFilterCode() . " " . $objResult->getRoomNumber() ?>"
            ><?php echo $objResult->getFilterCode() . " " . $objResult->getRoomNumber() ?></a></td>
    </tr>


    <?php } ?>


