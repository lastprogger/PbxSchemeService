<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    [
        'prefix'                          => '{version}',
        'namespace'                       => 'Api',
        'middleware'                      => ['locale'],
        Controller::ACTION_GROUP_NAME_KEY => Controller::ACTION_GROUP_NAME_PUBLIC_API,
    ],
    function () {
        Route::resource('pbx-scheme', 'PbxSchemeController')->middleware('auth.custom');
        Route::resource('pbx', 'PbxController')->middleware('auth.custom');
        Route::resource('node-type', 'NodeTypeController')->middleware('auth.custom');

        Route::get('pbx-scheme-preset', 'PbxSchemePresetsController@index');
        Route::post('pbx-scheme-preset', 'PbxSchemePresetsController@store');
        Route::get('pbx-scheme-preset/{id}', 'PbxSchemePresetsController@show');
        Route::delete('pbx-scheme-preset/{id}', 'PbxSchemePresetsController@destroy');
    }
);

