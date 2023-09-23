<?php

namespace App\Http\Repositories;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoRepository
{
   public function search (Request $request)
   {
        $todo = Todo::query();

        if($request->filled('id')) {
            $todo->where('id', $request->id);
        }

        return $todo;
   }

   public function fill (Request $request, Todo $todo = null  )
   {
       if(! isset($todo)) {

           $todo = new Todo();
        }

        $todo->title = $request->title;
        $todo->notes = $request->notes;

        if($request->filled('date')) {

            $todo->created_at = $request->date;
        }

        if($request->filled('status')) {

            $todo->status = $request->status;
        }
        
        $todo->save();

        return $todo;
   }

   public function destroy (Todo $todo)
   {
       return $todo->delete();
   }

}
