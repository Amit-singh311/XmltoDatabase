<?php


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

Route::get('extract', 'XmlController@xmlExtract');
Route::get('extract-tickets', 'XmlController@xmlExtractTickets');
Route::get('extract-posts', 'XmlController@xmlExtractPosts');
Route::get('extract-organizations', 'XmlController@xmlExtractOrganizations');
Route::get('extract-groups', 'XmlController@xmlExtractGroups');
Route::get('extract-forums', 'XmlController@xmlExtractForums');
Route::get('extract-entries', 'XmlController@xmlExtractEntries');
Route::get('extract-categories', 'XmlController@xmlExtractCategories');
Route::get('extract-accounts', 'XmlController@xmlExtractAccounts');

Route::get('extract1', function() {
	$string = <<<XML
<?xml version='1.0'?> 
<document>
 <title>Forty What?</title>
 <from>Joe</from>
 <to>Jane</to>
 <body>
  I know that's the answer -- but what's the question?
 </body>
</document>
XML;

$xml = simplexml_load_string($string);

echo "<pre />";
print_r($xml);
});

Route::get('test', function() {

	$users = DB::connection("xml")->select('select * from users');

	print_r($users);
});