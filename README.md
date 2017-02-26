# php-persistence
Minimalistic persistence API

## Propostas

### Configuração - Datasource

- Json
```json
{
  "name": "Nome DS",
  "driver": "NomeClasseDoDriver",
  "configs": {
    ... Configurações do Driver ...
  }
}
```

- Array PHP

### Componentes

```php
$repo = new Repository("nome-ds");

$repo->query("nome_entidade")
    ->col("col_a", "col_b")
    ->where(Where::createExample($arr))
    ->order("col_a")
    ->limit(1, 100)
    ->execute();
```