<?php

namespace App\Transformers;

// use App\Values\Item;
// use App\Values\Value;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class TransformerAbstract
{
    protected array $defaultFields = [];

    public function __construct(protected Collection | Model | array | null $model)
    {
    }

    public static function make(Collection | Model | array | null $model)
    {
        return new static($model);
    }

    public function transform(array $fields = []): array
    {
        if ($this->model === null) {
            return [];
        }

        if ($this->model instanceof Collection) {
            return $this->fromCollection($fields);
        }

        if (is_array($this->model)) {
            return $this->fromArray($fields);
        }

        if (empty($fields)) {
            $fields = $this->defaultFields;
        }

        $data = [];
        foreach ($fields as $field) {
            $data[$field] = $this->getField($field);
        }

        return $data;
    }

    public function transformField(string $field)
    {
        $data = $this->transform([$field]);

        return isset($data[$field]) ? $data[$field] : null;
    }

    protected function fromCollection(array $fields): array
    {
        $models = $this->model;

        return $models->map(function ($item) use ($fields) {
            return static::make($item)->transform($fields);
        })->all();
    }

    protected function fromArray(array $fields): array
    {
        $models = $this->model;

        return array_map(function ($item) use ($fields) {
            return static::make($item)->transform($fields);
        }, $models);
    }

    protected function getField($field)
    {
        return $this->fields($field, $this->model);
    }
}
