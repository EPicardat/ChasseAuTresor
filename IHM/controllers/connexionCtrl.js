scotchApp.controller('connexionCtrl', function($scope) {

  $scope.message = '';
  $scope.speudo = '';
  $scope.passw1 = '';

  $scope.incomplete = false;

  $scope.$watch('passw1',function() {$scope.test();});
  $scope.$watch('fName', function() {$scope.test();});
  $scope.$watch('lName', function() {$scope.test();});

  $scope.test = function() {

    $scope.incomplete = !$scope.speudo.length ||
      !$scope.passw1.length;
  };

  $scope.SearchData = function () {

    $http.get('/ServerRequest/GetData', {
      params:{
        speudo : $scope.locationCurrent.latitude,
        password : $scope.locationCurrent.longitude
      }
    })
      .success(function (data, status, headers, config) {
        $scope.Details = data;
      })
      .error(function (data, status, header, config) {
        $scope.ResponseDetails = "Data: " + data +
          "<hr />status: " + status +
          "<hr />headers: " + header +
          "<hr />config: " + config;
      });
  };
});

