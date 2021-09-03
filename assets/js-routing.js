/**
 * App wide routing management service
 */

import Router from './router.js';

let routes = [];
let routesElement = document.getElementById('xact-js-routing-data');
if(routesElement) {
    routes = JSON.parse(routesElement.attributes['data-routing-data'].value);
    routesElement.remove();
}

let context = {
    scheme: window.location.protocol,
    host: window.location.hostname,
    port: window.location.port,
    base_url: '',
    routes: routes,
};
if (window.location.pathname.startsWith('/app_dev.php')) {
    context.base_url = '/app_dev.php';
}

window.Routing = new Router();
window.Routing.setRoutingData(context);
