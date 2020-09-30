/**
 * App wide routing management service
 */

import Router from './router.js';

let routes = [];
let elem = document.getElementById('xact-js-routing-data');
if(elem) {
    routes = JSON.parse(elem.attributes['data-routing-data'].value);
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
