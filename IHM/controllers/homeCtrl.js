scotchApp.controller('homeCtrl', function ($scope, $location, $http, $rootScope) {
// create a message to display in our view
    $scope.message = '';
    $scope.go = function (path) {
        $location.path(path);

    };


    $scope.Identifiant = function () {
        $http.get('http://localhost:8081/Chasseautresor/ChasseAuTresor/public/user', {
            params: {}
        })
            .success(function (status, message, data) {
                if (status.user == "anonymousUser") {
                    $rootScope.connection = false;
                } else {
                    $rootScope.joueurid = status.user;
                    $rootScope.connection = true;
                }

            })
            .error(function (status, message, data) {
                $scope.ResponseDetails = "Status: " + status +
                    "<hr />Message: " + message +
                    "<hr />data: " + data;
            });
    }

    $scope.Identifiant();
});
