<?php


Route::get('/tenants/{uuid}', 'Api\TenantApiController@show');
Route::get('/tenants', 'Api\TenantApiController@index');

Route::get('/categories', 'Api\CategoryApiController@categoriesByTenant');

