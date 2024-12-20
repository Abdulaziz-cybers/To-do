<?php

$todos = new App\ToDo();
$bot = new App\Bot();
$users= new App\Users();

$redis = new Redis();
$redis->connect('127.0.0.1');

$update = json_decode(file_get_contents('php://input'));

$callbackQuery = $update->callback_query;
$callbackQueryId = $callbackQuery->id;
$callBackData = $callbackQuery->data;
$callBackUserId = $callbackQuery->from->id;
$callBackChatId = $callbackQuery->message->chat->id;
$callBackMessageId = $callbackQuery->message->message_id;

if ($callbackQuery){
    if (mb_strpos($callBackMessageId, 'edit_') !== false){
        $taskId = explode('edit_', $callBackMessageId)[1];
        $redis->set('edit_' . $callBackChatId, $taskId);

        $bot->makeRequest('editMessageText', [
            'chat_id' => $callBackChatId,
            'message_id' => $callBackMessageId,
            'text' => 'Enter new task title'
        ]);
    }
    if (mb_stripos($callBackData,'task_')!==false){
        $taskId = explode('task_',$callBackData)[1];
        $todo = $todos->edit($taskId);
        try {
            $bot->makeRequest('editMessageText', [
                'chat_id' => $callBackChatId,
                'message_id' => $callBackMessageId,
                'text' => "Edit task",
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['callback_data' => 'complete_' . $todo['id'], 'text' => 'Complete'],
                            ['callback_data' => 'in_progress_' . $todo['id'], 'text' => 'In progress'],
                            ['callback_data' => 'pending_' . $todo['id'], 'text' => 'Pending']
                        ]
                    ]
                ])
            ]);
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {

        }
    }
    if (mb_stripos($callBackData,'complete_')!==false){
        $taskId = explode('complete_',$callBackData)[1];
        $todos->updateStatus((int)$taskId,'completed');
    }
    if (mb_stripos($callBackData,'in_progress_')!==false){
        $taskId = explode('in_progress_',$callBackData)[1];
        $todos->updateStatus((int)$taskId,'in_progress');
    }
    if (mb_stripos($callBackData,'pending_')!==false){
        $taskId = explode('pending_',$callBackData)[1];
        $todos->updateStatus((int)$taskId,'pending');
    }
}

if ($update) {
    $chatId = $update->message->chat->id;
    $text = $update->message->text;
    if ($update->message->text === '/start') {
        try {
            $bot->makeRequest('sendMessage', [
                'chat_id' => $chatId,
                'text' => "To see a task, type the task's ID."
            ]);
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {

        }
        exit();
    }
    if (mb_stripos($update->message->text, '/start') !== false) {
        $userId = trim(explode('/start', $update->message->text)[1]);
        $users->setTelegramId($userId,$chatId);
        exit();
    }
    if ($update->message->text === '/tasks') {
        try {
            $bot->sendUserTasks($chatId);
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {

        }
    }
    if ($text && $redis->get('edit_' . $chatId)) {
        $todos->updateTitle($redis->get('edit_' . $chatId), $text);
        $bot->makeRequest('sendMessage', [
            'chat_id' => $chatId,
            'text' =>   'title updated'
        ]);
        $redis->del('edit_' . $chatId);
    }
}
