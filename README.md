# Hyperf Elasticsearch 
根据 [crcms/elasticsearch](https://github.com/crcms/elasticsearch) 改造的基于Hyperf框架的ElasticSearch组件。

| Elasticsearch Version | hzx/elasticsearch  |
| --------------------- | ------------------------ |
| > = 7.0                | master(beta unstable)                      |
| > = 6.0                | 1.*                      |
| > = 5.0, < 6.0         | 0.*                      |

## 1、安装

```
composer require hzx/elasticsearch
```



### 2、发布配置

```php
php bin/hyperf.php elasticsearch:publish --config 
或
php bin/hyperf.php vendor:publish hzx/elasticsearch
```


### 使用：

```php
$esf = new ElasticsearchFactory();
$builder = $esf->builder()->index('index')->whereTerm('id', '1')->first();
```


```php
$builder->index('index')->type('type')->create([
    'key' => 'value'
]);

// return a collection
$builder->index('index')->type('type')->createCollection([
    'key' => 'value'
]);
```

### Update

```php
$builder->index('index')->type('type')->update([
    'key' => 'value1'
]);

```

### Delete

```php
$builder->index('index')->type('type')->delete($result->_id);
```

### Select

```php

$builder = $builder->index('index')->type('type');
	
//SQL:select ... where id = 1 limit 1;
$result = $builder->whereTerm('id',1)->first();

//SQL:select ... where (key=1 or key=2) and key1=1
$result = $builder->where(function (Query $inQuery) {
    $inQuery->whereTerm('key',1)->orWhereTerm('key',2)
})->whereTerm('key1',1)->get();

```

skip / take

```php
$builder->take(10)->get(); // or limit(10)
$builder->offset(10)->take(10)->get(); // or skip(10)
```

term query

```php
$builder->whereTerm('key',value)->first();
```

match query

```php
$builder->whereMatch('key',value)->first();
```

range query

```php
$builder->whereBetween('key',[value1,value2])->first();
```

where in query

```php
$builder->whereIn('key',[value1,value2])->first();
```

logic query

```php
$builder->whereTerm('key',value)->orWhereTerm('key2',value)->first();
```

nested query

```php
$result = $builder->where(function (Builder $inQuery) {
    $inQuery->whereTerm('key',1)->orWhereTerm('key',2)
})->whereTerm('key1',1)->get();
```

### 条件

```php
public function select($columns): self
```

```php
public function where($column, $operator = null, $value = null, $leaf = 'term', $boolean = 'and'): self
```

```php
public function orWhere($field, $operator = null, $value = null, $leaf = 'term'): self
```

```php
public function whereMatch($field, $value, $boolean = 'and'): self
```

```php
public function orWhereMatch($field, $value, $boolean = 'and'): self
```

```php
public function whereTerm($field, $value, $boolean = 'and'): self
```

```php
public function whereIn($field, array $value)
```

```php
public function orWhereIn($field, array $value)
```

```php
public function orWhereTerm($field, $value, $boolean = 'or'): self
```

```php
public function whereRange($field, $operator = null, $value = null, $boolean = 'and'): self
```

```php
public function orWhereRange($field, $operator = null, $value = null): self
```

```php
public function whereBetween($field, array $values, $boolean = 'and'): self
```

```php
public function whereNotBetween($field, array $values): self
```

```php
public function orWhereNotBetween(string $field, array $values): self
```

```php
public function whereExists($field, $boolean = 'and'): self
```

```php
public function whereNotExists($field, $boolean = 'and'): self
```

```php
public function orWhereBetween($field, array $values): self
```

```php
public function orderBy(string $field, $sort): self
```

```php
public function scroll(string $scroll): self
```

```php
public function aggBy($field, $type): self
```

```php
public function select($columns): self
```

### 方法

```php
public function get(): Collection
```

```php
public function paginate(int $page, int $perPage = 15): Collection
```

```php
public function first()
```

```php
public function byId($id)
```

```php
public function byIdOrFail($id): stdClass
```

```php
public function chunk(callable $callback, $limit = 2000, $scroll = '10m')
```

```php
public function create(array $data, $id = null, $key = 'id'): stdClass
```

```php
public function update($id, array $data): bool
```

```php
public function delete($id)
```

```php
public function count(): int
```