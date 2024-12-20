<?php
/** @var TYPE_NAME $id */
$todo = (new App\ToDo())->update($id,$_POST['title'],$_POST['status'],$_POST['due_date']);
header('Location: /todos');

exit();