<?php

namespace Core\Traits;
use \PDO;
use function Core\db;
use Enums\SQL;
//use mysql_xdevapi\Expression;

trait Queryable
{
    static public string|null $tableName = null;
    static protected string $query = '';
    protected array $commands = [];

    static public function __callStatic(string $method, array $args): mixed
    {
        if (in_array($method, ['where'])) {
            $obj = static::select();
            return call_user_func_array([$obj, $method], $args);
        }

        return call_user_func_array([new static, $method], $args);
    }

    public function __call(string $method, array $args): mixed
    {
        if (!in_array($method, ['where'])) {
            throw new \Exception(static::class . ': Method not allowed', 500);
        }

        return call_user_func_array([$this, $method], $args);
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

    static public function destroy(int $id): bool
    {
        $query = db()->prepare("DELETE FROM " . static::$tableName . " WHERE id = :id");
        $query->bindParam('id', $id);
        return $query->execute();
    }

    static protected function resetQuery(): void
    {
        static::$query = '';
    }

    protected function where(string $column, SQL $operator = SQL::EQUAL, $value = null): static
    {
        if ($this->prevent(['group', 'limit', 'order', 'having'])) {
            throw new \Exception(static::class . ": WHERE can not be used after ['group', 'limit', 'order', 'having']");
        }
        $obj = in_array('select', $this->commands) ? $this : static::select();

        if (
            !is_null($value) &&
            !is_bool($value) &&
            !is_array($value) &&
            !is_numeric($value)
        ) {
            $value = "'$value'";
        }

        if (is_null($value)) {
            $value = SQL::NULL->value;
        }

        // WHERE `column` IN ('', '', 5)
        if (is_array($value)) {
            $value = array_map(fn($item) => is_string($item) && $item !== SQL::NULL->value ? "'$item'" : $item, $value);
            $value = '(' . implode(', ', $value) . ')';

        }

        if (!in_array('where', $obj->commands)) {
            static::$query .= ' WHERE';
        }

        static::$query .= " $column $operator->value $value";
        $obj->commands[] = 'where';

        return $obj;
    }

    public function get(): array
    {
        return db()->query(static::$query)->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    //додав false
    public function take(): static|false
    {
        $query = db()->prepare(static::$query);
        $query->setFetchMode(PDO::FETCH_CLASS, static::class);
        $query->execute();
        return $query->fetch();
    }

    public function pluck(string $column): array
    {
        $plucked = [];

        $result = db()->query(static::$query)->fetchAll();

        if (!empty($result)) {
//            $plucked = array_map(function ($item) use ($column) {
//                return $item[$column];
//            }, $result);
            $plucked = array_map(fn($item) => $item[$column], $result);
        }

        return $plucked;
    }

    public function join(string $table, array $conditions, string $type = 'LEFT'): static
    {
        if (!$this->prevent(['select'])) {
            throw new \Exception(static::class . ': JOIN can not be used before SELECT');
        }

        $this->commands[] = 'join';

        static::$query .= " $type JOIN $table ON ";

        $lastKey = array_key_last($conditions);

        foreach ($conditions as $key => $condition) {
            static::$query .= "$condition[left] $condition[operator] $condition[right]" . ($key !== $lastKey ? ' AND ' : '');
        }

        return $this;
    }

    public function and(string $column, SQL $operator = SQL::EQUAL, $value = null): static
    {
        if (!in_array('where', $this->commands)) {
            throw new \Exception(static::class . ': AND can not be used before WHERE');
        }

        static::$query .= ' AND';
        $this->openCondition();
        return $this->where($column, $operator, $value);
    }

    public function or(string $column, SQL $operator = SQL::EQUAL, $value = null): static
    {
        if (!in_array('where', $this->commands)) {
            throw new \Exception(static::class . ': OR can not be used before WHERE');
        }

        static::$query .= ' OR';
        $this->openCondition();
        return $this->where($column, $operator, $value);
    }

    public function orderBy(array $columns): static
    {
        if (!$this->prevent(['select'])) {
            throw new \Exception(static::class . ': ORDER BY can not be used before [select]');
        }
        $this->commands[] = 'order';
        $lastKey = array_key_last($columns);
        static::$query .= " ORDER BY ";

        foreach ($columns as $column => $order) {
            static::$query .= "$column $order" . ($column === $lastKey ? '' : ', ');
        }

        return $this;
    }

    public function update(array $fields): static
    {
        //" SET column=:column, column1=:column1"
        $query = "UPDATE " . static::$tableName . " SET " . $this->updatePlaceholders(array_keys($fields)) . " WHERE id=:id";
        $query = db()->prepare($query);

        $fields['id'] = $this->id;
        $query->execute($fields);

        return static::find($this->id);
    }

    protected function openCondition(): void
    {
        if (in_array('startCondition', $this->commands)) {
            static::$query .= ' (';
            unset($this->commands[array_search('startCondition', $this->commands)]);
        }
    }

    protected function updatePlaceholders(array $keys): string
    {
        $string = '';
        $lastKey = array_key_last($keys);

        foreach ($keys as $index => $key) {
            $string .= "$key = :$key" . ($lastKey === $index ? '' : ', ');
        }

        return $string;
    }

    public function exists(): bool
    {
        if (!$this->prevent(['select'])) {
            throw new \Exception(static::class . ': method [exists] can not be used before [select]');
        }

        return !empty($this->get());
    }

    public function startCondition(): static
    {
        $this->commands[] = 'startCondition';
        return $this;
    }

    public function endCondition(): static
    {
        $this->commands[] = 'endCondition';
        static::$query .= ')';
        return $this;
    }

    public function sql(): string
    {
        return static::$query;
    }

    protected function prevent(array $allowedMethods): bool
    {
        foreach ($allowedMethods as $method) {
            if (in_array($method, $this->commands)) {
                return true;
            }
        }

        return false;
    }
}