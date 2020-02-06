<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Todo;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();

        return response()->json([
            'type' => 'success',
            'data' => $todos
        ], 200);

    }

    public function show($id)
    {
        $todo = Todo::find($id);

        return response()->json([
            'type' => 'success',
            'data' => $todo
        ], 200);
    }

    public function store(Request $request)
    {
        $todo = new Todo;
        $todo->user_id = auth()->user()->id;
        $todo->title = $request->title;
        $todo->done = 0;
        $todo->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Data saved successfully'
        ], 201);

    }

    public function update(Request $request, $id)
    {
        $todo = Todo::find($id);
        $todo->user_id = auth()->user()->id;
        $todo->title = $request->title;
        $todo->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Data updated successfully'
        ], 201);
    }

    public function toggle($id)
    {
        $todo = Todo::find($id);
        $todo->done = $todo->done ? 0 : 1;
        $todo->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Data updated'
        ], 201);

    }

    public function destroy($id)
    {
        $todo = Todo::find($id);
        $todo->delete();

        return response()->json([
            'type' => 'success',
            'message' =>  'Data deleted successfully'
        ], 200);
    }
}
