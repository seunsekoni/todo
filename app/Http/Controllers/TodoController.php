<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

use App\Http\Requests\TodoRequest;
use App\Http\Resources\Todo as TodoResource;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all todos
        try {
            $todos = Todo::all();
            return $this->sendResponse($todos, 'Successfully fetched all Todos');
        } catch (\Throwable $th) {
            \Log::error($th);
            return $this->sendServerError('Unable to fetch Todos');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoRequest $request)
    {
        // get validated request
        $validated = $request->validated();

        // create a new todo and save it
        try {
            $todo = new Todo();
            $todo = $todo->create($validated);

            return $this->sendResponse(new TodoResource($todo), 'Successfully created a new Todo');
            
        } catch (\Throwable $th) {
            \Log::error($th);
            return $this->sendServerError('Unable to save Todo resource');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($todo=null)
    {
        try {
            // if the returned instance wasn't found
            if(\is_null($todo)) {
                return $this->resourceNotFound();
            }

            return $this->sendResponse(new TodoResource($todo), 'Successfully fetched a Todo');
            
        } catch (\Throwable $th) {
            \Log::error($th);
            return $this->sendServerError('Unable to fetch Todo resource');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TodoRequest $request, $todo=null)
    {
        $validated = $request->validated();
        try {
            // if the returned instance wasn't found
            if(\is_null($todo)) {
                return $this->resourceNotFound();
            }

            // update the Todo
            $todo->update($validated);
    
            return $this->sendResponse(new TodoResource($todo), 'Successfully updated Todo');
            
        } catch (\Throwable $th) {
            \Log::error($th);
            return $this->sendServerError('Unable to update Todo resource');
        }
    }

    /**
     * Mark Todo as completed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function mark_completed($todo=null)
    {
    
        try {
            // if the returned instance wasn't found
            if(\is_null($todo)) {
                return $this->resourceNotFound();
            }

            // mark the Todo as completed
            $todo->update(['completed' => 1] );
    
            return $this->sendResponse(new TodoResource($todo), 'Successfully marked as completed');
            
        } catch (\Throwable $th) {
            \Log::error($th);
            return $this->sendServerError('Unable to mark Todo as completed');
        }
    }

    /**
     * Mark Todo as completed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function mark_incomplete($todo=null)
    {
    
        try {
            // if the returned instance wasn't found
            if(\is_null($todo)) {
                return $this->resourceNotFound();
            }

            // mark the Todo as completed
            $todo->update(['completed' => 0] );
    
            return $this->sendResponse(new TodoResource($todo), 'Successfully marked as incomplete');
            
        } catch (\Throwable $th) {
            \Log::error($th);
            return $this->sendServerError('Unable to mark Todo as incomplete');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($todo=null)
    {
        try {

            // if the returned instance wasn't found
            if(\is_null($todo)) {
                return $this->resourceNotFound();
            }
            $todo->delete();
            return $this->sendResponse(new TodoResource($todo), 'Successfully deleted Todo');

        } catch (\Throwable $th) {
            \Log::error($th);
            return $this->sendServerError('Unable to delete Todo resource');
        }           
    }

    /**
     * Helper method to return json response if a resource 
     * was not found.
     * @return \Illuminate\Http\Response
     */
    private function resourceNotFound()
    {
        // if the returned instance wasn't found
            return response()->json([
                'success'   => false,
                'message'   => 'Resource could not be found.',
            ], 404);
    }
}
