<?php

namespace App\Http\Controllers;

use App\Http\Repositories\TodoRepository;
use App\Http\Requests\TodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Exception;
use Illuminate\Http\Request;

class TodoController extends Controller
{

    public function __construct(private TodoRepository $todoRepository)
    {
    }
    public function index(Request $request)
    {
        $todos = $this->todoRepository->search($request)->orderByDesc('id')->get();

        return response()->json(['todos' =>  TodoResource::collection($todos)]);
    }

    public function store (TodoRequest $request)
    {
        try {

            $todos = $this->todoRepository->fill($request);

            return response()->json(['todos' =>  new TodoResource($todos)]);
        } catch(Exception $e) {

            return response()->json(['error' =>  'there is error from our side']);
        }
    }

    public function update (TodoRequest $request, $todo)
    {
        try {

            $request->merge(['id'=>$todo]);
            $todoObj = $this->todoRepository->search($request)->first();
            if(!isset($todoObj)) {

                return response()->json(['error' =>  'this id doesnot exist']);
            }

            $todos = $this->todoRepository->fill($request, $todoObj);

            return response()->json(['todos' =>  new TodoResource($todos)]);
        } catch(Exception $e) {

            return response()->json(['error' =>  'there is error from our side']);
        }
    }

    public function destroy (Request $request, $todo)
    {
        try {
            $request->merge(['id'=>$todo]);
            $todoObj = $this->todoRepository->search($request)->first();
            if(!isset($todoObj)) {

                return response()->json(['error' =>  'this id doesnot exist']);
            }

           $this->todoRepository->destroy($todoObj);

            return response()->json(['todos' =>  'element deleted']);
        } catch(Exception $e) {

            return response()->json(['error' =>  'there is error from our side']);
        }
    }
}
