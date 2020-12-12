<?php

use Illuminate\Database\Seeder;

class OrganizersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organizers')->insert([[
            'service_name' => 'リアル脱出ゲーム',
            'kana_service_name' => 'りあるだっしゅつげーむ',
            'company_name' => '株式会社SCRUP',
            'kana_company_name' => 'すくらっぷ',
            'website' => 'https://realdgame.jp/'
        ], [
            'service_name' => 'タンブルウィード',
            'kana_service_name' => 'たんぶるうぃーど',
            'company_name' => '株式会社グリーンダイス',
            'kana_company_name' => 'ぐりーんだいす',
            'website' => 'https://www.tumbleweed.jp/'
        ], [
            'service_name' => 'NAZO X NAZO劇団',
            'kana_service_name' => 'なぞなぞげきだん',
            'company_name' => '株式会社ハレガケ',
            'kana_company_name' => 'はれがけ',
            'website' => 'https://nazoxnazo.com/'
        ], [
            'service_name' => 'よだかのレコード',
            'kana_service_name' => 'よだかのれこーど',
            'company_name' => '株式会社stamps',
            'kana_company_name' => 'すたんぷす',
            'website' => 'https://yodaka.info//'
        ], [
            'service_name' => 'NoEscape リアル体験脱出ゲーム',
            'kana_service_name' => 'のーえすけーぷ りあるたいけんだっしゅつげーむ',
            'company_name' => '株式会社ライズエンターテインメント',
            'kana_company_name' => 'らいずえんたーていんめんと',
            'website' => 'https://noescape.co.jp/'
        ]]);
    }
}
