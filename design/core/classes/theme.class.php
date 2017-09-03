<?php
    class theme{
        public function load($file){
            self::exist($file);
        }

        public function exist($file){
            $list = array(".theme.php", ".php", ".tmp.php", ".tmp");

            foreach($list as $item){
                if(file_exists("./core/theme/".$file.$item)){
                    include("./core/theme/".$file.$item);
                    return true;
                }
                if(file_exists("./core/pages/".$file.$item)){
                    include("./core/pages/".$file.$item);
                    return true;
                }
            }
            return false;
        }

        public function admin(){
            session_start();
            if ($_SERVER["SERVER_PORT"] != 777){
                die();
            }

            if(!$_SESSION['auth'])
            {
                header("Location: ?p=/admin/login");
                die();
            }
        }

    }
?>