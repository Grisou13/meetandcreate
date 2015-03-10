<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::resource('profil','User\ProfilController');
Route::resource('user','User\UserController');
Route::resource('project','ProjectController');
Route::resource('backend','BackendController');
Route::resource('api','ApiController');
Route::resource('file','FileController');
Route::resource('oauth','OauthController');
Route::resource('token','TokenController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::get('/test',function(){ 
	var_dump(App\User::all()->toArray());
	$routeCollection = Route::getRoutes();
	echo "<table style='width:100%'>";
	    echo "<tr>";
	        echo "<td width='10%'><h4>HTTP Method</h4></td>";
	        echo "<td width='10%'><h4>Route</h4></td>";
	        echo "<td width='60%'><h4>Corresponding Action</h4></td>";
	    echo "</tr>";
    	foreach ($routeCollection as $r) {
        echo "<tr>";
            echo "<td>" . implode('|',$r->getMethods()) . "</td>";
            echo "<td>" . $r->getPath() . "</td>";
            echo "<td>" . $r->getActionName() . "</td>";
        echo "</tr>";
	    }
	echo "</table>";
});
