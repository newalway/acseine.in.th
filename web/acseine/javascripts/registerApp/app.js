var registerApp = angular.module('registerApp', []);

registerApp.factory('register_data', ['$http', function register_data($http){
    return {
        create: function(dataObj){console.log(dataObj);
            return $http({
                method:'POST',
                //url: 'http://localhost:9134/app_dev.php/api/v1/acseineregisters',
                url: 'http://api.what-zap.com/api/v1/acseineregisters',
                data: $.param(dataObj),
                headers: {
                    //'Authorization':'Bearer MjM5ZGQ0ZThjZTM4YzQ2NDRhNzEwOWI0OTVhMmY2OTI2ZWQ3MWNjMjZkNjg3Zjc0NWQ0MDg4ZWJlY2MyZTA3Yw',
                    'Authorization':'Bearer YmE1NjFmYmUyOTdlMGY0YWQ4ZjYxMTc3YTY2ZjJhMmVhMTBhM2EwMjY2YzA1YmEzMjcwOGExYTU5MmI4MjYzMw',
                    'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'
                }
            });
        }
    }
}]);
