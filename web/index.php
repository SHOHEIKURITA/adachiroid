<?php

require('../vendor/autoload.php');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;

$app = new Silex\Application();

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => 'php://stderr',
));

$app->before(function (Request $request) use($bot) {
    // TODO validation
});

$app->get('/callback', function (Request $request) use ($app) {
    $response = "";
    if ($request->query->get('hub_verify_token') === getenv('FACEBOOK_PAGE_VERIFY_TOKEN')) {
        $response = $request->query->get('hub_challenge');
    }

    return $response;
});

$app->post('/callback', function (Request $request) use ($app) {
    // Let's hack from here!
    $body = json_decode($request->getContent(), true);
    $client = new Client(['base_uri' => 'https://graph.facebook.com/v2.6/']);

    foreach ($body['entry'] as $obj) {
        $app['monolog']->addInfo(sprintf('obj: %s', json_encode($obj)));

        foreach ($obj['messaging'] as $m) {
            $app['monolog']->addInfo(sprintf('messaging: %s', json_encode($m)));
            $from = $m['sender']['id'];
            $text = $m['message']['text'];

            switch ($text) {

                case 'こんにちは':case 'こんにちわ':case 'はろー':case 'ハロー':
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            'text' => sprintf('よほほー', $text), 
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);
                break;

                case '元気？':case '調子どう？':
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            'text' => sprintf('鼻がズビズビ', $text), 
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);
                break;

                case '大丈夫？':
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            'text' => sprintf('腰を痛めて早数ヶ月', $text), 
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);
                break;

                case 'ごめん':case 'ごめんね':case 'ごめんなさい':case 'すみません':
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            'text' => sprintf('慰謝料としてステーキを要求する', $text), 
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);
                break;

                case 'あそぼ':case '遊ぼう':case 'あそぼう':case 'どっかいこ':case 'どっか行こう':
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            'text' => sprintf('銭湯行って参ります', $text), 
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);
                break;

                case 'ごはんいこ':case 'ご飯行こう':case 'ランチいこ':case 'ランチ行こう':case 'ランチどう？':
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            'text' => sprintf('お昼ごはんはお土産にもらったいかめしです', $text), 
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);
                break;

                case '何それ？':case '何？':
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            'text' => sprintf('松ぼっくりを拾いました', $text), 
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);
                break;

                case 'がんばったね':case '頑張ったね':case 'がんばった':case '頑張った':case 'おめでとう':
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            'text' => sprintf('それにしてもお腹が減りました', $text), 
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);
                break;

                case '学長ってどんな人？':
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            'text' => sprintf('髪の分け目変えなきゃハゲるよ', $text), 
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);
                break;

                case '笹野さんってどんな人？':
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            'text' => sprintf('お兄ちゃんみないなひと', $text), 
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);
                break;

                case '塩谷先生ってどんな人？':
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            'text' => sprintf('目力強いから気をつけて', $text), 
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);
                break;

                case '和田さんってどんな人？':
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            'text' => sprintf('お姉ちゃんみたいなひと', $text), 
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);
                break;

                case 'じゃあね':case 'ばいばい':case 'バイバイ':case 'さよなら':case 'さようなら':
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            'text' => sprintf('みなさま良い1日を', $text), 
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);
                break;

                case 'ひま？':case '暇？':case '何してる？':case '何してるの？':
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            'attachment' => [
                                  'type' => 'image',
                                  'payload' => [
                                      'url' => 'https://adachiroid.herokuapp.com/images/01.jpg',
                                  ],
                              ],
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);
                break;

                case 'ありがとう':case 'ありがと':case '感謝':case 'サンキュー':case 'サンキュ':
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            'attachment' => [
                                  'type' => 'image',
                                  'payload' => [
                                      'url' => 'https://adachiroid.herokuapp.com/images/13082079_904138323029018_928492546_n.jpg',
                                  ],
                              ],
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);
                break;

                case 'かわいいね':case 'かわいい':case 'カワイイ':case '可愛い':case 'すきだよ':case '好きだよ':
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            'attachment' => [
                                  'type' => 'image',
                                  'payload' => [
                                      'url' => 'https://adachiroid.herokuapp.com/images/13125193_907149892727861_1078452890_n.gif',
                                  ],
                              ],
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);
                break;

                default:
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            'text' => sprintf('うひー', $text), 
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);

            }
        }

    }

    return 0;
});

$app->run();
