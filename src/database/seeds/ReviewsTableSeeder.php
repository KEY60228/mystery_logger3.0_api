<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $contents = [
            '',
            'イマイチだった…',
            '何か惜しい！って感じ',
            'まあまあだった',
            '面白かった！',
            '最高！！',
        ];

        for ($i = 0; $i < 50; $i++) {
            $rating = rand(0, 5);
            $content = $contents[$rating];
            $data[] = [
                'user_id' => rand(1, 10),
                'product_id' => rand(1, 160),
                'spoil' => (bool)rand(0, 1),
                'contents' => $content,
                'result' => rand(0, 2),
                'rating' => $rating,
                'joined_at' => date('Y-m-d', rand(strtotime('1 Jan 2020'), strtotime('3 Mar 2021'))),
            ];
        }
        DB::table('reviews')->insert($data);
    }
}
