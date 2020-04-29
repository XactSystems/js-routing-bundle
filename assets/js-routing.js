/**
 * App wide routing management service
 */

import Router from './router.js';

let routes = [];
let elem = document.getElementById('xact-js-routing-data');
if(elem) {
    routes = JSON.parse(elem.attributes['data-routing-data'].value);
}

window.Routing = new Router();
window.Routing.setRoutes(routes);
