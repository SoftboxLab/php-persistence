# PHP Persistence
[![Build Status](https://travis-ci.org/SoftboxLab/php-persistence.svg?branch=master)](https://travis-ci.org/SoftboxLab/php-persistence)
[![Coverage Status](https://coveralls.io/repos/github/SoftboxLab/php-persistence/badge.svg?branch=master)](https://coveralls.io/github/SoftboxLab/php-persistence?branch=master)
[![StyleCI](https://styleci.io/repos/83156250/shield?branch=master)](https://styleci.io/repos/83156250)
[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](https://raw.githubusercontent.com/SoftboxLab/php-persistence/master/LICENSE)

Minimalistic persistence API

##Prerequisites

 - PHP 5.6 or above

## Configuration

- Json

```json
{
  "name": "Data source name",
  "driver": "Driver Name",
  "configs": {
    ... Driver configs ...
  }
}
```

- PHP Array

### Components

```php
$repo = new Repository("nome-ds");

$repo->query("entity_name")
    ->col("col_a", "col_b")
    ->where(Where::createExample($arr))
    ->order("col_a")
    ->limit(1, 100)
    ->execute();
```
