scotchApp.controller('partieCtrl', function($scope, $http) {

  //Creation du bouchon
  $scope.listeParties = [{id: 1, name: 'nom partie 1', dateDeb: 'partie 1 date deb', dateEnd: 'partie 1 date fin', photo: 'url photo1'}, {id: 2, name: 'nom partie 2', dateDeb: 'partie 2 date deb', dateEnd: 'partie 2 date fin', photo: 'url photo2'}, {id: 3, name: 'nom partie 3', dateDeb: 'partie 3 date deb', dateEnd: 'partie 3 date fin', photo: 'url photo3'}, {id: 4, name: 'nom partie 4', dateDeb: 'partie 4 date deb', dateEnd: 'partie 4 date fin', photo: 'url photo4'}];



  $scope.indices = [{id: 1,text: 'When data in the model changes, the view reflects the change, and when data in the view changes, the model is updated as well. This happens immediately and automatically, which makes sure that the model and the view is updated at all times.When data in the model changes, the view reflects the change, and when data in the view changes, the model is updated as well. This happens immediately and automatically, which makes sure that the model and the view is updated at all times.When data in the model changes, the view reflects the change, and when data in the view changes, the model is updated as well. This happens immediately and automatically, which makes sure that the model and the view is updated at all times.', show: false}, {id: 2,text: 'tata', show: false}, {id: 3, text: 'tutu', show: false}];



  //
  $scope.partieSelect = '';
  $scope.showIndice = false;
  $scope.message = '';
  $scope.locationCurrent = '';
  $scope.messageErreur = "Désolé une erreur c'est produite veuillez réessayer!!";
  $scope.recherche = false;
  $scope.attente = false;
  $scope.locationFind = false;


  $scope.selectPartie = function(partie) {
    $scope.partieSelect = partie;
  };


  $scope.toggle = function(indice) {
    $scope.indices[indice.id-1].show = !$scope.indices[indice.id-1].show;
  };

  $onInit = function () {
    $scope.partieSelect = partie;
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

    $http.get('http://localhost/chasseautresor/ChasseAuTresor/public/submitLoc', {
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
