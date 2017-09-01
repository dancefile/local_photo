<?php theme::load("head"); ?>
<?php theme::load("header"); ?>  
<div id="content" class="content"> 
    <!-- body start -->
    <div class="container" style="margin-top: 25px">
        <?php foreach($_SESSION['name'] as $i => $value){?>
            <div class="col-md-6">
                <div class="col-md-6 text-center;">
                    <a href="javascript:openPhoto('<?=$_SESSION['url'][$i]?>', '<?=$_SESSION['name'][$i]?>');" class="photo panel col-xs-6 col-sm-3 col-md-2 pull-right" style="margin: 0px;"><img src="/ph/<?=$_SESSION['url'][$i]?>/<?=$_SESSION['name'][$i]?>.jpg"><div class="name"><?=$_SESSION['name'][$i]?></div><div class="delete_photo">Удалить</div></a>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12 btn-group" style="margin-bottom: 5px;">
                        <label class="btn btn-default">
                            <input type="checkbox" class="btn btn-primary"  name="<?=$_SESSION['name'][$i]?>" style="margin-top: -1px;"> Запись на CD/Flash/Email
                        </label>
                    </div>

                    <div class="col-md-12" style="margin-bottom: 5px;">
                        A6
                        <div class="btn-group pull-right">
                            <button class="btn btn-danger" onclick="minus('a6', '<?=$_SESSION['name'][$i]?>')">-</button>
                            <input class="btn btn-default" value="<?=$_SESSION['a6'][$i]?>" name="<?=$_SESSION['name'][$i]?>" id="a6_<?=$_SESSION['name'][$i]?>" style="width:70px" placeholder="0">
                            <button class="btn btn-primary" onclick="plus('a6', '<?=$_SESSION['name'][$i]?>')">+</button>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-bottom: 5px;">
                        A5
                        <div class="btn-group pull-right">
                            <button class="btn btn-danger" onclick="minus('a5', '<?=$_SESSION['name'][$i]?>')">-</button>
                            <input class="btn btn-default" value="<?=$_SESSION['a5'][$i]?>" name="<?=$_SESSION['name'][$i]?>" id="a5_<?=$_SESSION['name'][$i]?>" style="width:70px" placeholder="0">
                            <button class="btn btn-primary" onclick="plus('a5', '<?=$_SESSION['name'][$i]?>')">+</button>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-bottom: 5px;">
                        A4
                        <div class="btn-group pull-right">
                            <button class="btn btn-danger" onclick="minus('a4', '<?=$_SESSION['name'][$i]?>')">-</button>
                            <input class="btn btn-default" value="<?=$_SESSION['a4'][$i]?>" name="<?=$_SESSION['name'][$i]?>" id="a4_<?=$_SESSION['name'][$i]?>" style="width:70px" placeholder="0">
                            <button class="btn btn-primary" onclick="plus('a4', '<?=$_SESSION['name'][$i]?>')">+</button>
                        </div>
                    </div>
                    
                    <div class="col-md-12 btn-group-vertical" style="margin-bottom: 30px;">
                        <textarea class="form-control" type="text" style="width: 209px;" placeholder="Коментарий"><?=$_SESSION['comm'][$i]?></textarea>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div style="width: 100%; margin-top: 200px"></div>
<!-- body end -->
</div>
<footer>
    <div class="container text-center">
        <div class="btn-group">
        <button class="btn btn-default" style="width: 246px;"><h5>Оформить заказ</h5></button>
            <div class="btn btn-dark" style="width: 246px;"><h5><span id="sum">0</span> рублей</h5></div>
            <button class="btn btn-default" style="width: 246px;"><h5>Оформить заказ</h5></button>
        </div>
    </div>
</footer>
<?php theme::load("live"); ?>
<?php theme::load("price"); ?>
<?php theme::load("calendars"); ?>
<?php theme::load("footer"); ?>