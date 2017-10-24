<? 
session_start(); 
if (isset($_GET['del'])){
unset($_SESSION['name'][$_GET['del']]);
unset($_SESSION['cd'][$_GET['del']]);
unset($_SESSION['a6'][$_GET['del']]);
unset($_SESSION['a5'][$_GET['del']]);
unset($_SESSION['a4'][$_GET['del']]);
unset($_SESSION['comm'][$_GET['del']]);
unset($_SESSION['korprice'][$_GET['del']]);
if (count ($_SESSION['name'])==0) unset($_SESSION['name']);
};
if (isset($_GET['all'])){
unset($_SESSION['name']);
unset($_SESSION['cd']);
unset($_SESSION['a6']);
unset($_SESSION['a5']);
unset($_SESSION['a4']);
unset($_SESSION['comm']);
unset($_SESSION['korprice']);
}