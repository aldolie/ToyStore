
function auth($http,$cookies){
    /*    var token=$cookies.authenticateApp;
        console.log(token);
        if(typeof token!=='undefined'){
            $http.defaults.headers.get = {'X-APP-TOKEN' : token['token']};
            $http.defaults.headers.common['Accept'] =token['html'];
            
        }*/
}

app.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('[[').endSymbol(']]');
});


