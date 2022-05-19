<?php

namespace App\Core;

class Model
{
    // public function __construct()
    // {
    //     $this->db = new \PDO('mysql:host=localhost;dbname=test', 'root', '');
    // }
    protected $table;

    public function create($data)
    {
        // $columns = implode(', ', array_keys($data));
        // $values = ':' . implode(', :', array_keys($data));
        // $sql = "INSERT INTO $this->table ($columns) VALUES ($values)";
        // $stmt = $this->db->prepare($sql);
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
            // $stmt->bindValue(":$key", $value);
        }
        // $stmt->execute();
        return $this;
        return $this->db->lastInsertId();
    }

}
