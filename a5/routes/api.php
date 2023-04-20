<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\patients;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/// This is the get all route
Route::get('/', function () {
    $patients = patients::all();
    Log::channel("api")->info("/api/getall GET REQUEST", ["route"=> "/api/", "IP" => request()->ip, "item" => $patients]);
    return response()->json(['data' => $patients], 200);
    // this is the logging for the get all route
    
});


// This is the get id route
Route::get("/{id}",function($id){

    $record = patients::find($id);

    $item = [];
    $item["id"] = $record["id"];
    $item["firstname"] = $record["firstname"];
    $item["lastname"] = $record["lastname"];
    $item["status"] = $record["status"];
    // This is the logging for the get id route
    Log::channel("api")->info("/api/id GET REQUEST", ["route"=> "/api/". $id , "id" => $id, "IP" => request()->ip, "item" => $item]);

    return response()->json($item);

});

Route::delete('/', function () {
    patients::query()->delete();
    Log::channel("api")->info("/api/ DELETE ALL REQUEST", ["route"=> "/api/", "IP" => request()->ip]);
    return response()->json(["status" => "Collection deleted"]);
});

// This is the delete id route
Route::delete("/{id}",function($id){
    $record = patients::find($id);
    $record->delete();
    Log::channel("api")->info("/api/id DELETE REQUEST", ["route"=> "/api/". $id , "id" => $id, "IP" => request()->ip, "item" => $record]);
    // this is the logging for the delete id route
    return response()->json(["status" => "Item deleted"]);
});

// this is the post route 
Route::post('/', function (Request $request) {
    $patient = new patients;
    $patient->firstname = $request->input('firstname');
    $patient->lastname = $request->input('lastname');
    $patient->status= $request->input('status');
    $patient->save();
     // this is the logging for the post route
     Log::channel("api")->info("/api/post POST REQUEST", ["route"=> "/api/", "IP" => request()->ip, "item" => $patient]);
    return response()->json(["status" => "Item inserted successfully"]);
   
});


// This is the Put ALL route
Route::put('/', function (Request $request) {
    patients::query()->update($request->all());
    Log::channel("api")->info("/api/put/ PUT ALL REQUEST", ["route"=> "/api/", "IP" => request()->ip]);
    return response()->json(['status' => "Collection replaced"]);
    
});

// this is the put id route 
Route::put('/{id}', function (Request $request, $id) {
    $patient = patients::find($id);
    if (!$patient) {
        return response()->json(['message' => 'Patient not found'], 404);
    }
    $patient->firstname = $request->input('firstname');
    $patient->lastname = $request->input('lastname');
    $patient->status= $request->input('status');
    $patient->save();
    Log::channel("api")->info("/api/put/{id} PUT REQUEST", ["route"=> "/api/". $id , "id" => $id, "IP" => request()->ip, "item" => $patient]);
    return response()->json(["status" => "Item updated"]);
    // this is the logging for the put id route 
    
});

