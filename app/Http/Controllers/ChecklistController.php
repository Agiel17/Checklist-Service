<?php

namespace App\Http\Controllers;

use App\Checklist;
use App\Item;
use App\Http\Resources\ChecklistResource;
use App\Http\Resources\ChecklistsResource;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Database\Eloquent\Exception as Exception;

class ChecklistController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $limit = $request->query('page')['limit']?:"10";
        $offset = $request->query('page')['offset']?:"0";
        
        return new ChecklistsResource(Checklist::paginate($limit));
    }

    public function store(Request $request)
    {

        $due = new \DateTime($request->input('data.attributes.due'));
        try {
            $checklist = Checklist::create([
                "object_domain" => $request->input('data.attributes.object_domain'),
                "object_id" => $request->input('data.attributes.object_id'),
                "due" => $due->format('Y-m-d H:i:s'),
                "urgency" => $request->input('data.attributes.urgency'),
                "description" => $request->input('data.attributes.description'),
            ]);
            foreach($request->input('data.attributes.items') as $item){
                Item::create([
                    'checklist_id' => $checklist->checklist_id,
                    'description' => $item, 
                    'task_id' => $request->input('data.attributes.task_id'),
                ]);
            }
        } catch (Exception $ex) {
            return response()->json(['status' => 500, 'error' => 'Server Error']);
        }

        return new ChecklistResource($checklist);
    }

    public function show($id)
    {
        try {
            $checklist = Checklist::findOrFail($id);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status' => 404, 'error' => 'Not Found']);
        } catch (Exception $ex) {
            return response()->json(['status' => 500, 'error' => 'Server Error']);
        }

        return new ChecklistResource($checklist);
    }    

    public function update(Request $request, $id){
        try {
            $checklist = Checklist::findOrFail($id);
            $checklist->update($request->input('data.attributes'));
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status' => 404, 'error' => 'Not Found']);
        } catch (Exception $ex) {
            return response()->json(['status' => 500, 'error' => 'Server Error']);
        }

        return new ChecklistResource($checklist);
    }

    public function destroy($id)
    {
        try {
            $checklist = Checklist::findOrFail($id);
            $checklist->delete();
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status' => 404, 'error' => 'Not Found']);
        } catch (Exception $ex) {
            return response()->json(['status' => 500, 'error' => 'Server Error']);
        }

    }

    public function relationship($checklist_id)
    {

    }    
}
