<?php

$todos = new App\ToDo();
$bot = new App\Bot();
$users= new App\Users();


$update = json_decode(file_get_contents('php://input'));
if ($update) {
    $chatId = $update->message->chat->id;

    if ($update->message->text === '/start') {
        $bot->makeRequest('sendMessage', [
            'chat_id' => $chatId,
            'text' => "To see a task, type the task's ID."
        ]);
        exit();
    }
    if (mb_stripos($update->message->text, '/start') !== false) {
        $userId = trim(explode('/start', $update->message->text)[1]);
        $users->setTelegramId($userId,$chatId);
        exit();
    }
    if ($update->message->text === '/tasks') {
        $tasks = $todos->getTodoByTelegramId($chatId);
        $taskList = "Your tasks:\n\n";
        foreach ($tasks as $task) {
            $taskList .= $task['title']."\n";
            $taskList .= $task['due_date']."\n";
            $taskList .= $task['status']."\n\n";
            $taskList .= "**********************\n\n";
        }
        $bot->makeRequest('sendMessage', [
            'chat_id' => $chatId,
            'text' => $taskList
        ]);
    }
}
