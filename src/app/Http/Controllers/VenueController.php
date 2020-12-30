<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Venue;

class VenueController extends Controller
{
    /**
     * 会場情報の取得
     * 
     * @param Illuminate\Http\Request $request
     * @param string $id
     * @return Illuminate\Support\Facades\Response
     */
    public function show(Request $request, $id) {
        $venue = Venue::whereId($id)->with([
            'organizer',
            'performances',
            'performances.product',
            'performances.product.category',
            'performances.product.organizer',
            'performances.product.performances',
            'performances.product.performances.venue',
        ])->first();

        if (!$venue) {
            return Response::json([
                'errors' => [
                    'venue_id' => [
                        '指定されたvenue idは存在しません。'
                    ],
                ],
                'message' => 'The given data was invalid.'
            ], 404);
        }

        return Response::json($venue, 200);
    }
}
