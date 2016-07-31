<?php

Route::group(['middleware' => 'web'], function(){
  Route::auth();

  // Global
  Route::get('/', function(){
    return view('welcome');
  });
  Route::get('/about', function(){
    return view('about');
  });

  // Projects
  Route::get('projects', 'ProjectController@index');
  Route::get('projects/create', 'ProjectController@create');
  Route::post('projects', 'ProjectController@store');
  Route::get('projects/{project}', 'ProjectController@show');
  Route::get('projects/{project}/edit', 'ProjectController@edit');
  Route::patch('projects/{project}', 'ProjectController@update');
  Route::delete('projects/{project}', 'ProjectController@delete');

  // Project comments
  Route::post('projects/{project}/comments', 'ProjectCommentController@store');
  Route::get('comments/{comment}/edit', 'ProjectCommentController@edit');
  Route::get('comments/{comment}/edit', 'ProjectCommentController@edit');
  Route::patch('comments/{comment}', 'ProjectCommentController@update');

  // Users
  Route::get('talents', 'UserController@index');
  Route::get('talents/{user}', 'UserController@show');
  Route::get('talents/{user}/edit', 'UserController@edit');
  Route::patch('talents/{user}', 'UserController@update');
});

// Tags
