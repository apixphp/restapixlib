/**
* base function for all services
* Function base module ; api service
* base methods are useful definitions
* Examples:
*
*     // base.config()
*     //return : node service for application
*
*
* @param {String|Array} types...
* @return {json}
* @return
*/

module.exports = {

/**
* base config method for all services
* Function base module ; api node service
* get client node for your services
* Examples:
*
*     // base.config()
*     //return : object
*
*
* @param {String|Array} types...
* @return {json}
* @return
*/

config: function (query,callback) {

var request = require('request');

var hostname = query.headers.host;
var hostUrl=hostname.split(':');

request.get(''+query.protocol+'://'+hostUrl[0]+'/apix/service/'+query.params.app+'/app/index?node=true&request=get', function (error, response, body) {

var result=JSON.parse(body);
var node=result.data.node;

async.map(node[query.params.node], function (n, call) {

request.get(''+query.protocol+'://'+hostUrl[0]+'/apix/service/'+query.params.app+'/node/'+query.params.node+'?node=' + encodeURIComponent(n), function (error, response, body) {
if (error) return callback(error)

var last = JSON.parse(body)
call(null,{[n]:last})
})

}, function (error, results) {
// handle error
callback(results)
});


});

}


};
