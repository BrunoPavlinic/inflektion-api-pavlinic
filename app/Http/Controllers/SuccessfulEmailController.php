<?php

namespace App\Http\Controllers;

use App\Models\SuccessfulEmail;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SuccessfulEmailController extends Controller
{
    /**
     * Get all successful emails with optional pagination
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 15);
        $emails = SuccessfulEmail::paginate($perPage);
        
        return response()->json($emails);
    }

    /**
     * Get a specific successful email by ID
     */
    public function show(int $id): JsonResponse
    {
        $email = SuccessfulEmail::findOrFail($id);
        return response()->json($email);
    }

    /**
     * Update a specific successful email
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $email = SuccessfulEmail::findOrFail($id);
        
        $validated = $request->validate([
            'affiliate_id' => 'sometimes|integer',
            'envelope' => 'sometimes|string',
            'from' => 'sometimes|string|max:255',
            'subject' => 'sometimes|string',
            'dkim' => 'sometimes|nullable|string|max:255',
            'SPF' => 'sometimes|nullable|string|max:255',
            'spam_score' => 'sometimes|nullable|numeric',
            'email' => 'sometimes|string',
            'raw_text' => 'sometimes|string',
            'sender_ip' => 'sometimes|nullable|string|max:50',
            'to' => 'sometimes|string',
            'timestamp' => 'sometimes|integer'
        ]);

        $email->update($validated);
        return response()->json($email);
    }

    /**
     * Soft delete a successful email
     */
    public function destroy(int $id): JsonResponse
    {
        $email = SuccessfulEmail::findOrFail($id);
        $email->delete();
        
        return response()->json(['message' => 'Email deleted successfully']);
    }
    
    /**
     * Create a new successful email record
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'affiliate_id' => 'required|integer',
            'envelope' => 'required|string',
            'from' => 'required|string|max:255',
            'subject' => 'required|string',
            'dkim' => 'nullable|string|max:255',
            'SPF' => 'nullable|string|max:255',
            'spam_score' => 'nullable|numeric',
            'email' => 'required|string',
            'raw_text' => 'nullable|string',
            'sender_ip' => 'nullable|string|max:50',
            'to' => 'required|string',
            'timestamp' => 'required|integer'
        ]);

        if (empty($validated['raw_text'])) {    
            $validated['raw_text'] = "";
        }

        $email = SuccessfulEmail::create($validated);
        $email->parseAndSaveRawText();
        
        return response()->json($email, 201);
    }
} 