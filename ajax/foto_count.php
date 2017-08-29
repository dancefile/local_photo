<?
session_start();

switch(substr($_POST['id'], 0,2)) {
	case 'cd':
	case 'a6':	
	case 'a5':
	case 'a4':
	 $_SESSION[substr($_POST['id'], 0,2)][substr($_POST['id'], 2)]=$_POST['val'];
	 break;
	case 'co':
	 $_SESSION['comm'][substr($_POST['id'], 4)]=$_POST['val'];
     break;
	 	case 'ma':
	 $_SESSION['mail']=$_POST['val'];
     break;
	case 'ko':
	 $_SESSION['korprice'][substr($_POST['id'], 8)]=$_POST['val'];
     break;
}
