<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Organizer;

class OrganizerController extends Controller
{
    public function show(Request $request, $id) {
        $organizer = Organizer::whereId($id)->with([
            'products',
            'products.category',
            'products.organizer',
            'products.performances',
            'products.performances.venue',
            'venues',
        ])->first();

        if (!$organizer) {
            return Response::json([
                'errors' => [
                    'organizer_id' => [
                        '指定されたorganizer idは存在しません。'
                    ],
                ],
                'message' => 'The given data was invalid.'
            ], 404);
        }

        return Response::json($organizer, 200);
    }
}
