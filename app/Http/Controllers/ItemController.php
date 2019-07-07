<?php

namespace App\Http\Controllers;

use App\Checklist;
use App\Item;
use App\Http\Resources\ChecklistItemsResource;
use App\Http\Resources\ChecklistItemResource;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ItemsResource;
use App\Http\Resources\IsCompletedResource;
use App\Http\Resources\IsCompletedsResource;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Database\Eloquent\Exception as Exception;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function complete(Request $request)
    {
        $items_id = array();
        foreach($request->input('data') as $data){
            $items_id[] = $data['item_id'];
        }
        $items = Item::whereIn('item_id', $items_id)->update(['is_completed' => 1]);
        $items = Item::whereIn('item_id', $items_id)->get();

        return new IsCompletedsResource($items);
    }

    public function incomplete(Request $request)
    {
        $items_id = array();
        foreach($request->input('data') as $data){
            $items_id[] = $data['item_id'];
        }
        $items = Item::whereIn('item_id', $items_id)->update(['is_completed' => 0]);
        $items = Item::whereIn('item_id', $items_id)->get();

        return new IsCompletedsResource($items);
    }

    public function index(Request $request, $checklist_id)
    {
        $limit = $request->query('page')['limit']?:"10";
        $offset = $request->query('page')['offset']?:"0";

        return new ChecklistItemsResource(Checklist::with('item')->findOrFail($checklist_id));
    }

    public function store(Request $request, $checklist_id)
    {
        $data = array_merge( $request->input('data.attribute'), ["checklist_id" => $checklist_id]);
        try {
            $item = Item::create($data);
        } catch (Exception $ex) {
            return response()->json(['status' => 500, 'error' => 'Server Error']);
        }

        return new ItemResource($item);
    }

    public function show($checklist_id, $item_id)
    {
        try {
            $checklist = Checklist::findOrFail($checklist_id);
            $item = $checklist->item()->findOrFail($item_id);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status' => 404, 'error' => 'Not Found']);
        } catch (Exception $ex) {
            return response()->json(['status' => 500, 'error' => 'Server Error']);
        }
        return new ChecklistItemResource($item);
    }    

    public function update(Request $request, $checklist_id, $item_id){
        try {
            $checklist = Checklist::findOrFail($checklist_id);
            $item = $checklist->item()->findOrFail($item_id);
            $item->update($request->input('data.attribute'));
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status' => 404, 'error' => 'Not Found']);
        } catch (Exception $ex) {
            return response()->json(['status' => 500, 'error' => 'Server Error']);
        }

        return new ItemResource($item);
    }

    public function destroy($checklist_id, $item_id)
    {
        try {
            $checklist = Checklist::findOrFail($checklist_id);
            $item = $checklist->item()->findOrFail($item_id);
            $item->delete();
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status' => 404, 'error' => 'Not Found']);
        } catch (Exception $ex) {
            return response()->json(['status' => 500, 'error' => 'Server Error']);
        }
    }

    public function bulk(Request $request, $checklist_id)
    {
        $datas = $request->input('data');
        $items = array();

        foreach($datas as $data){
            try {
                $checklist = Checklist::findOrFail($checklist_id);
                $item = $checklist->item()->findOrFail($data['id']);
                $item->update($data['attributes']);
                $items[] = ['id' => $data['id'], 'action' => 'update', 'status' => 200];
            } catch (ModelNotFoundException $ex) {
                $items[] = ['id' => $data['id'], 'action' => 'update', 'status' => 404];
            }
        }

        return response()->json([ "data" => $items]);
    }

    public function summaries(Request $request)
    {
        
        return new ItemsResource(Item::paginate($limit));
    }

}
