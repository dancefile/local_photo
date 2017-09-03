    <!-- photo page start -->
    <div id="photo_page" class="page hidden">
        <div class="container">
            <!-- page content -->
            <div class="col-md-8 col-sm-6 col-xs-6 text-center">
                <img id="image" src="../img.jpeg?url=0&name=null">
            </div>
            <div class="col-md-4 col-sm-6 col-xs-6">
                <div class="block white col-md-12 hidden-sm sm-hidden" style="margin-bottom: 10px;">
                    <div class="text-center" style="width: 246px;background-color: rgba(0,0,0,0.3);padding-top: 5px;padding-bottom: 5px;" id="name">
                        Загрузка имени файла...
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4" style="margin-top: 7px;">
                    A6<span class="hidden-sm sm-hidden"> (10х15)</span>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 btn-group text-right" style="margin-bottom: 10px;">
                    <button class="btn btn-danger" onclick="minus('a6')">-</button>
                    <input class="btn btn-default" value="0" id="a6" style="width:70px" placeholder="0">
                    <button class="btn btn-primary" onclick="plus('a6')">+</button>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4" style="margin-top: 7px;">
                    A5<span class="hidden-sm sm-hidden"> (15х20)</span>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 btn-group" style="margin-bottom: 10px;">
                    <button class="btn btn-danger" onclick="minus('a5')">-</button>
                    <input class="btn btn-default" value="0" id="a5" style="width:70px" placeholder="0">
                    <button class="btn btn-primary" onclick="plus('a5')">+</button>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4" style="margin-top: 7px;">
                    A4<span class="hidden-sm sm-hidden"> (20х40)</span>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 btn-group" style="margin-bottom: 10px;">
                    <button class="btn btn-danger" onclick="minus('a4')">-</button>
                    <input class="btn btn-default" value="0" id="a4" style="width:70px" placeholder="0">
                    <button class="btn btn-primary" onclick="plus('a4')">+</button>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-4" style="margin-top: 7px;">
                    CD
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 btn-group" style="margin-bottom: 20px;">
                    <input type="checkbox" class="btn btn-primary" style="margin-top: 11px;">
                </div>
                
                <div class="col-md-12 btn-group-vertical" style="margin-bottom: 30px;">
                    <textarea class="form-control" type="text" style="width: 246px;" placeholder="Коментарий"></textarea>
                </div>

                <div class="col-md-12 btn-group-vertical" style="margin-bottom: 10px;">
                    <div class="btn btn-primary" style="width: 246px;">0 рублей</div>
                    <button class="btn btn-default" style="width: 246px;">Добавить в корзину</button>
                </div>
            </div>
            <!-- page content end -->
        </div>
    </div>
    <!-- photo page end -->