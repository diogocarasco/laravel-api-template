<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'text1' => 'required|string',
            'text2' => 'nullable|string',
            'text3' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $message = $this->messageService->create($data);

        return response()->json($message, 201);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'text1' => 'sometimes|string',
            'text2' => 'nullable|string',
            'text3' => 'nullable|string',
            'date' => 'sometimes|date',
        ]);

        $message = $this->messageService->update($id, $data);

        return response()->json($message);
    }

    public function destroy(string $id)
    {
        $this->messageService->delete($id);

        return response()->json(['message' => 'Deleted successfully']);
    }
}
