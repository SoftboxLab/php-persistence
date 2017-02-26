# php-persistence
Minimalistic persistence API

## Propostas

### Configuração - Datasource

- Json
- Array PHP

### Componentes

```php
$repo = new Repository("nome-ds");

$repo->query("nome_entidade")
    ->col("col_a", "col_b")
    ->where(Where::createExample($arr))
    ->orderBy("col_a")
    ->limit(1, 100)
    ->execute();
```