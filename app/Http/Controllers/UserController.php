<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserDetailsRequest;
use App\Models\User;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * STEP 1: Store user details in database (quotes_id = NULL initially)
     *
     * @param UserDetailsRequest $request
     * @return JsonResponse
     */
    public function store(UserDetailsRequest $request): JsonResponse
    {
        try {
            // Get validated data from request
            $validatedData = $request->validated();
            

            
            // Create new user record
            $user = User::create($validatedData);
            
            return response()->json([
                'status' => true,
                'message' => 'User registered successfully. Please select a quote.',
                'data' => [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'age' => $user->age,
                    'location' => $user->location,
                    'selected_language' => $user->selected_language,
                    'quotes_id' => $user->quotes_id, 
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error saving user data',
            ], 500);
        }
    }

    /**
     * STEP 2: User selects a quote - fetch random quote and store quote ID in user table
     *
     * @param Request $request
     * @param int $userId
     * @return JsonResponse
     */
    public function selectQuote(Request $request, int $userId): JsonResponse
    {
        try {
            // Find user
            $user = User::find($userId);
            
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                ], 404);
            }
            
            // Fetch a random quote in user's selected language
            // Only select a quote if user has not already selected one
            if ($user->quotes_id) {
                $quote = Quote::find($user->quotes_id);
            } else {
                $quote = Quote::where('language', $user->selected_language)
                    ->inRandomOrder()
                    ->first();
                // Update user's quotes_id (remove NULL, store quote ID)
                if ($quote) {
                    $user->update([
                        'quotes_id' => $quote->id,
                    ]);
                }
            }
            
            if (!$quote) {
                return response()->json([
                    'status' => false,
                    'message' => 'No quotes found for this language',
                ], 404);
            }
            
            // Update user's quotes_id (remove NULL, store quote ID)
            // $user->update([
            //     'quotes_id' => $quote->id,
            // ]);
            
            return response()->json([
                'status' => true,
                'message' => 'Quote selected and stored successfully',
                'data' => [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'selected_language' => $user->selected_language,
                    'quotes_id' => $user->quotes_id,
                    'quote_text' => $quote ? $quote->quote_text : null,
                    'category' => $quote ? $quote->category : null,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error selecting quote',
            ], 500);
        }
    }

    /**
     * Get latest 8 users (API)
     *
     * @return JsonResponse
     */
    public function latestNamesApi(): JsonResponse
    {
        try {
            $users = User::with('quote')
                ->latest()
                ->limit(8)
                ->get();

            $data = $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'age' => $user->age,
                    'location' => $user->location,
                    'selected_language' => $user->selected_language,
                    'quote_text' => $user->quote ? $user->quote->quote_text : null,
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Latest users retrieved successfully',
                'display_name' => 'Latest Users',
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving latest users',
            ], 500);
        }
    }
}

