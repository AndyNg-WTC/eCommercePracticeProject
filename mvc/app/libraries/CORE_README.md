# Core.php
## Constructor method
### getURL method

1. The Core constructor sets the `$url` property by calling the `getUrl` method. The `$url` becomes an array with the first index being the `controller`, the second index the `method` and the remaining indexes as `parameters`. E.g. The URL `localhost/pages/about` would be put into an array `$url = ['Pages', 'about']`.

### Look for controller

2. Checks to see if a controller class exists with the name listed in the first index of the `$url` array and sets the `$currentController` property to that name. It then unlists the first index of `$url`.

### Require the controller

3. The controller is then required.

### Instantiate controller class

4. The controller class object is instantiated.

### Checks to see if the method exsists within the controller

5. A check to see if the method name listed in the second index of `$url` exists in the `$currentController` class, if so sets the `$currentMethod` property and unsets the second index of `$url`.

### Get parameters

6. If there are any remaining values in the `$url` array, then these would be set as prarameters and then the array would be re-indexed.

### call_user_func_array
7. From what I understand the `call_user_func_array()` sends arguments to the `$callback` (either an object/method).

 ```` php
 Syntax:
 call_user_func_array(callable $callback, array $args): mixed
 ````

The object/method then executes it's code with the arguments passed in the callback function.

In the case of my MVC project, we can reference the `$callback` by passing it as an array [object, method] where the first index is the `object` and the second index is the `method`.
``` php
call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
```
In my code, before the callback function is used, we instantiate the currentController object, making it callable. Before I instantiated the object, `$this->currentController` was a string:

``` php
        // Instantiate controller class
        $this->currentController = new $this->currentController;        # Object created
```

To put it into simple terms, my callback function is saying:
``` php
call_user_func_array ($currentClass->$currentMethod(), $parameters)
```

After the constructor method has ran, we end up with something that resembles the following when we load the web page:
``` php
 $currentController->$currentMethod($params);
```

An example is when I visit `localhost/pages/about`, my constructor method will instantiate a `Pages` object using the `Pages` class and then execute the `about` method, passing in any parameters. 