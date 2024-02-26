<?php

namespace Core\Traits;
use \PDO;
use function Core\db;

trait Queryable
{
    static public string|null $tableName = null;
    static protected string $query = '';
    protected array $commands = [];

    public static function __callStatic(string $method, array $args)
    {
        if (in_array($method, ['where'])) {
            $obj = static::select();
            return call_user_func_array([$obj, $method], $args);
        }

        return call_user_func_array([new static, $method], $args);
    }

    public function __call(string $name, array $arguments)
    {
        // TODO: Implement __call() method.
    }

    static public function select(array $columns = ['*']): static
    {
        static::resetQuery();
        static::$query = "SELECT " . implode(', ', $columns) . " FROM " . static::$tableName . " ";

        $obj = new static;
        $obj->commands[] = 'select';
        return $obj;
    }

    static public function all(): array
    {
        return static::select()->get();
    }

    public static function find(int $id): static|false
    {
        $query = db()->prepare("SELECT * FROM " . static::$tableName . " WHERE `id` = :id");
        $query->bindParam('id', $id);
        $query->execute();

        return $query->fetchObject(static::class);
    }

    public static function findBy(string $column, mixed $value): static|false
    {
        $query = db()->prepare("SELECT * FROM " . static::$tableName . " WHERE $column = :$column");
        $query->bindParam($column, $value);
        $query->execute();

        return $query->fetchObject(static::class);
    }

    public static function create(array $fields): null|static
    {
        $params = static::prepareQueryParams($fields);
        $query = db()->prepare("INSERT INTO " . static::$tableName . " ($params[keys]) VALUES ($params[placeholders])");

        if (!$query->execute($fields)) {
            return null;
        }
        return static::find(db()->lastInsertId());
    }

    static protected function prepareQueryParams(array $fields): array
    {
        $keys = array_keys($fields);
        $placeholder = preg_filter('/^/', ':', $keys);

        return [
            'keys' => implode(', ', $keys),
            'placeholders' => implode(', ', $placeholder)
        ];
    }
    static protected function resetQuery(): void
    {
        static::$query = '';
    }

    public function get()
    {
        return db()->query(static::$query)->fetchAll(PDO::FETCH_CLASS, static::class);
    }

//    static protected function where(string $column, string $operator, $value = null): static
//    {
//        if ($this->prevent('group', 'limit'))
//
//        $obj = in_array('select', $this->commands)
//
//        if (
//            !is_null($value) &&
//            !is_bool($value) &&
//            !is_array($value) &&
//            !is_numeric($value)
//        ) {
//            $value = "'$value'";
//        }
//
//        if (is_null($value)) {
//            $value = "NULL";
//        }
//
//        if (is_array($value)) {
//            $value = array_map(fn($item) => is_string($item) && $item !== "NULL" ? "'$value'" : $item, $value);
//            $value = '(' . implode(', ', $value) . ')';
//        }
//
//        if (!in_array('where', $obj->commands)) {
//            static $query .=
//        }
//    }
//
//    public function and(string $column, string $operator = '=', $value = null)
//    {
//        if (!in_array('where', $this->commands))
//        static::$query .= 'AND';
//
//    }
//
//    public function orderBy(string $column, string $operator = '=', $value = null)
//    {
//        $this->commands[] = 'order';
//        $lastKey = array_key_last($columns);
//        static::$query .= " ORDER BY ";
//
//    }
//
//    public function update(array $fields): static
//    {
//        $query = "UPDATE " . static::$tableName . " SET " . 'placeholder' . " WHERE id=:id";
//        return static::find($this->id);
//    }
//
//    public function exists()
//    {
//        if (!$this->prevent('select')) {
//
//        }
//    }
//
//    public function sql()
//    {
//
//    }
//
//    public function update()
//    {
//
//    }
//
//    protected function prevent(array $allowedMethods)
//    {
//        foreach ($allowedMethods as $method) {
//
//        }
//    }
}