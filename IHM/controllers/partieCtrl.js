scotchApp.controller('partieCtrl', function($scope, $http) {


  //Initialisation des variables
  $scope.partieSelect = '';
  $scope.showIndice = false;
  $scope.message = '';
  $scope.locationCurrent = '';
  $scope.messageErreur = "Désolé une erreur s'est produite veuillez réessayer!!";
  $scope.recherche = false;
  $scope.attente = false;
  $scope.locationFind = false;

  //Initialisation de la liste des parties

  $scope.SearchPartie = function () {

      $http.get('http://localhost/ProjetPHP/Chasseautresor/ChasseAuTresor/public/gameList', {
          params:{
            id : "1",
          }
      })
          .success(function (status, message, data) {
              $scope.Details = data;
          })
          .error(function (status, message, data) {
              $scope.listeParties = data;
              $scope.ResponseDetails = "Status: " + status +
                  "<hr />Message: " + message +
                  "<hr />data: " + data;
          });
  };

  $scope.SearchPartie();

  $scope.selectPartie = function(partie) {
    $scope.partieSelect = partie;
  };


  $scope.toggle = function(indice) {
    $scope.indices[indice.id-1].show = !$scope.indices[indice.id-1].show;
  };


  var map;
  $scope.map = function initMap(pos) {
    map = new google.maps.Map(document.getElementById('map'), { center: {lat: pos.latitude, lng: pos.longitude}, zoom: 15, disableDefaultUI: true}); }

  var options = {
    enableHighAccuracy: true,
    timeout: 3000,
    maximumAge: 0
  };

  function success(pos) {

    $scope.attente = false;
    $scope.locationFind = true;
    $scope.locationCurrent = pos.coords;

    $scope.$digest();

    $scope.map(pos.coords);

  }

  function error(err) {

    $scope.attente = false;
    $scope.locationFind = false;

    $scope.$digest();

  }

  $scope.findPosition = function() {

    $scope.attente = true;
    $scope.recherche = true;
    $scope.locationFind = false;

    navigator.geolocation.getCurrentPosition(success, error, options);

  };

  $scope.soumettrePosition = function(pos){

    alert(pos.latitude);


    $scope.SearchData();

  };

  $scope.SearchData = function () {

    $http.get('http://localhost/Chasseautresor/ChasseAuTresor/public/submitLoc', {
      params:{
        lat : $scope.locationCurrent.latitude,
        long : $scope.locationCurrent.longitude
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
