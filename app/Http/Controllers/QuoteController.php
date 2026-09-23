<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Get a random quote by language
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getQuoteByLanguage(Request $request): JsonResponse
    {
        try {
            // Get language from query parameter or request body
            $language = $request->get('language') ?? request('selected_language');

            // Validate language
            if (!$language) {
                return response()->json([
                    'status' => false,
                    'message' => 'Language selection is required',
                ], 400);
            }

            // Get a random quote for the specified language
            $quote = Quote::where('language', $language)
                ->inRandomOrder()
                ->first();

            if (!$quote) {
                return response()->json([
                    'status' => false,
                    'message' => 'No quotes found for this language',
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Quote retrieved successfully',
                'data' => [
                    'language' => $quote->language,
                    'quote' => $quote->quote_text,
                    'category' => $quote->category,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving quote',
            ], 500);
        }
    }

    /**
     * Get all quotes for a specific language
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getQuotesByLanguage(Request $request): JsonResponse
    {
        try {
            
            $quotes = Quote::get();

            $groupedQuotes = $quotes->groupBy('language')->map(function ($group) {
                // Remove duplicate quote_text within each language
                return $group->unique('quote_text')->values()->map(function ($quote) {
                    return [
                        'id' => $quote->id,
                        'quote' => $quote->quote_text,
                        'category' => $quote->category,
                    ];
                });
            });

            return response()->json([
                'status' => true,
                'message' => 'Quotes retrieved successfully',
                'data' => $groupedQuotes,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving quotes',
            ], 500);
        }
    }

    /**
     * Get all available languages with quote count
     *
     * @return JsonResponse
     */
    public function getAvailableLanguages(): JsonResponse
    {
        try {
            $languages = Quote::selectRaw('language, COUNT(*) as quote_count')
                ->groupBy('language')
                ->orderBy('language')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Languages retrieved successfully',
                'data' => [
                    'languages' => $languages,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving languages',
            ], 500);
        }
    }
}
