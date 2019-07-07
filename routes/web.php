<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/login', 'LoginController@login');
$router->post('/register', 'LoginController@register');

$router->group(['prefix' => 'api/v1/checklists/'], function ($router) {
    // Template
    // List all checklists templates
    $router->get('templates', [
        'uses' => 'TemplateController@index', 'as' => 'template.index'
    ]);
    // Create checklist template 
    $router->post('templates', [
        'uses' => 'TemplateController@store', 'as' => 'template.store'
    ]); 
    // Get checklist template 
    $router->get('templates/{template_id}', [
        'uses' => 'TemplateController@show', 'as' => 'template.show'
    ]);
    // Update Checklist Template
    $router->put('templates/{template_id}', [
        'uses' => 'TemplateController@update', 'as' => 'template.update'
    ]);
    // Delete Checklist Template given templateId
    $router->delete('templates/{template_id}', [
        'uses' => 'TemplateController@destroy', 'as' => 'template.destroy'
    ]);
    // Assign bulk checklist template by given templateId to many domains 
    $router->post('templates/{template_id}/assigns', [
        'uses' => 'TemplateController@assigns', 'as' => 'template.assigns'
    ]); 

    // checklist
    // Get List of Checklist
    $router->get('/', [
        'uses' => 'ChecklistController@index', 'as' => 'checklist.index'
    ]);
    // Get Checklist
    $router->get('{checklist_id}', [
        'uses' => 'ChecklistController@show', 'as' => 'checklist.show'
    ]);
    // Create Checklist 
    $router->post('/', [
        'uses' => 'ChecklistController@store', 'as' => 'checklist.store'
    ]); 
    // Update Checklist   
    $router->put('{checklist_id}', [
        'uses' => 'ChecklistController@update', 'as' => 'checklist.update'
    ]);
    // Delete Checklist
    $router->delete('{checklist_id}', [
        'uses' => 'ChecklistController@destroy', 'as' => 'checklist.destroy'
    ]);

    // item
    // Complete Item(s)
    $router->post('complete', [
        'uses' => 'ItemController@complete', 'as' => 'item.complete'
    ]);    
    // Incomplete Item(s)
    $router->post('incomplete', [
        'uses' => 'ItemController@incomplete', 'as' => 'item.incomplete'
    ]);    
    // List all items in given checklist
    $router->get('{checklist_id}/items', [
        'uses' => 'ItemController@index', 'as' => 'item.index'
    ]);
    // Create checklist item
    $router->post('{checklist_id}/items', [
        'uses' => 'ItemController@store', 'as' => 'item.store'
    ]);    
    // Get checklist item
    $router->get('{checklist_id}/items/{item_id}', [
        'uses' => 'ItemController@show', 'as' => 'item.show'
    ]);
    // Update checklist item
    $router->put('{checklist_id}/items/{item_id}', [
        'uses' => 'ItemController@update', 'as' => 'item.update'
    ]);
    // Delete checklist item
    $router->delete('{checklist_id}/items/{item_id}', [
        'uses' => 'ItemController@destroy', 'as' => 'item.destroy'
    ]);    
    // Update bulk checklist
    $router->post('{checklist_id}/items/_bulk', [
        'uses' => 'ItemController@bulk', 'as' => 'item.bulk'
    ]);
    // Summary Item
    $router->get('items/summaries', [
        'uses' => 'ItemController@summaries', 'as' => 'item.summaries'
    ]);

    // History
    // Get List of History
    // $router->get('histories', [
    //     'uses' => 'HistoryController@index', 'as' => 'history.index'
    // ]);

    // Get History by Id
    $router->get('histories/{history_id}', [
        'uses' => 'HistoryController@show', 'as' => 'history.show'
    ]);

    // Checklist relationship item
    $router->get('{checklist_id}/relationship/items', [
        'uses' => 'ChecklistController@relationship', 'as' => 'checklist.relationships.item'
    ]);

});