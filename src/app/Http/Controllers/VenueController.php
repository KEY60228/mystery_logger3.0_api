<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Venue;

class VenueController extends Controller
{
    /**
     * 検索用API。IDと会場名、都道府県だけ返す
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Support\Facades\Response
     */
    public function search(Request $request) {
        $result = Venue::query()
            ->select('venues.id', 'venues.name', 'venues.addr_pref_id', 'venues.addr_prefecture', 'organizers.service_name')
            ->leftJoin('organizers', 'venues.organizer_id', 'organizers.id')
            ->get();

        $sorted = $result->groupBy('addr_pref_id')->values();
        $tmp = $sorted->first(function ($item, $key) {
            return $item[0]->addr_pref_id === null;
        })->values();
        $filtered = $sorted->filter(function ($item, $key) {
            return $item[0]->addr_pref_id !== null;
        })->values();
        $venues = $filtered->push($tmp)->values();

        return Response::json($venues->all(), 200);
    }

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
