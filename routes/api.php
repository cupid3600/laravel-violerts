<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => 'jwt.auth'], function(){
	Route::get('auth/user', 'AuthController@user');
	Route::get('auth/refresh', 'AuthController@refresh');
	Route::post('auth/logout', 'AuthController@logout');
});


// check portfolio settings
Route::get('/portfolio/settings/{Id}', 'PortfolioController@settings');

// airtable endpoint goes here
Route::post('/portfolio/airtable/enable/{Id}', 'PortfolioController@enableAirtable');
Route::get('/portfolio/airtable/disable/{Id}', 'PortfolioController@disableAirtable');
Route::get('/portfolio/airtable/remove/{Id}', 'PortfolioController@removeAirtable');


Route::post('/signup', 'AuthController@signup');
Route::post('/signin', 'AuthController@signin');
Route::post('/user/forgot-password', 'AuthController@forgot');
Route::post('/user/forgot-password/reset/{token}', 'AuthController@reset');


Route::get('/admin/users/profile/{token}', 'UserController@profile');
Route::get('/admin/users/suspend/{Id}', 'UserController@suspend');
Route::get('/admin/users/restore/{Id}', 'UserController@restore');
Route::post('/admin/users/change/group/{Id}', 'UserController@changeUserGroup');


Route::post('/new/property', 'PropertyController@create');
Route::post('/check/property', 'PropertyController@indexCheck');
Route::get('/portfolio/remove/property/{PropertyId}', 'PortfolioController@remove');

Route::get('/property/overview/{address}', 'PropertyController@property');
Route::get('/property/open-data/complaints/{Id}', 'ComplaintController@getComplaints');
Route::get('/property/bis/complaints/{Id}', 'ComplaintController@getBISComplaints');
Route::get('/property/open-data/dob-violations/{Id}', 'DOBViolationController@getDOBViolations');
Route::get('/property/bis/dob-violations/{Id}', 'DOBViolationController@getBISDOBViolations');
Route::get('/property/open-data/ecb-violations/{Id}', 'ECBViolationController@getECBViolations');
Route::get('/property/bis/ecb-violations/{Id}', 'ECBViolationController@getBISECBViolations');
Route::get('/property/open-data/job-applications/{Id}', 'JobApplicationController@getJobApplications');
Route::get('/property/bis/job-applications/index/{Id}', 'JobApplicationController@getBISJobApplicationsIndex');
Route::get('/property/bis/job-applications/records/{Id}', 'JobApplicationController@getBISJobApplicationsRecords');
Route::get('/property/open-data/oath-cases/{Id}', 'OATHCaseController@getOATHCases');
Route::get('/property/open-data/acris-rpl/{Id}', 'ACRISController@getACRISRPL'); 
Route::get('/property/open-data/acris-ppl/{Id}', 'ACRISController@getACRISPPL'); 
Route::get('/property/open-data/311-complaints/{Id}', 'TOOComplaintController@get311Complaints');
Route::get('/property/bis/elevators/index/{Id}', 'ElevatorController@getElevatorIndex');
Route::get('/property/bis/elevators/inspections/{Id}', 'ElevatorController@getElevatorInspections');
Route::get('/property/bis/elevators/violations/{Id}', 'ElevatorController@getElevatorViolations');
Route::get('/property/bis/permits/index/{Id}', 'PermitController@getPermitsIndex');
Route::get('/property/bis/permits/records/{Id}', 'PermitController@getPermitsRecords');
Route::get('/property/bis/illuminated-signs/{Id}', 'IlluminatedSignController@getIlluminatedSigns');

# swipe complaint index 
Route::get('/property/open-data/311-complaints/swipe/{Id}', 'TOOComplaintController@swipeIndex');
Route::get('/property/open-data/complaints/swipe/{Id}', 'ComplaintController@swipeIndexOD');
Route::get('/property/bis/complaints/swipe/{Id}', 'ComplaintController@swipeIndexBIS');

# swipe dob violation index
Route::get('/property/open-data/dob-violations/swipe/{Id}', 'DOBViolationController@swipeIndexOD'); 
Route::get('/property/bis/dob-violations/swipe/{Id}', 'DOBViolationController@swipeIndexBIS');

# swipe ecb violation index
Route::get('/property/open-data/ecb-violations/swipe/{Id}', 'ECBViolationController@swipeIndexOD'); 
Route::get('/property/bis/ecb-violations/swipe/{Id}', 'ECBViolationController@swipeIndexBIS'); 

# swipe job application index 
Route::get('/property/open-data/job-applications/swipe/{Id}', 'JobApplicationController@swipeIndexOD');
Route::get('/property/bis/job-applications/swipe/{Id}', 'JobApplicationController@swipeIndexBIS');

# swipe oath case index 
Route::get('/property/open-data/oath-cases/swipe/{Id}', 'OATHCaseController@swipeIndexOD');

# swipe acris legal index 
Route::get('/property/open-data/acris-rpl/swipe/{Id}', 'ACRISController@swipeIndexRPL'); 
Route::get('/property/open-data/acris-ppl/swipe/{Id}', 'ACRISController@swipeIndexPPL');

# swipe elevator record index
Route::get('/property/bis/elevator/records/swipe/{Id}', 'ElevatorController@swipeIndexRecord');

# swipe elevator inspection index 
Route::get('/property/bis/elevator/inspections/swipe/{Id}', 'ElevatorController@swipeIndexInspection');

# swipe elevator violation index 
Route::get('/property/bis/elevator/violations/swipe/{Id}', 'ElevatorController@swipeIndexViolation');

# illuminated sign index 
Route::get('/property/bis/illuminated-signs/swipe/{Id}', 'IlluminatedSignController@swipeIndex');

Route::post('/user/settings/create/airtable-key/{Id}', 'UserController@addAirtableApiKey');
Route::get('/user/settings/read/airtable-key/index/{Id}', 'UserController@getAirtableApiKeys');
Route::get('/user/settings/delete/airtable-key/{Id}', 'UserController@removeAirtableKey');

