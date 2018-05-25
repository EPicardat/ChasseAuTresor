// create the module and name it scotchApp
var scotchApp = angular.module('scotchApp', ['ngRoute']);

// configure our routes
scotchApp.config(function($routeProvider) {
  $routeProvider

  // route for the home page
    .when('/', {
      templateUrl : 'views/home.html',
      controller  : 'homeCtrl'
    })

    // route for the partie page
    .when('/partie', {
      templateUrl : 'views/partie.html',
      controller  : 'partieCtrl',

    })

    // route for the connexion page
    .when('/connexion', {
      templateUrl : 'views/connexion.html',
      controller  : 'connexionCtrl'
    })

    // route for the inscription page
    .when('/inscription', {
      templateUrl : 'views/inscription.html',
      controller  : 'inscriptionCtrl'
    });
});



