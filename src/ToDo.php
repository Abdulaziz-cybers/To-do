<?php
namespace App;

class ToDo
{
    public DB $db;
    public function __construct(){
        $this->db = new DB();
    }
    public function store(string $title, string $dueDate,int $id): bool
    {
        $sql = "INSERT INTO todos (title, status, due_date,created_at,updated_at,user_id) VALUES (?, ?, ?,NOW(),NOW(),?)";
        $stmt = $this->db->pdo->prepare($sql);
        return $stmt->execute([$title, 'pending', $dueDate,$id]);
    }
    public function storeTest(string $title, string $dueDate): bool
    {
        $sql = "INSERT INTO todos (title, status, due_date,created_at,updated_at) VALUES (?, ?, ?,NOW(),NOW())";
        $stmt = $this->db->pdo->prepare($sql);
        return $stmt->execute([$title, 'pending', $dueDate]);
    }
    public function getAllTodosOfUser($id): false|array
    {
        $sql = "Select * from todos where user_id=:id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute([':id'=>$id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getTodosWithoutU(): false|array
    {
        $sql = "Select * from todos where user_id is NULL";
        $stmt = $this->db->pdo->query($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function edit(int $id): false|array
    {
        $sql = "Select * from todos where id=:id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM todos WHERE id =:id";
        return $this->db->pdo->prepare($sql)->execute([
            'id' => $id
        ]);
    }
    public function update(int $id, string $title, string $status,string $dueDate): bool
    {
        $dueDate = new \DateTime();
        $sql = "UPDATE todos set title=:title,status=:status,due_date=:due_date,updated_at=NOW() where id=:id";
        $dueDate = $dueDate->format('Y-m-d H:i:s');
        $stmt = $this->db->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'title' => $title,
            'status' => $status,
            'due_date' => $dueDate
        ]);
    }
    public function updateStatus(int $id, string $status): bool
    {
        $sql = "UPDATE todos set status=:status,updated_at=NOW() where id=:id";
        $stmt = $this->db->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'status' => $status
        ]);
    }
    public function updateTitle(int $id, string $title): bool
    {
        $sql = "UPDATE todos set title=:title,updated_at=NOW() where id=:id";
        $stmt = $this->db->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'title' => $title
        ]);
    }
    public function getIDs(): false|array
    {
        $sql = "SELECT GROUP_CONCAT(id) AS id_list FROM todos";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result && isset($result['id_list'])
            ? explode(',', $result['id_list'])
            : false;
    }
    public function getTodoByTelegramId(int $telegramId): false|array
    {
        $sql = "Select todos.title, todos.status,todos.due_date,todos.id as task_id from todos INNER JOIN users on todos.user_id = users.id where users.telegram_id = :telegramId";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute([':telegramId' => $telegramId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

