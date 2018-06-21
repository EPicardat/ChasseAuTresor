scotchApp.controller('gameCreationCtrl', function($scope, $http) {

    //Initialisation des variables
    $scope.message = '';
    $scope.nom = '';
    $scope.photo = '';
    $scope.latitude = '';
    $scope.longitude = '';
    $scope.accuracy = '';
    $scope.message_fin = '';
    $scope.locationCurrent = '';
    $scope.messageErreur = "Désolé une erreur s'est produite veuillez réessayer!!";
    $scope.recherche = false;
    $scope.attente = false;
    $scope.locationFind = false;

    let options = {
        enableHighAccuracy: true,
        timeout: 3000,
        maximumAge: 0
    };

    /******************** Post *********************/

    $scope.createGame = function() {
        $http({
            method: "POST",
            url : "http://localhost/Chasseautresor/ChasseAuTresor/public/setGame",
            params: {
                nom : $scope.nom,
                lat : $scope.locationCurrent.latitude,
                lon : $scope.locationCurrent.longitude,
                acc : $scope.locationCurrent.accuracy,
                messageFin : $scope.message_fin,
                img : $scope.photo
            }
        }).then(function success(){
            return $http({
                method : 'GET',
                url : 'views/partie.html'
        }), function error() {
                $scope.message("Erreur dans le formulaire")
            }
        });
    };

    /******************** Position ********************/

    function success(pos) {

        $scope.attente = false;
        $scope.locationFind = true;
        $scope.locationCurrent = pos.coords;

        $scope.$digest();
    }

    $scope.findPosition = function() {

        $scope.attente = true;
        $scope.recherche = true;
        $scope.locationFind = false;

        navigator.geolocation.getCurrentPosition(success, error, options);

    };

    function error(err) {

        $scope.attente = false;
        $scope.locationFind = false;

        $scope.$digest();

    }

    /******************** photo ********************/

    (function() {
        // The width and height of the captured photo. We will set the
        // width to the value defined here, but the height will be
        // calculated based on the aspect ratio of the input stream.

        let width = 320;    // We will scale the photo width to this
        let height = 0;     // This will be computed based on the input stream

        // |streaming| indicates whether or not we're currently streaming
        // video from the camera. Obviously, we start at false.

        let streaming = false;

        // The various HTML elements we need to configure or control. These
        // will be set by the startup() function.

        let video = null;
        let canvas = null;
        let photo = null;
        let startbutton = null;
        let inputSrc = null;

        function startup() {
            video = document.getElementById('video');
            canvas = document.getElementById('canvas');
            photo = document.getElementById('photo');
            startbutton = document.getElementById('startbutton');
            inputSrc = document.getElementById('inputPhoto');

            navigator.getMedia = ( navigator.getUserMedia ||
                navigator.webkitGetUserMedia ||
                navigator.mozGetUserMedia ||
                navigator.msGetUserMedia);

            navigator.getMedia(
                {
                    video: true,
                    audio: false
                },
                function(stream) {
                    if (navigator.mozGetUserMedia) {
                        video.mozSrcObject = stream;
                    } else {
                        let vendorURL = window.URL || window.webkitURL;
                        video.src = vendorURL.createObjectURL(stream);
                    }
                    video.play();
                },
                function(err) {
                    console.log("An error occured! " + err);
                }
            );

            video.addEventListener('canplay', function(ev){
                if (!streaming) {
                    height = video.videoHeight / (video.videoWidth/width);

                    // Firefox currently has a bug where the height can't be read from
                    // the video, so we will make assumptions if this happens.

                    if (isNaN(height)) {
                        height = width / (4/3);
                    }

                    video.setAttribute('width', width);
                    video.setAttribute('height', height);
                    canvas.setAttribute('width', width);
                    canvas.setAttribute('height', height);
                    streaming = true;
                }
            }, false);

            startbutton.addEventListener('click', function(ev){
                takepicture();
                ev.preventDefault();
            }, false);

            clearphoto();
        }

        // Fill the photo with an indication that none has been
        // captured.

        function clearphoto() {
            let context = canvas.getContext('2d');
            context.fillStyle = "#AAA";
            context.fillRect(0, 0, canvas.width, canvas.height);

            let data = canvas.toDataURL('image/png');
            photo.setAttribute('src', data);
        }

        // Capture a photo by fetching the current contents of the video
        // and drawing it into a canvas, then converting that to a PNG
        // format data URL. By drawing it on an offscreen canvas and then
        // drawing that to the screen, we can change its size and/or apply
        // other changes before drawing it.

        function takepicture() {
            let context = canvas.getContext('2d');
            if (width && height) {
                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);

                let data = canvas.toDataURL('image/png');
                photo.setAttribute('src', data);
                let token = makeid();
                localStorage.setItem(token, data);
                inputSrc.setAttribute('value', token)
                $scope.photo = token;

            } else {
                clearphoto();
            }
        }

        function makeid() {
            let text = "";
            let possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for (let i = 0; i < 15; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        }

        // Set up our event listener to run the startup process
        // once loading is complete.
        window.addEventListener('load', startup, false);
    })();
});


