<?
session_start();
if (isset($_SESSION['sort'])) {unset($_SESSION['sort']);} else {$_SESSION['sort']=1;};
