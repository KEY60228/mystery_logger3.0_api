<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Venue;

class VenueController extends Controller
{
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
            return Response::json([], 422);
        }

        return Response::json($venue, 200);
    }
}
