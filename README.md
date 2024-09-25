XactJSRoutingBundle
===============

This bundle allows you to expose your Symfony routes and use them in your webpack or vite managed JavaScript code.
It allows you to easily integrate the functionality of the FOSJsRoutingBundle into ES modules.

Documentation
-------------
### 1) Add JSRoutingBundle to your project

```bash
composer require xactsystems/js-routing-bundle
```
For Symfony 3.4 use:
```bash
composer require xactsystems/js-routing-bundle:^3.4
```

### 2) Include the routing template in your base Twig template
```twig
// templates/base.html.twig

{{ include("@XactJSRouting/xact-routing.html.twig") }}
```

### 3) Include the JS module in your App.js
The package installation will automatically update your package.json file to import xact-routing module.
After running composer, run:
```bash
npm install
```
Add routing to your App.js file, and/or other scripts as required:
```javascript
// assets/js/App.js

// Import the JS routing class
import Routing from 'xact-routing';
```

### 4) Using the routing class, exactly as you would with FOS bundle
```javascript
// Get the URL of your routes
let url1 = Routing.generate('home');
let url2 = Routing.generate('some-other-route', {id: myLocalId, state: myLocalState});
```
### 5) For Symfony 3.4, if you are not using Flex and ENV you may need to add the following:
```php
// app/AppKernel.php

    public function registerBundles()
    {
        // You many need to do this to get the render(controller()) Twig method working for XactJSRoutingBundle
        $_ENV["APP_ENV"] = $this->getEnvironment();
```
And for the Symfony Serializer component:
```yaml
// app/config/config.yml

framework:
    ...
    # If you haven't already enabled the Symfony Serializer
    serializer: { enabled: true }
```

Credits
-------

* Ian Foulds as the creator of this package.
* William DURAND as author of the FOS bundle.
* Julien MUETTON (Carpe Hora) for the inspiration.

License
-------

This bundle is released under the MIT license. See the complete license in the
bundle:

[LICENSE](https://github.com/ianfoulds/js-routing-bundle/blob/master/LICENSE)
