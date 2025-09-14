<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\CreateTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Traits\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    use ApiResponse, AuthorizesRequests;

    /**
     * Store a new task for the authenticated user
     *
     * @param CreateTaskRequest $request
     * @return JsonResponse
     */
    public function store(CreateTaskRequest $request): JsonResponse
    {
        $task = Task::create([
            'title' => $request->validated()['title'],
            'description' => $request->validated()['description'],
            'user_id' => auth()->user()->getAuthIdentifier()
        ]);

        return $this->successResponse('Task created successfully',$task,201);
    }

    /**
     * Retrieve all tasks belonging to the authenticated user
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tasks = Task::where('user_id',auth()->user()->getAuthIdentifier())->get();

        return $this->successResponse('Tasks retrieved successfully',$tasks,200);
    }

    /**
     * Get a specific task by its ID for the authenticated user
     *
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(int $id): JsonResponse
    {
        $task = Task::findOrFail($id);

        $this->authorize('view',$task);

        return $this->successResponse('Task retrieved successfully',$task,200);
    }

    /**
     * Update a specific task belonging to the authenticated user
     *
     * @param UpdateTaskRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateTaskRequest $request, int $id): JsonResponse
    {
        $task = Task::findOrFail($id);

        $this->authorize('update',$task);

        $task->update($request->validated());

        return $this->successResponse('Task updated successfully',$task,200);
    }

    /**
     * Delete a specific task belonging to the authenticated user
     *
     * @param int $id
     * @return Response
     * @throws AuthorizationException
     */
    public function delete(int $id): Response
    {
        $task = Task::findOrFail($id);

        $this->authorize('delete',$task);

        $task->delete();

        return response()->noContent();
    }
}
