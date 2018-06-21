scotchApp.controller('homeCtrl', function($scope, $location) {
// create a message to display in our view
  $scope.message = '';
    $scope.go = function ( path ) {
        $location.path( path );
        $scope="";
    };
});
