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

                case 'あ':
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            'text' => sprintf('あ', $text), 
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);
                break;

                case 'い':
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            'text' => sprintf('い', $text), 
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);
                break;

                case 'う':
                    $path = sprintf('me/messages?access_token=%s', getenv('FACEBOOK_PAGE_ACCESS_TOKEN'));
                    $json = [
                        'recipient' => [
                            'id' => $from, 
                        ],
                        'message' => [
                            //header('Content-Type: image/jpg'),
                            'text' => imagejpeg('images/13090170_904137979695719_768070574_n.jpg'), 
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
                            'text' => sprintf('%s、ちゃうねん！', $text), 
                        ],
                    ];
                    $client->request('POST', $path, ['json' => $json]);

            }
        }

    }

    return 0;
});

$app->run();
