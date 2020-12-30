<?php

use Illuminate\Database\Seeder;

class VenuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('venues')->insert([
            [
                'organizer_id' => 1,
                'name' => '東京ミステリーサーカス',
                'kana_name' => 'とうきょうみすてりーさーかす',
                'zipcode' => '160-0021',
                'addr_prefecture' => '東京都',
                'addr_city' => '新宿区',
                'addr_block' => '歌舞伎町1-27-5',
                'addr_building' => 'APMビル',
                'lat' => '35.69553182952719',
                'long' => '139.7006857938024',
                'tel' => '03-6273-8641',
            ],
            [
                'organizer_id' => 1,
                'name' => '原宿ヒミツキチオブスクラップ',
                'kana_name' => 'はらじゅくひみつきちおぶすくらっぷ',
                'zipcode' => '150-0001',
                'addr_prefecture' => '東京都',
                'addr_city' => '渋谷区',
                'addr_block' => '神宮前4-28-12',
                'addr_building' => 'ジャスト原宿 B1F',
                'lat' => '35.66891722573332',
                'long' => '139.7068712711649',
                'tel' => '03-6804-1021',
            ],
            [
                'organizer_id' => 1,
                'name' => '横浜ヒミツキチオブスクラップ',
                'kana_name' => 'よこはまひみつきちおぶすくらっぷ',
                'zipcode' => '220-0011',
                'addr_prefecture' => '神奈川県',
                'addr_city' => '横浜市西区',
                'addr_block' => '高島2-14-9',
                'addr_building' => 'アソビル',
                'lat' => '35.46432284421585',
                'long' => '139.62219884786663',
                'tel' => '050-3160-2005',
            ],
            [
                'organizer_id' => 1,
                'name' => 'ナゾ・コンプレックス名古屋',
                'kana_name' => 'なぞ・こんぷれっくすなごや',
                'zipcode' => '460-0011',
                'addr_prefecture' => '愛知県',
                'addr_city' => '名古屋市中区',
                'addr_block' => '大須4-1-71',
                'addr_building' => '矢場町中駒ビル',
                'lat' => '35.161628075699596',
                'long' => '136.90684001718594',
                'tel' => '052-228-8561',
            ],
            [
                'organizer_id' => 1,
                'name' => '大阪ヒミツキチオブスクラップ',
                'kana_name' => 'おおさかひみつきちおぶすくらっぷ',
                'zipcode' => '542-0086',
                'addr_prefecture' => '大阪府',
                'addr_city' => '大阪市中央区',
                'addr_block' => '西心斎橋2-11-30',
                'addr_building' => 'ブルータスビル 6F',
                'lat' => '34.672237063264184',
                'long' => '135.4980941018456',
                'tel' => '06-6121-2939',
            ],
            [
                'organizer_id' => 1,
                'name' => 'アジトオブスクラップ札幌',
                'kana_name' => 'あじとおぶすくらっぷ さっぽろ',
                'zipcode' => '060-0061',
                'addr_prefecture' => '北海道',
                'addr_city' => '札幌市中央区',
                'addr_block' => '南1条西4-13',
                'addr_building' => '日之出ビル 8F',
                'lat' => '43.0596974655348',
                'long' => '141.35235313621752',
                'tel' => '011-522-8777',
            ],
            [
                'organizer_id' => 1,
                'name' => 'アジトオブスクラップ仙台',
                'kana_name' => 'あじとおぶすくらっぷ せんだい',
                'zipcode' => '980-0021',
                'addr_prefecture' => '宮城県',
                'addr_city' => '仙台市青葉区',
                'addr_block' => '中央2-6-32',
                'addr_building' => 'ダイヤクレストビル 6F',
                'lat' => '38.26259708440411',
                'long' => '140.879198781663',
                'tel' => '022-797-3323',
            ],
            [
                'organizer_id' => 1,
                'name' => 'アジトオブスクラップ池袋',
                'kana_name' => 'あじとおぶすくらっぷ いけぶくろ',
                'zipcode' => '171-0022',
                'addr_prefecture' => '東京都',
                'addr_city' => '豊島区',
                'addr_block' => '南池袋1-19-12',
                'addr_building' => '山の手ビル 東館 4F-A',
                'lat' => '35.72804641880941',
                'long' => '139.71338912030163',
                'tel' => '03-5904-9956',
            ],
            [
                'organizer_id' => 1,
                'name' => 'アジトオブスクラップ東新宿GUNKAN',
                'kana_name' => 'あじとおぶすくらっぷ ひがししんじゅく ぐんかん',
                'zipcode' => '169-0072',
                'addr_prefecture' => '東京都',
                'addr_city' => '新宿区',
                'addr_block' => '大久保1-1-10',
                'addr_building' => 'GUNKAN東新宿301, 302, 401',
                'lat' => '35.69861429406684',
                'long' => '139.70587705038525',
                'tel' => '03-6233-9868',
            ],
            [
                'organizer_id' => 1,
                'name' => 'アジトオブスクラップ浅草',
                'kana_name' => 'あじとおぶすくらっぷ あさくさ',
                'zipcode' => '130-0001',
                'addr_prefecture' => '東京都',
                'addr_city' => '墨田区',
                'addr_block' => '吾妻橋1-17-2',
                'addr_building' => '',
                'lat' => '35.70903016799494',
                'long' => '139.80044437083387',
                'tel' => '03-6284-1696',
            ],
            [
                'organizer_id' => 1,
                'name' => 'SCRAPナゾビル 吉祥寺',
                'kana_name' => 'すくらっぷ なぞびる きちじょうじ',
                'zipcode' => '180-0004',
                'addr_prefecture' => '東京都',
                'addr_city' => '武蔵野市',
                'addr_block' => '吉祥寺本町1-9-7',
                'addr_building' => '',
                'lat' => '35.70481300459027',
                'long' => '139.5801845099012',
                'tel' => '0422-27-1951',
            ],
            [
                'organizer_id' => 1,
                'name' => 'アジトオブスクラップ下北沢ナゾビル',
                'kana_name' => 'あじとおぶすくらっぷ しもきたざわ なぞびる',
                'zipcode' => '155-0031',
                'addr_prefecture' => '東京都',
                'addr_city' => '世田谷区',
                'addr_block' => '北沢2-14-14',
                'addr_building' => '',
                'lat' => '35.660386399331514',
                'long' => '139.66790101718595',
                'tel' => '03-5432-9805',
            ],
            [
                'organizer_id' => 1,
                'name' => 'アジトオブスクラップ横浜中華街',
                'kana_name' => 'あじとおぶすくらっぷ よこはまちゅうかがい',
                'zipcode' => '231-0023',
                'addr_prefecture' => '神奈川県',
                'addr_city' => '横浜市中区',
                'addr_block' => '下町78-8',
                'addr_building' => '横浜イーストゲートビル 6',
                'lat' => '35.44519359956111',
                'long' => '139.6496938516769',
                'tel' => '045-264-9348',
            ],
            [
                'organizer_id' => 1,
                'name' => 'アジトオブスクラップ京都',
                'kana_name' => 'あじとおぶすくらっぷ きょうと',
                'zipcode' => '604-0815',
                'addr_prefecture' => '京都府',
                'addr_city' => '京都市中京区',
                'addr_block' => '中町540',
                'addr_building' => 'ワキサカビル 3F',
                'lat' => '35.016529225475274',
                'long' => '135.76308935963482',
                'tel' => '075-275-1988',
            ],
            [
                'organizer_id' => 1,
                'name' => 'アジトオブスクラップ大阪ナゾビル',
                'kana_name' => 'あじとおぶすくらっぷ おおさか なぞビル',
                'zipcode' => '556-0005',
                'addr_prefecture' => '大阪府',
                'addr_city' => '大阪市浪速区',
                'addr_block' => '日本橋5-13-5',
                'addr_building' => '',
                'lat' => '34.6563760913281',
                'long' => '135.50651307001385',
                'tel' => '06-6634-5115',
            ],
            [
                'organizer_id' => 1,
                'name' => 'アジトオブスクラップ岡山',
                'kana_name' => 'あじとおぶすくらっぷ おかやま',
                'zipcode' => '700-0822',
                'addr_prefecture' => '岡山県',
                'addr_city' => '岡山市北区',
                'addr_block' => '表町1-1-45',
                'addr_building' => '',
                'lat' => '34.66530463099359',
                'long' => '133.92879495220302',
                'tel' => '086-238-2429',
            ],
            [
                'organizer_id' => 1,
                'name' => 'アジトオブスクラップ福岡・天神',
                'kana_name' => 'あじとおぶすくらっぷ ふくおか てんじん',
                'zipcode' => '810-0021',
                'addr_prefecture' => '福岡県',
                'addr_city' => '福岡市中央区',
                'addr_block' => '今泉1-13-30',
                'addr_building' => 'JOJIビル 4F',
                'lat' => '33.58687394246621',
                'long' => '130.40051447485612',
                'tel' => '092-707-2610',
            ],
            [
                'organizer_id' => 2,
                'name' => '絶対空間 本館',
                'kana_name' => 'ぜったいくうかん ほんかん',
                'zipcode' => '171-0022',
                'addr_prefecture' => '東京都',
                'addr_city' => '豊島区',
                'addr_block' => '南池袋3-18-30',
                'addr_building' => 'ファースト日野ビル 4F',
                'lat' => '35.725831374112154',
                'long' => '139.71544683322085',
                'tel' => '03-5944-8840',
            ],
            [
                'organizer_id' => 2,
                'name' => '絶対空間 2号館',
                'kana_name' => 'ぜったいくうかん にごうかん',
                'zipcode' => '171-0022',
                'addr_prefecture' => '東京都',
                'addr_city' => '豊島区',
                'addr_block' => '南池袋2-33-6',
                'addr_building' => '大同ビル 5F',
                'lat' => '35.726997690602104',
                'long' => '139.71571605155782',
                'tel' => '03-5944-8840',
            ],
            [
                'organizer_id' => 2,
                'name' => '絶対空間 3号館',
                'kana_name' => 'ぜったいくうかん さんごうかん',
                'zipcode' => '171-0022',
                'addr_prefecture' => '東京都',
                'addr_city' => '豊島区',
                'addr_block' => '南池袋2-33-6',
                'addr_building' => '大同ビル 4F',
                'lat' => '35.726997690602104',
                'long' => '139.71571605155782',
                'tel' => '03-5944-8840',
            ],
            [
                'organizer_id' => 2,
                'name' => '絶対空間 4号館',
                'kana_name' => 'ぜったいくうかん よんごうかん',
                'zipcode' => '171-0022',
                'addr_prefecture' => '東京都',
                'addr_city' => '豊島区',
                'addr_block' => '南池袋3-18-30',
                'addr_building' => 'ファースト日野ビル 5F',
                'lat' => '35.725831374112154',
                'long' => '139.71544683322085',
                'tel' => '03-5944-8840',
            ],
            [
                'organizer_id' => 3,
                'name' => '上野店',
                'kana_name' => 'うえのてん',
                'zipcode' => '110-0005',
                'addr_prefecture' => '東京都',
                'addr_city' => '台東区',
                'addr_block' => '上野2-14-30',
                'addr_building' => 'ライオンズビル3F',
                'lat' => '35.71088378203392',
                'long' => '139.77308857922063',
                'tel' => '03-6284-2333',
            ],
            [
                'organizer_id' => 3,
                'name' => '秋葉原店',
                'kana_name' => 'あきはばらてん',
                'zipcode' => '101-0021',
                'addr_prefecture' => '東京都',
                'addr_city' => '千代田区',
                'addr_block' => '外神田4-8-3',
                'addr_building' => 'セゾン秋葉原 4F & 5F',
                'lat' => '35.702767172335676',
                'long' => '139.77256083319946',
                'tel' => '03-6875-9599',
            ],
            [
                'organizer_id' => 4,
                'name' => '新宿店',
                'kana_name' => 'しんじゅくてん',
                'zipcode' => '151-0053',
                'addr_prefecture' => '東京都',
                'addr_city' => '渋谷区',
                'addr_block' => '代々木3-46-16',
                'addr_building' => '小野木ビル 5F',
                'lat' => '35.68268603560191',
                'long' => '139.697107817305',
                'tel' => '03-6276-7561',
            ],
            [
                'organizer_id' => 4,
                'name' => '池袋店',
                'kana_name' => 'いけぶくろてん',
                'zipcode' => '170-0012',
                'addr_prefecture' => '東京都',
                'addr_city' => '豊島区',
                'addr_block' => '上池袋2-8-6',
                'addr_building' => '',
                'lat' => '35.73527691137658',
                'long' => '139.7158129791526',
                'tel' => '03-6903-6650',
            ],
            [
                'organizer_id' => 5,
                'name' => '新宿店',
                'kana_name' => 'しんじゅくてん',
                'zipcode' => '160-0021',
                'addr_prefecture' => '東京都',
                'addr_city' => '新宿区',
                'addr_block' => '歌舞伎町2-14-12',
                'addr_building' => '光凛ビル B2F',
                'lat' => '35.69888714187485',
                'long' => '139.70961378801346',
                'tel' => '03-6380-2240',
            ],
            [
                'organizer_id' => 6,
                'name' => '謎キャッスル',
                'kana_name' => 'なぞきゃっする',
                'zipcode' => '',
                'addr_prefecture' => '東京都',
                'addr_city' => '練馬区',
                'addr_block' => '北町2-17-15',
                'addr_building' => '謎キャッスル',
                'lat' => '35.76737825598384',
                'long' => '139.66325913689232',
                'tel' => '03-6281-0850',
            ],
            [
                'organizer_id' => 8,
                'name' => 'サニーサニーピクニック',
                'kana_name' => 'さにーさにーぴくにっく',
                'zipcode' => '103-0022',
                'addr_prefecture' => '東京都',
                'addr_city' => '中央区',
                'addr_block' => '日本橋室町1-12-5',
                'addr_building' => '',
                'lat' => '35.68625697896239',
                'long' => '139.77515191316309',
                'tel' => '03-6873-5772',
            ],
            [
                'organizer_id' => 9,
                'name' => 'なぞばこ 東京',
                'kana_name' => 'なぞばこ とうきょう',
                'zipcode' => '111-0032',
                'addr_prefecture' => '東京都',
                'addr_city' => '台東区',
                'addr_block' => '浅草1-10-5',
                'addr_building' => 'KN浅草ビル 6F',
                'lat' => '35.71685416212803',
                'long' => '139.78382056388048',
                'tel' => '050-5585-3663',
            ],
            [
                'organizer_id' => 10,
                'name' => 'inspyre',
                'kana_name' => 'インスパイヤ',
                'zipcode' => '160-0021',
                'addr_prefecture' => '東京都',
                'addr_city' => '新宿区',
                'addr_block' => '歌舞伎町1-20-1',
                'addr_building' => 'Humax Pavilion 新宿 6F',
                'lat' => '35.695995092720146',
                'long' => '139.70153967361577',
                'tel' => '03-5155-1481',
            ],
            [
                'organizer_id' => 11,
                'name' => '新宿店',
                'kana_name' => 'しんじゅくてん',
                'zipcode' => '160-0021',
                'addr_prefecture' => '東京都',
                'addr_city' => '新宿区',
                'addr_block' => '歌舞伎町16-5',
                'addr_building' => 'ドン・キホーテ新宿東口本店 7F',
                'lat' => '35.6940481146538',
                'long' => '139.70201690323475',
                'tel' => '03-6205-5606',
            ],
            [
                'organizer_id' => 11,
                'name' => '京都新京極店',
                'kana_name' => 'きょうとしんきょうごくてん',
                'zipcode' => '604-8046',
                'addr_prefecture' => '京都府',
                'addr_city' => '京都市中京区',
                'addr_block' => '新京極蛸薬師下る東側町中京区525-1',
                'addr_building' => '京都吉本ビルパッサージオ 3F 自遊空間内',
                'lat' => '35.00584218516295',
                'long' => '135.7685572393332',
                'tel' => '',
            ],
            [
                'organizer_id' => 11,
                'name' => 'なんばパークス店',
                'kana_name' => 'なんばぱーくすてん',
                'zipcode' => '556-0011',
                'addr_prefecture' => '大阪府',
                'addr_city' => '大阪市浪速区10',
                'addr_block' => '難波中2-10-70',
                'addr_building' => 'なんばパークス',
                'lat' => '34.66187546342332',
                'long' => '135.50242540865253',
                'tel' => '06-6567-8353',
            ],
            [
                'organizer_id' => 12,
                'name' => 'Puzzle Room Tokyo',
                'kana_name' => 'ぱずるるーむとうきょう',
                'zipcode' => '104-0045',
                'addr_prefecture' => '東京都',
                'addr_city' => '中央区',
                'addr_block' => '築地6-27-5',
                'addr_building' => '',
                'lat' => '35.66395207168418',
                'long' => '139.77153479825103',
                'tel' => '',
            ],
            [
                'organizer_id' => 15,
                'name' => '忍者屋敷シュリケン',
                'kana_name' => 'にんじゃやしき しゅりけん',
                'zipcode' => '168-0062',
                'addr_prefecture' => '東京都',
                'addr_city' => '杉並区',
                'addr_block' => '方南2-23-22',
                'addr_building' => '方南ファミリーコーポ共同ビル 3F',
                'lat' => '35.683857764098775',
                'long' => '139.6574206890235',
                'tel' => '03-6454-6786',
            ],
            [
                'organizer_id' => 16,
                'name' => '東京密室',
                'kana_name' => 'とうきょうみっしつ',
                'zipcode' => '101-0021',
                'addr_prefecture' => '東京都',
                'addr_city' => '千代田区',
                'addr_block' => '外神田2-10-8',
                'addr_building' => '富士ビル 2F',
                'lat' => '35.70162174370713',
                'long' => '139.7693943917109',
                'tel' => '03-6206-8366',
            ],
            [
                'organizer_id' => 17,
                'name' => 'クワトロラボ',
                'kana_name' => 'くわとろらぼ',
                'zipcode' => '125-0061',
                'addr_prefecture' => '東京都',
                'addr_city' => '葛飾区',
                'addr_block' => '亀有3-20-2',
                'addr_building' => '都ビル亀有6F',
                'lat' => '35.765269091931195',
                'long' => '139.84816527452637',
                'tel' => '070-8443-2922',
            ],
            [
                'organizer_id' => 19,
                'name' => 'XEOXY',
                'kana_name' => 'ぜおくしー',
                'zipcode' => '160-0023',
                'addr_prefecture' => '東京都',
                'addr_city' => '新宿区',
                'addr_block' => '西新宿6-26-9',
                'addr_building' => '宝栄成子坂ビル 3F',
                'lat' => '35.69563392151585',
                'long' => '139.68852274853964',
                'tel' => '03-6279-0042',
            ],
            [
                'organizer_id' => 20,
                'name' => 'LUNA HALA',
                'kana_name' => 'るなはら',
                'zipcode' => '104-0045',
                'addr_prefecture' => '東京都',
                'addr_city' => '中央区',
                'addr_block' => '築地3-17-10',
                'addr_building' => '',
                'lat' => '35.666816071162216',
                'long' => '139.77306274856122',
                'tel' => '070-3336-7116',
            ],
            [
                'organizer_id' => 21,
                'name' => '謎解きcafe スイッチ',
                'kana_name' => 'なぞときかふぇ すいっち',
                'zipcode' => '155-0031',
                'addr_prefecture' => '東京都',
                'addr_city' => '世田谷区',
                'addr_block' => '北沢2-15-15',
                'addr_building' => '2F',
                'lat' => '35.65991143742886',
                'long' => '139.66737465276842',
                'tel' => '03-6453-1880',
            ],
            [
                'organizer_id' => 21,
                'name' => 'タンブルウィード ナゾスペース',
                'kana_name' => 'たんぶるうぃーど なぞすぺーす',
                'zipcode' => '155-0031',
                'addr_prefecture' => '東京都',
                'addr_city' => '世田谷区',
                'addr_block' => '北沢2-22-16',
                'addr_building' => 'シュロス下北沢 1F',
                'lat' => '35.66186139057998',
                'long' => '139.66599896562812',
                'tel' => '',
            ],
            [
                'organizer_id' => 21,
                'name' => 'ヒラメカ下北沢',
                'kana_name' => 'ひらめかしもきたざわ',
                'zipcode' => '',
                'addr_prefecture' => '東京都',
                'addr_city' => '世田谷区',
                'addr_block' => '北沢2-12-2',
                'addr_building' => 'サウスウェーブ下北沢 4F',
                'lat' => '35.661559053896916',
                'long' => '139.6699209866243',
                'tel' => '03-6805-5156',
            ],
            [
                'organizer_id' => 23,
                'name' => 'ドラマチックルーム',
                'kana_name' => 'どらまちっくるーむ',
                'zipcode' => '169-0074',
                'addr_prefecture' => '東京都',
                'addr_city' => '新宿区',
                'addr_block' => '北新宿2-2-26',
                'addr_building' => '',
                'lat' => '35.69758904659228',
                'long' => '139.69065612080487',
                'tel' => '03-5337-8650',
            ],
            [
                'organizer_id' => 23,
                'name' => 'ドラマチックホール',
                'kana_name' => 'どらまちっくほーる',
                'zipcode' => '169-0074',
                'addr_prefecture' => '東京都',
                'addr_city' => '新宿区',
                'addr_block' => '北新宿1-4-1',
                'addr_building' => '',
                'lat' => '35.699109065321274',
                'long' => '139.69676055648932',
                'tel' => '03-5337-8650',
            ],
            [
                'organizer_id' => 24,
                'name' => 'オンライン',
                'kana_name' => 'おんらいん',
                'zipcode' => '',
                'addr_prefecture' => '',
                'addr_city' => '',
                'addr_block' => '',
                'addr_building' => '',
                'lat' => '',
                'long' => '',
                'tel' => '',
            ],
            [
                'organizer_id' => 24,
                'name' => '西鉄ホール',
                'kana_name' => 'にしてつほーる',
                'zipcode' => '810-0001',
                'addr_prefecture' => '福岡県',
                'addr_city' => '福岡市中央区',
                'addr_block' => '天神2-11-3',
                'addr_building' => 'ソラリアステージ 6F',
                'lat' => '33.5903914441472',
                'long' => '130.39901207916404',
                'tel' => '092-734-1362',
            ],
            [
                'organizer_id' => 24,
                'name' => '日本科学未来館',
                'kana_name' => 'にほんかがくみらいかん',
                'zipcode' => '135-0064',
                'addr_prefecture' => '東京都',
                'addr_city' => '江東区',
                'addr_block' => '青海2-3-6',
                'addr_building' => '',
                'lat' => '35.619488506600156',
                'long' => '139.77673745591989',
                'tel' => '03-3570-9151',
            ],
            [
                'organizer_id' => 24,
                'name' => '東京ドームシティ',
                'kana_name' => 'とうきょうどーむしてぃ',
                'zipcode' => '112-0004',
                'addr_prefecture' => '東京都',
                'addr_city' => '文京区',
                'addr_block' => '後楽1-3-61',
                'addr_building' => '',
                'lat' => '35.70487756783798',
                'long' => '139.7531859368907',
                'tel' => '03-5800-9999',
            ],
            [
                'organizer_id' => 24,
                'name' => 'ひらかたパーク',
                'kana_name' => 'ひらかたぱーく',
                'zipcode' => '573-0054',
                'addr_prefecture' => '大阪府',
                'addr_city' => '枚方市',
                'addr_block' => '枚方公園町1-1',
                'addr_building' => '',
                'lat' => '34.80628028804752',
                'long' => '135.6394898763523',
                'tel' => '0570-016-855',
            ],
            [
                'organizer_id' => 24,
                'name' => '大阪メトロ',
                'kana_name' => 'おおさかめとろ',
                'zipcode' => '',
                'addr_prefecture' => '',
                'addr_city' => '',
                'addr_block' => '',
                'addr_building' => '',
                'lat' => '',
                'long' => '',
                'tel' => '',
            ],
            [
                'organizer_id' => 24,
                'name' => 'アズーロ・ネロ',
                'kana_name' => 'あずーろ・ねろ',
                'zipcode' => '211-0005',
                'addr_prefecture' => '神奈川県',
                'addr_city' => '川崎市中原区',
                'addr_block' => '新丸子町1008-2',
                'addr_building' => '',
                'lat' => '35.57719083791518',
                'long' => '139.66066359170838',
                'tel' => '044-767-6111',
            ],
            [
                'organizer_id' => 24,
                'name' => 'HIKARIビル',
                'kana_name' => 'ひかりびる',
                'zipcode' => '',
                'addr_prefecture' => '東京都',
                'addr_city' => '杉並区',
                'addr_block' => '上井草1-9-21',
                'addr_building' => 'HIKARIビル 1F',
                'lat' => '',
                'long' => '',
                'tel' => '',
            ],
            [
                'organizer_id' => 24,
                'name' => 'せいせきアウラホール',
                'kana_name' => 'せいせきあうらほーる',
                'zipcode' => '206-0011',
                'addr_prefecture' => '東京都',
                'addr_city' => '多摩市',
                'addr_block' => '関戸1',
                'addr_building' => 'せいせきアウラホール',
                'lat' => '35.650826437261415',
                'long' => '139.44753330620847',
                'tel' => '042-337-2000',
            ],
            [
                'organizer_id' => 24,
                'name' => '品川水族館',
                'kana_name' => 'しながわすいぞくかん',
                'zipcode' => '140-0012',
                'addr_prefecture' => '東京都',
                'addr_city' => '品川区',
                'addr_block' => '勝島3-2-1',
                'addr_building' => '',
                'lat' => '35.589976665397',
                'long' => '139.7390030369121',
                'tel' => '03-3762-3433',
            ],
            [
                'organizer_id' => 24,
                'name' => '東京タワー',
                'kana_name' => 'とうきょうたわー',
                'zipcode' => '105-0011',
                'addr_prefecture' => '東京都',
                'addr_city' => '港区',
                'addr_block' => '芝公園4-2-8',
                'addr_building' => '',
                'lat' => '35.66021982325846',
                'long' => '139.7483083278031',
                'tel' => '03-3433-5111',
            ],
            [
                'organizer_id' => 24,
                'name' => '小田急百貨店本館',
                'kana_name' => 'おだきゅうひゃっかてんほんかん',
                'zipcode' => '160-8001',
                'addr_prefecture' => '東京都',
                'addr_city' => '新宿区',
                'addr_block' => '西新宿1-1-3',
                'addr_building' => '',
                'lat' => '35.690726384250354',
                'long' => '139.69962457737452',
                'tel' => '03-3342-1111',
            ],
            [
                'organizer_id' => 24,
                'name' => 'ホワイティ島之内',
                'kana_name' => 'ほわいてぃしまのうち',
                'zipcode' => '542-0082',
                'addr_prefecture' => '大阪府',
                'addr_city' => '大阪市中央区',
                'addr_block' => '島之内1-4-32',
                'addr_building' => 'ホワイティ島之内 6F',
                'lat' => '34.673556002632196',
                'long' => '135.50996185220305',
                'tel' => '',
            ],
            [
                'organizer_id' => 24,
                'name' => 'THE WHITE OISE',
                'kana_name' => 'ほわいと おいす',
                'zipcode' => '453-0016',
                'addr_prefecture' => '愛知県',
                'addr_city' => '名古屋市中村区',
                'addr_block' => '竹橋町5-12',
                'addr_building' => 'THE WHITE OISE 403号室',
                'lat' => '35.167887075321914',
                'long' => '136.8785127712479',
                'tel' => '',
            ],
            [
                'organizer_id' => 24,
                'name' => 'パセラリゾート',
                'kana_name' => 'ぱせらりぞーと',
                'zipcode' => '160-0021',
                'addr_prefecture' => '東京都',
                'addr_city' => '新宿区',
                'addr_block' => '歌舞伎町1-3-16',
                'addr_building' => 'パセラリゾーツビル 7F ガムランボール',
                'lat' => '35.69463150285003',
                'long' => '139.70386706203436',
                'tel' => '',
            ],
            [
                'organizer_id' => 24,
                'name' => 'フリーメゾン',
                'kana_name' => 'ふりーめぞん',
                'zipcode' => '160-0022',
                'addr_prefecture' => '東京都',
                'addr_city' => '新宿区',
                'addr_block' => '新宿2-13-16',
                'addr_building' => '',
                'lat' => '35.690142275017344',
                'long' => '139.70872036018855',
                'tel' => '03-5357-7033',
            ],
            [
                'organizer_id' => 24,
                'name' => '葛飾柴又寅さん記念館',
                'kana_name' => 'かつしかしばまたとらさんきねんかん',
                'zipcode' => '125-0052',
                'addr_prefecture' => '東京都',
                'addr_city' => '葛飾区',
                'addr_block' => '柴又6-22-19',
                'addr_building' => '',
                'lat' => '35.757441646110316',
                'long' => '139.8808355270886',
                'tel' => '03-3657-3455',
            ],
            [
                'organizer_id' => 24,
                'name' => 'ニジゲンノモリ',
                'kana_name' => 'にじげんのもり',
                'zipcode' => '656-2301',
                'addr_prefecture' => '兵庫県',
                'addr_city' => '淡路市',
                'addr_block' => '楠本2425-2',
                'addr_building' => '',
                'lat' => '34.574708937807365',
                'long' => '135.00124500790614',
                'tel' => '0799-64-7061',
            ],
            [
                'organizer_id' => 24,
                'name' => '広島空港',
                'kana_name' => 'ひろしまくうこう',
                'zipcode' => '729-0416',
                'addr_prefecture' => '広島県',
                'addr_city' => '三原市本郷町',
                'addr_block' => '善入寺64-31',
                'addr_building' => '',
                'lat' => '34.437300504782705',
                'long' => '132.9207138926811',
                'tel' => '0848-86-8151',
            ],
            [
                'organizer_id' => 24,
                'name' => 'リナシティかのや',
                'kana_name' => 'りなしてぃかのや',
                'zipcode' => '893-0009',
                'addr_prefecture' => '鹿児島県',
                'addr_city' => '鹿屋市',
                'addr_block' => '大手町1-1',
                'addr_building' => '',
                'lat' => '31.388835469719815',
                'long' => '130.85088282697512',
                'tel' => '0994-35-1001',
            ],
            [
                'organizer_id' => 24,
                'name' => '大阪城公園',
                'kana_name' => 'おおさかじょうこうえん',
                'zipcode' => '540-0002',
                'addr_prefecture' => '大阪府',
                'addr_city' => '大阪市中央区',
                'addr_block' => '大阪城1',
                'addr_building' => '',
                'lat' => '34.68745944948457',
                'long' => '135.52599971299932',
                'tel' => '06-6755-4146',
            ],
            [
                'organizer_id' => 24,
                'name' => 'その他',
                'kana_name' => 'そのた',
                'zipcode' => '',
                'addr_prefecture' => '',
                'addr_city' => '',
                'addr_block' => '',
                'addr_building' => '',
                'lat' => '',
                'long' => '',
                'tel' => '',
            ],
        ]);
    }
}
