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
  Route::get('projects/create', 'ProjectController@create');
  Route::get('projects', 'ProjectController@index');
  Route::get('projects/{project}', 'ProjectController@show');

  // Users
  Route::get('talents', 'UserController@index');
  Route::get('talents/{user}', 'UserController@show');

});

Route::group(['middleware' => 'auth'], function(){
});

Route::group(['middleware' => 'auth.basic'], function(){
  // Feedbacks
  Route::get('feedbacks', 'FeedbackController@index');
  Route::post('feedbacks', 'FeedbackController@store');

  // Users
  Route::get('talents/{user}/edit', 'UserController@edit');
  Route::patch('talents/{user}', 'UserController@update');
  Route::get('talents/{user}/chat', 'ChatUserController@index');
  Route::post('talents/{user}/chat', 'ChatUserController@store');

  // Project
  Route::post('projects', 'ProjectController@store');
  Route::get('projects/{project}/edit', 'ProjectController@edit');
  Route::patch('projects/{project}', 'ProjectController@update');
  Route::delete('projects/{project}', 'ProjectController@delete');

  // Project comments
  Route::post('projects/{project}/comments', 'ProjectCommentController@store');
  Route::get('comments/{comment}/edit', 'ProjectCommentController@edit');
  Route::patch('comments/{comment}', 'ProjectCommentController@update');
});
// Route::get('admin', ['as' =>'admin', 'uses' => 'UserController@index', 'middleware' => ['auth', 'admin']]);
// Route::get('protected', ['middleware' => ['auth', 'admin'], function() {
//   Route::get('admin', 'UserController@index');
//   // return "this page requires that you be logged in and an Admin";
// }]);

Route::get('profile', ['middleware' => 'auth.basic', function() {

}]);

// Tags
