<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/fibonanci', function () {
    function generate_string() {
        $permitted_chars = 'thinking';             
        $input_length = strlen($permitted_chars);
        $jml = strlen($permitted_chars);
        $random_string = '';
        for($i = 0; $i < $jml; $i++) {
            $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
     
        print_r($random_string);
        // return $random_string;
    }
    generate_string();
      
});
