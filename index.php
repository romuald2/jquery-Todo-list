<?php
  require('db.php');

  if(!empty($_POST['task'])){
    $task = strip_tags($_POST['task']);
    if($task != ''){
      $req = $bdd->prepare('INSERT INTO tasks (name) VALUES (:name)');
      $req->execute(array(':name'=>$task));
      $id = $bdd->lastInsertId();
      $req->closeCursor();

      $response = array(
        'success'=>true,
        'task'=>$task,
        'id'=>$id
      );
      echo json_encode($response);exit;
    }
  }

  $req = $bdd->prepare('SELECT * FROM tasks ORDER BY id DESC');
  $req->execute();
  $tasks = $req->fetchAll(PDO::FETCH_OBJ);
  $req->closeCursor();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Todo list en AJAX</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
    body{
      padding-top: 100px;
    }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Todo list en AJAX</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
        <!--
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        -->
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

    <form id="form" action="index.php" method="post">
    <input type="text" name="task" id="task" placeholder="Tache" class="form-control">
    <br>
    <input type="submit" class="btn btn-success" value="Ajouter">
    </form>

    <br>

    <form id="deleteForm" action="delete.php" method="post">
    <table class="table">
    <thead>
      <tr>
        <th>Tache</th>
        <th><input type="checkbox" id="checkAll"></th>
      </tr>
    </thead>
    <tbody>
      <?php if($tasks):
      foreach($tasks as $t):?>
        <tr id="<?=$t->id;?>">
            <td class="tache"><?=$t->name;?></td>
            <td><input type="checkbox" id="<?=$t->id;?>" class="del" name="tasks[]" value="<?=$t->id;?>"></td>
        </tr>
      <?endforeach; endif;?>
    </tbody>
    </table>

    <button id="button" class="btn btn-danger">Supprimer les taches</button>
    </form>
    
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>
