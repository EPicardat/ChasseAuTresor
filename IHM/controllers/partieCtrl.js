scotchApp.controller('partieCtrl', function ($scope, $http, $location) {


    //Initialisation des variables
    $scope.partieSelect = '';
    $scope.showIndice = false;
    $scope.message = '';
    $scope.locationCurrent = '';
    $scope.messageErreur = "Désolé une erreur s'est produite, veuillez réessayer!!";
    $scope.recherche = false;
    $scope.attente = false;
    $scope.locationFind = false;

    //Initialisation de la liste des parties

    $scope.SearchPartie = function () {

        $http.get('http://localhost:8081/Chasseautresor/ChasseAuTresor/public/gameList', {
            params: {
                id: "1",
            }
        })
            .success(function (status, message, data) {
                $scope.listeParties = status.data;
            })
            .error(function (status, message, data) {
                $scope.ResponseDetails = "Status: " + status +
                    "<hr />Message: " + message +
                    "<hr />data: " + data;
            });
    };

    $scope.SearchPartie();

    $scope.selectPartie = function (partie) {
        $scope.partieSelect = partie;
        // juste le temps de la démo !
        if ($scope.partieSelect.id == 1 || $scope.partieSelect.id == 2){
            $scope.tokenPhoto = $scope.partieSelect.photo;
        }else{
            $scope.tokenPhoto = localStorage.getItem($scope.partieSelect.photo);
        }
        $scope.victoire = false;
        $scope.firstClues();
    };

    $scope.firstClues = function () {
        $http.get('http://localhost:8081/Chasseautresor/ChasseAuTresor/public/getFirstClues', {
            params: {
                id: $scope.partieSelect.id,
                personne: $scope.joueurid,
            }
        })
            .success(function (status, message, data) {

                if (status.data) {
                    $scope.partieSelect.indices = status.data;
                    for (i = 0; i < $scope.partieSelect.indices.length; i++) {
                        $scope.partieSelect.indices[i].id = i + 1;
                    }
                }
            })
            .error(function (status, message, data) {
                $scope.ResponseDetails = "Data: " + data +
                    "<hr />status: " + status +
                    "<hr />message: " + message +
                    "<hr />data: " + data;
            });
    }


    $scope.toggle = function (indice) {
        $scope.partieSelect.indices[indice.id - 1].show = !$scope.partieSelect.indices[indice.id - 1].show;
    };

    var map;
    $scope.map = function initMap(pos) {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: pos.latitude, lng: pos.longitude},
            zoom: 15,
            disableDefaultUI: true
        });

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(pos.latitude, pos.longitude),
            map: map,
            title: "Moi !"
        });
    }

    var options = {
        enableHighAccuracy: true,
        timeout: 3000,
        maximumAge: 0
    };


    function success(pos) {

        $scope.attente = false;
        $scope.locationFind = true;
        $scope.locationCurrent = pos.coords;
        window.navigator.vibrate([200, 100, 200]);

        $scope.$digest();

        $scope.map(pos.coords);

    }

    function error(err) {

        $scope.attente = false;
        $scope.locationFind = false;

        $scope.$digest();

    }

    $scope.findPosition = function () {

        $scope.attente = true;
        $scope.recherche = true;
        $scope.locationFind = false;

        navigator.geolocation.getCurrentPosition(success, error, options);

    };

    $scope.soumettrePosition = function (pos) {


        $scope.SearchData();
        $scope.locationFind = false;

    };

    $scope.SearchData = function () {

        $http.get('http://localhost:8081/Chasseautresor/ChasseAuTresor/public/submitLoc', {
            params: {
                id: $scope.partieSelect.id,
                personne: $scope.joueurid,
                lat: $scope.locationCurrent.latitude,
                lon: $scope.locationCurrent.longitude,
                acc: $scope.locationCurrent.accuracy,
            }
        })
            .success(function (status, message, data) {
                if (status.data[0]) {
                    $scope.recherche = false;
                    $scope.partieSelect.message = status.data[0];
                }
                if (status.data[1]) {
                    $scope.partieSelect.indices = status.data[1];
                    for (i = 0; i < $scope.partieSelect.indices.length; i++) {
                        $scope.partieSelect.indices[i].id = i + 1;
                    }
                }
                if (status.data[2]) {
                    $scope.partieSelect.messageFin = status.data[2][0].message_fin;
                    $scope.victoire = true;
                }
            })
            .error(function (status, message, data) {
                $scope.ResponseDetails = "Data: " + data +
                    "<hr />status: " + status +
                    "<hr />message: " + message +
                    "<hr />data: " + data;
            });
    };

    $scope.createPartie = function(path){

        $location.path( path );
    }
});
