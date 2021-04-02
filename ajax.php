<?php
session_start();
	require_once 'functions.php';
	echo $_REQUEST['sr'];
	if($_REQUEST['sr'] != '') {
		$_SESSION['specs']['sr']=$_REQUEST['sr'];
	}
	
	if($_REQUEST['bs'] != '') {
		$_SESSION['specs']['bs']=$_REQUEST['bs'];
	}
	
	if($_REQUEST['cd'] != '') {
		$_SESSION['specs']['cd']=$_REQUEST['cd'];
		print_r($_SESSION['specs']);
	}
	
	if($_REQUEST['js'] != '') {
		$_SESSION['specs']['js']=$_REQUEST['js'];
		print_r($_SESSION['specs']);
	} 
	
	if($_REQUEST['jv'] != '') {
		$_SESSION['specs']['jv']=$_REQUEST['jv'];
		print_r($_SESSION['specs']);
	} 
	
	
	if($_REQUEST['ck'] != '') {
		$_SESSION['specs']['ck']=$_REQUEST['ck'];
		print_r($_SESSION['specs']);
	} 
	
	if($_REQUEST['sl'] != '') {
		$_SESSION['specs']['sl']=$_REQUEST['sl'];
		print_r($_SESSION['specs']);
	} 
	
	
	if($_REQUEST['fv'] != '') {
		$_SESSION['specs']['fv']=$_REQUEST['fv'];
		print_r($_SESSION['specs']);
	} 
	
	  ?>