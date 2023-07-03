<div class="container container-narrow">
    <h2>Campuses</h2>
    <div class="row">
        <div class="col-lg-12">
            <ul class="listcol-md-2">
                <?php foreach($arrCampusList as $arrCampus){
                    $strCampusUrl = str_replace(' ', '-', strtolower($arrCampus['name']));
                    ?>
                    <li>
                        <a href="<?php echo "https://classroomsupport.usu.edu/development/classroom_information/admin/" . $strCampusUrl; ?>"><?php echo $arrCampus['name']; ?></a>
                    </li>

                <?php } ?>

            </ul>

        </div>
    </div>
</div>