<?php

namespace App\Core\Support;

use App\Core\DB;

trait QueryBuilder
{
    protected $where = [];
    protected $whereString = "";
    protected DB $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function create($data = [])
    {
        return $this->execQueryByAction('insert', $data);
    }

    public function update($data = [])
    {
        return $this->execQueryByAction('update', $data);
    }

    public function delete(...$primaryKeyValues)
    {
        $this->whereIn($this->primaryKey, $primaryKeyValues);
        return $this->execQuery("DELETE FROM `{$this->getTable()}`{$this->whereString}");
    }

    public function save($data = [])
    {
        $this->fill($data);
        return $this->isNeedToUpdate() ? $this->update($data) : $this->create($data);
    }

    public function where($column, $value, $operator = "=")
    {
        $this->where[] = "`$column` $operator {$this->fixWhereValue($value)}";
        $this->whereString = " WHERE ".implode(" AND ", $this->where);
        return $this;
    }

    public function whereIn($column, $values)
    {
        $this->where($column, $values, 'IN');
        return $this;
    
    }
    public function whereNotIn($column, $values)
    {
        $this->where($column, $values, 'IN');
        return $this;
    }

    public function find($primaryKeyValue)
    {
        $this->where($this->primaryKey, $primaryKeyValue);
        return $this->first();
    }

    public function findOr($primaryKeyValue, $callback)
    {
        $this->where($this->primaryKey, $primaryKeyValue);
        return $this->firstOr($callback);
    }

    public function findOrFail($primaryKeyValue)
    {
        $this->where($this->primaryKey, $primaryKeyValue);
        return $this->firstOrFail();
    }

    public function first()
    {
        return $this->fetch() ?: null;
    }

    public function firstOr($callback)
    {
        return $this->fetch() ?: $callback();
    }

    public function firstOrFail()
    {
        return $this->fetch() ?: abort(404);
    }

    public function get()
    {
        return $this->fetchAll();
    }

    protected function fetch()
    {
        return $this->result()->fetch(\PDO::FETCH_OBJ);
    }

    protected function fetchAll()
    {
        return $this->result()->fetchAll(\PDO::FETCH_CLASS);
    }

    protected function result()
    {
        $result = $this->db->query($this->selectQuery());
        $this->reset();
        return $result;
    }

    protected function fixWhereValue($value)
    {
        if (gettype($value) == "array") {
            foreach ($value as $key => $val)  $value[$key] = $this->fixWhereValue($val);
            return "(".implode(',', $value).")";
        }
        if (gettype($value) == "string") return "'$value'";
        return $value;
    }
    
    protected function insertQuery()
    {
        $columns = implode(', ', array_keys($this->getAttributes()));
        $bindingsMarks = implode( ", ", array_fill(0, count($this->getAttributes()), "?" ));
        return "INSERT INTO `{$this->getTable()}` ($columns) VALUES ($bindingsMarks)";
    }

    protected function updateQuery()
    {
        $columns = implode(' = ?, ', array_keys($this->getAttributes())).' = ?';
        $this->where($this->primaryKey, $this->getPrimaryKeyValue());
        return "UPDATE `{$this->getTable()}` SET $columns{$this->whereString}";
    }

    protected function selectQuery($columns = '*')
    {
        return "SELECT $columns FROM `{$this->getTable()}`{$this->whereString}";
    }

    protected function execQueryByAction($action, $data = [])
    {
        $this->fill($data);
        $this->execQuery($this->{$action."Query"}());
        return $this->find($action == "insert" ? $this->db->lastInsertId() : $this->getPrimaryKeyValue());
    }

    protected function execQuery($query)
    {
        return $this->db->query($query, array_values($this->getAttributes()));
    }

    protected function isNeedToUpdate()
    {
        return $this->getPrimaryKeyValue() ? (bool) $this->find($this->getPrimaryKeyValue()) : false;
    }

    protected function reset()
    {
        $this->where = [];
        $this->whereString = "";
    }
}