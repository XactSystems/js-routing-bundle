XactJSRoutingBundle
===============

This bundle allows you to expose your Symfony routes and use them in your webpack managed JavaScript code.
It allows you to easily intergrate the functionality of the FOSJsRoutingBundle into webpack modules.

Documentation
-------------
### 1) Add JSRoutingBundle to your project
```bash
composer require xactsystems/js-routing-bundle:3.4.x-dev
```

### 2) Include the routing template in your base Twig template
```twig
// templates/base.html.twig

{{ include("@XactJSRouting/js-routing.html.twig") }}
```

### 3) Include the JS module in your App.js
```javascript
// assets/js/App.js

// Import the JS routing scripts
import '../../vendor/xactsystems/js-routing/assets/js-routing.js';
```
The actual path to the js-routing.js file may not be exactly as shown, you may need to adjust this for your own project.

### 4) Using the routing class, exactly as you would with FOS bundle
```javascript
// Get the URL of your routes
let url1 = Routing.generate('home');
let url2 = Routing.generate('some-other-route', {id: myLocalId, state: myLocalState});
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