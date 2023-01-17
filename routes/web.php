<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//La ruta / debe devolver una vista llamada welcome1.
Route::get('/', function () {
    return view('welcome1');
});

/* La ruta /saludo1 debe devolver la vista welcome2.*/
Route::get('/saludo1', function () {
    return view('welcome2');
})->name('primerSaludo');

/*Crear una ruta para saludar al usuario, que acepte como parámetro su nombre y escriba: “Bienvenido, nombre!”. La url tendría que ser /saludo1/nombre*/
Route::get('/saludo1/{nombre}', function ($nombre) {
    return "Bienvenido, $nombre!";
});

/*Crear una ruta para saludar al usuario con url /saludo1/nombre/nick, que acepte como parámetro el nombre del usuario y de forma opcional su nickname y escriba "Bienvenido nombre, tu apodo es nickname” cuando se especifique, y "Bienvenido nombre, no tienes apodo” en caso contrario.*/

//Comentar para hacer el ejercicio de controller
/*Route::get('/saludo1/{nombre}/{nickname?}', function (string $nombre, $nickname = NULL) {
    return view('welcome2', ['nombre'=>$nombre, 'nickname'=>$nickname] );
});*/


// Crea una ruta para editar usuarios (la URL debería tener el formato /usuarios/{ID del usuario aquí}/edit). Debe devolver: “Hola, usuario ID!” Nota: La ID sólo debería aceptar enteros.

//Comentar para hacer el ejercicio de controllers

/*Route::get('/usuarios/{id}/edit', function (int $id) {
    return "Hola usuario $id!";
})-> where('id', '[0-9]+');*/


//Crear la ruta con url saludoTodos que acepte todos los verbos http.
Route::any('/saludoTodos', function(){
  return "Hola holita vecinitos";
});

/*Crear un grupo de rutas que compartan el prefijo saludo2 con las siguientes rutas:
   saludo2                que devuelve la vista welcome2
   saludo2/uno        que devuelve la vista welcome2
   saludo2/{id}        que solo acepta id como numero entero de 3 digitos y escriba: Hola, id!
   saludo2/{nombre}    que solo acepta nombres de 4 caracteres alfanumericos de longitud, y escriba: nombre tiene 4 letras.*/

Route::prefix('saludo2')->group(function () {
    Route::get('/', function () {
        return view('welcome2');
    });
    Route::get('uno', function () {
        return view('welcome2');
    });
    Route::get('{id}', function ($id) {
        if(!is_numeric($id) || strlen($id)!=3){
           abort(404);
        }
        return "Hola, $id!";
    })->where('id', '[0-9]{3}');
    Route::get('{nombre}', function ($nombre) {
        if(!preg_match('/^[a-zA-Z0-9]{4}$/', $nombre)){
           abort(404);
        }
        return "$nombre tiene 4 letras.";
    });
});



//Crear una ruta /saludoUno que redirija a la url saludo1 y /saludoDos a la url saludo2.

Route::get('/saludoUno', function(){
    return redirect('/saludo1');
});

Route::get('/saludoDos', function(){
    return redirect('/saludo2');
});

//Finalmente habrá una ruta por defecto que mostrará el mensaje “ERROR 404”, que capturara las peticiones inválidas.
Route::fallback(function () {
    return "ERROR 404";
});

//Renombrar la primera ruta /saludo1 a primerSaludo.

//Redirigir ruta /otroSaludoUno a primerSaludo, usando su nombre de ruta.
Route::get('/otroSaludoUno', function(){
    return redirect()->route('primerSaludo');
});

//Mueve el código de la ruta para editar usuarios que creaste en el ejercicio de rutas ( /usuarios/{ID del usuario aquí}/edit), a una nueva acción edit dentro de UserController.
Route::get('/usuarios/{id}/edit',[UserController::class ,'edit'])->where('id', '[0-9]+');

/*Divide la ruta de saludo /saludo1/nombre/nick en 2 rutas diferentes que apunten a 2 acciones diferentes, para de esta manera eliminar la necesidad de un condicional y el parámetro opcional. 
Deben asociarse con el controlador WelcomeUserController.*/
Route::get('/saludo1/{nombre}', [WelcomeUserController::class , 'saludo']);
Route::get('/saludo1/{nombre}/{nickname}', [WelcomeUserController::class ,'saludoNick']);
