<?php

use System\router\Web\Route;

//home

Route::get('', 'HomeController@index', 'home.index');