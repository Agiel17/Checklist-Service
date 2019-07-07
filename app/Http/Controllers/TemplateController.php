<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Database\Eloquent\Exception as Exception;
use App\Http\Resources\TemplatesResource2;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ChecklistResource;
use App\Http\Resources\ChecklistsResource;
use App\Http\Resources\TemplateResource;
use App\Http\Resources\TemplatesResource;
use App\Template;
use App\Checklist;
use App\Item;

class TemplateController extends Controller
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

        return new TemplatesResource(Template::paginate($limit));
    }

    public function store(Request $request)
    {
        $due_interval = $request->input('data.attributes.checklist.due_interval');
        $due_unit = $request->input('data.attributes.checklist.due_unit');        
        $due = date_create('+'.$due_interval.' '.$due_unit)->format('Y-m-d H:i:s');
        try {
            $template = Template::create($request->input('data.attributes'));
            $checklist = Checklist::create([
                'template_id' => $template->template_id,
                'description' => $request->input('data.attributes.checklist.description'),
                'due' => $due
            ]);
            foreach($request->input('data.attributes.items') as $item){
                Item::create([
                    'checklist_id' => $checklist->checklist_id,
                    'description' => $item['description'],
                    'urgency' => $item['urgency'],
                    'due' => date_create('+'.$item['due_interval'].' '.$item['due_unit'])->format('Y-m-d H:i:s'),
                ]);
            }
        } catch (Exception $ex) {
            return response()->json(['status' => 500, 'error' => 'Server Error']);
        }
        $template = Template::with('checklist', 'item')->find($template->template_id);
        return new TemplateResource($template);
    }

    public function show($id)
    {
        try {
            $template = Template::with('checklist', 'item')->find($id);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status' => 404, 'error' => 'Not Found']);
        } catch (Exception $ex) {
            return response()->json(['status' => 500, 'error' => 'Server Error']);
        }

        return new TemplateResource($template);
    }    

    public function update(Request $request, $id){
        $due_interval = $request->input('data.checklist.due_interval');
        $due_unit = $request->input('data.checklist.due_unit');        
        $due = date_create('+'.$due_interval.' '.$due_unit)->format('Y-m-d H:i:s');
        try {
            $template = Template::find($id);
            $template->checklist()->update(["template_id" => null]);
            $checklist = Checklist::create([
                'template_id' => $template->template_id,
                'description' => $request->input('data.checklist.description'),
                'due' => $due
            ]);
            foreach($request->input('data.items') as $item){
                Item::create([
                    'checklist_id' => $checklist->checklist_id,
                    'description' => $item['description'],
                    'urgency' => $item['urgency'],
                    'due' => date_create('+'.$item['due_interval'].' '.$item['due_unit'])->format('Y-m-d H:i:s'),
                ]);
            }
        } catch (Exception $ex) {
            return response()->json(['status' => 500, 'error' => 'Server Error']);
        }
        $template = Template::with('checklist', 'item')->find($template->template_id);
        return new TemplateResource($template);
    }

    public function destroy($id)
    {
        try {
            $template = Template::findOrFail($id);
            $template->checklist()->update(["template_id" => null]);
            $template->delete();
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status' => 404, 'error' => 'Not Found']);
        } catch (Exception $ex) {
            return response()->json(['status' => 500, 'error' => 'Server Error']);
        }
    }
   
    public function assigns(Request $request, $id)
    {
        // $checklist = ->get();
        try {
            $objects_id =array();
            foreach($request->input('data') as $data){
                $objects_id[] = $data['attributes']['object_id'];
                Checklist::where('template_id', $id)
                    ->where('object_id', $data['attributes']['object_id'])
                    ->update([
                        'object_domain' => $data['attributes']['object_domain']
                    ]);
            }

            // $checklist = Checklist::with('item');
                $checklist = Checklist::with('item')
                ->where('template_id', $id)
                ->paginate();
            // dd($checklist);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status' => 404, 'error' => 'Not Found']);
        } catch (Exception $ex) {
            return response()->json(['status' => 500, 'error' => 'Server Error']);
        }

        TemplatesResource2::withoutWrapping();
        
        return new TemplatesResource2($checklist);
    }

}
