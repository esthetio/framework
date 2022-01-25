# Esthetio Framework: Config

The extremely simple container for a PHP array with an ability to access values through their paths.

### Example

```php
<?php

use Esthetio\Config\ConfigImpl;

$config = new ConfigImpl(['foo' => ['bar' => 'baz']]);

$config->get('foo.bar'); // baz
```
