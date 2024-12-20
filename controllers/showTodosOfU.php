<?php
$tasks = (new App\ToDo())->getAllTodosOfUser($_SESSION['user']['id']);
require 'views/todos.php';