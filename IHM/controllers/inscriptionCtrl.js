scotchApp.controller('connexionCtrl', function($scope) {

  $scope.message = '';
  $scope.speudo = '';
  $scope.passw1 = '';
  $scope.passw2 = '';


  $scope.error = false;
  $scope.incomplete = false;

  $scope.$watch('passw1',function() {$scope.test();});
  $scope.$watch('passw2',function() {$scope.test();});
  $scope.$watch('fName', function() {$scope.test();});
  $scope.$watch('lName', function() {$scope.test();});

  $scope.test = function() {
    $scope.error = $scope.passw1 !== $scope.passw2;

    $scope.incomplete = (!$scope.speudo.length || !$scope.passw1.length || !$scope.passw2.length);
  };

});
