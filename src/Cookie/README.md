# Esthetio Framework: Cookie

The tiny Cookie container which may help you to collect and apply cookies to the response. It's recommended to use it in a middleware.

### Example

```php
<?php

use Esthetio\Cookie\CookieJarImpl;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

$cookies  = new CookieJarImpl();
$response = new Response();

$cookies->add(new Cookie('beauty', 'is a sign of intelligence'));

foreach ($cookies->flush() as $cookie) {
    $response->headers->setCookie($cookie);
}
```
