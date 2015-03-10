The ApiFactory
==============

This class instantiate "[Api classes](api_classes.md)" when you use it like that thanks to the magic method `call`:

```php
<?php

$apiFactory->getMyAwesomeApi();
```

So the first thing you have to do when building your API is to extend it and implement the only needed method.

You can also:

* Redefine the `getTransformer` method to change the default one.

Now, build your [API classes](api_classes.md).
