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
              $scope.listeParties = status.data;
          })
          .error(function (status, message, data) {
              $scope.listeParties = data;
              $scope.ResponseDetails = "Status: " + status +
                  "<hr />Message: " + message +
                  "<hr />data: " + data;
          });
  };

  $scope.SearchPartie();

  $scope.loadIndice = function () {

      $http.get('http://localhost/ProjetPHP/Chasseautresor/ChasseAuTresor/public/gameList', {
          params:{
              id : $scope.partieSelect.id,
          }
      })
          .success(function (status, message, data) {
              $scope.listeParties = status.data;
          })
          .error(function (status, message, data) {
              $scope.listeParties = data;
              $scope.ResponseDetails = "Status: " + status +
                  "<hr />Message: " + message +
                  "<hr />data: " + data;
          });
  };

  $scope.selectPartie = function(partie) {
    $scope.partieSelect = partie;
    //$scope.loadIndice();
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




    $scope.SearchData();
    alert($scope.reponse);
  };

  $scope.SearchData = function () {

    $http.get('http://localhost/ProjetPHP/Chasseautresor/ChasseAuTresor/public/submitLoc', {
      params:{
          id : $scope.partieSelect.id,
          personne : "1",
          lat : $scope.locationCurrent.latitude,
          lon : $scope.locationCurrent.longitude,
          acc : $scope.locationCurrent.accuracy,

      }
    })
      .success(function (status, message, data) {
        $scope.reponse = data.found;
      })
      .error(function (status, message, data) {
        $scope.ResponseDetails = "Data: " + data +
          "<hr />status: " + status +
          "<hr />message: " + message +
          "<hr />data: " + data;
      });
  };


});
