//para hacer uso de $resource debemos colocarlo al crear el modulo
var app = angular.module("app", []);
 
//con dataResource inyectamos la factoría
app.controller("appController", function ($scope, $http) {
    //hacemos uso de $http para obtener los datos del json
    $http.get('C:/prueba/codehero.json').success(function (data) {
        //Convert data to array.
        //datos lo tenemos disponible en la vista gracias a $scope

        console.log(data)
        $scope.datos = data;
    });
    //datosResource lo tenemos disponible en la vista gracias a $scope
   // $scope.datosResource = dataResource.get();
})
 

 /*
//de esta forma tan sencilla consumimos con $resource en AngularJS
app.factory("dataResource", function ($resource) {
    return $resource("js/data.json", //la url donde queremos consumir
        {}, //aquí podemos pasar variables que queramos pasar a la consulta
        //a la función get le decimos el método, y, si es un array lo que devuelve
        //ponemos isArray en true
        { get: { method: "GET", isArray: true }
    })
})*/