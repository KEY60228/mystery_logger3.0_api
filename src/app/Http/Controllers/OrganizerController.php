<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Organizer;

class OrganizerController extends Controller
{
    /**
     * 検索用API。IDと団体名だけ返す
     * 
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Support\Facades\Response
     */
    public function search(Request $request) {
        $organizer = Organizer::query()
            ->select('id', 'service_name', 'company_name')
            ->get();
        return Response::json($organizer, 200);
    }

    /**
     * 主催者情報の取得
     * 
     * @param Illuminate\Http\Request $request
     * @param string $id
     * @return Illuminate\Support\Facades\Response
     */
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
