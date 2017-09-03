<?php
class basket{
    public function _construct(){
        
    }

    public function _SESSION_get(){
        if(isset($_SESSION['name'])){
            return $_SESSION['name'];
        }
    }
}