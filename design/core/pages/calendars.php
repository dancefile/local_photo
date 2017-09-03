    <!-- calendars page start -->
    <div id="calendars_page" class="page hidden">
        <div class="container">
            <!-- page content -->
            <div class="col-md-12">
                <h1>Календари</h1>
                <div class="col-md-12">
                <?php
                    include("config.php");
                    $od = scandir("./assets/img/calendars/");
                    $start = 0; $end = 0;
                    foreach($od as $cal){
                        if($cal != "." and $cal != ".." and $cal != "[Originals]"){
                            if(substr($cal, 0) == 1 and $start == 0){
                                echo "<div class='col-md-12'>";
                                $start = 1;
                            }
                            if(substr($cal, 0) == 2 and $end == 0){
                                echo "</div><div class='col-md-12'>";
                                $end = 1;
                            }
                            $name = str_replace("1-", "", $cal);
                            $name = str_replace("2-", "", $name);
                            $name = str_replace(".jpg", "", $name);
                            $name = str_replace("k", "", $name);
                        ?>
                            <div class="photo panel btn" style="min-height: auto;height: auto;position: relative;width: 220px;padding: 0;background-color: rgba(255,255,255,0.1);">
                                <img style="width: 218px;height:auto;margin: 0;border-top-left-radius: 5px;border-top-right-radius: 5px;"  src="./assets/img/calendars/<?=$cal?>">
                                <div class="name"><h4><smal>Календарь №</small><?=$name?></h4></div>
                            </div>
                        <?php }
                    }
                ?>
                </div>
                </div>
                <h1>Рамки</h1>
            </div>
            <!-- page content end -->
        </div>
    </div>
    <!-- calendars page end -->