registerApp.controller('registerController', ['$scope', '$sce', '$window', 'register_data', function($scope, $sce, $window, register_data) {
    $scope.getDataLoading = function() {
        return $scope.data_loaded;
    };
    $scope.setDataLoading = function(value) {
        $scope.data_loaded = value;
    };

    $scope.processForm = function() {
        $scope.setDataLoading(true);

        register_data.create($scope.formData).then(function onSuccess(response) {
            var data = response.data;
            if (!data.success) {
                $scope.message = data.message;
                $scope.errors = data.error_message;
            } else {
                $scope.message = data.message;
                $scope.errors = data.error_message;
                $window.location.href = '/thanks.html';
            }
            $scope.setDataLoading(false);
        }).catch(function onError(response) {
            $scope.setDataLoading(false);
        });
    };

    $scope.formData = {};
    $scope.errors = {};
    $scope.message = null;
    $scope.setDataLoading(false);

}]);
