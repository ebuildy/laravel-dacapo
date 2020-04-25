<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

class Index
{
    private $tableName;
    private $columns;
    private $alias;
    private $type;

    /**
     * @param string $tableName
     * @param array $attributes
     */
    public function __construct(string $tableName, array $attributes)
    {
        $this->tableName = $tableName;
        $this->columns = $attributes['columns'];
        $this->alias = $attributes['alias'] ?? 'FK_'. uniqid(rand());
        $this->type = $attributes['type'] ?? 'index';
    }

    /**
     * @return string
     */
    public function getUpLine(): string
    {
        $str = $this->makeIndex();

        return '$table' . $str . ';';
    }

    /**
     * @return string
     */
    public function getDownLine(): string
    {
        $str = $this->makeDropIndex();

        return '$table' . $str . ';';
    }

    /**
     * @return string
     * @throws
     */
    private function makeIndex(): string
    {
        return Method::call($this->type, $this->columns, ...$this->alias ? [$this->alias] : []);
    }

    /**
     * @return string
     * @throws
     */
    private function makeDropIndex(): string
    {
        return Method::call('drop' . ucfirst($this->type), $this->alias ?: (array) $this->columns);
    }
}
