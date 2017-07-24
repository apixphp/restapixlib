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



async.parallel({

foo: function(call) {

request.get(''+query.protocol+'://'+hostUrl[0]+'/apix/service/'+query.params.app+'/node/'+query.params.node+'?node=foo', function (error, response, body) {

var last=JSON.parse(body);
call(null,last.data.result);
});

},
bar: function(call) {
request.get(''+query.protocol+'://'+hostUrl[0]+'/apix/service/'+query.params.app+'/node/'+query.params.node+'?node=bar', function (error, response, body) {

var last=JSON.parse(body);
call(null,last.data.result);
});
}
}, function(err, results) {
callback(results)
});





});

}


};
