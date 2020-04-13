<?php

require('db.php');

if(!empty($_POST)){
	extract($_POST);
	$id = strip_tags($id);
	$task = strip_tags($task);

	$req = $bdd->prepare('UPDATE tasks SET name = :name WHERE id = :id');
	$req->execute(array(':id'=>$id, ':name'=>$task));
	$req->closeCursor();

	$response = array('success'=>true, 'task'=>$task);
	echo json_encode($response);
}
?>