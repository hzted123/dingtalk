<?php
/**
 * Created by PhpStorm.
 * User: songming
 * Date: 17/8/7
 * Time: 上午11:09
 */

namespace hzted123\dingtalk;

use Yii;
use GuzzleHttp\Psr7\Request;

class DingDingAPI
{
    const TOKEN_CACHE = 'dingtalk_access_token_';
    const BASE_URL = "https://oapi.dingtalk.com/";
    public $corp_id = '';
    public $corp_secret = '';
    public $access_token;
    public $debug = false;
    public $proxy = false; //代理 proxy.lcbcorp.com:8080

    public function http_get($route, $params = [], $need_access_token = true){
        if ($need_access_token) {
            $params['access_token'] = $this->checkAccessToken();
        }

        if (empty($params)){
            $url = self::BASE_URL.$route;
        } else {
            $url = self::BASE_URL.$route.'?'.http_build_query($params);
        }

        $config = [
            'timeout'         => 10,
            'connect_timeout' => 10,
            'on_stats' => function (\GuzzleHttp\TransferStats $stats) use ($route) {
                Yii::info($stats->getHandlerStats(), __METHOD__.'.'.$route);
            },
        ];
        if (isset(\Yii::$app->params['http_proxy'])){
            $config['proxy'] = \Yii::$app->params['http_proxy'];
        }
        $client = new \GuzzleHttp\Client();
        $request = new Request('GET', $url);
        $response = $client->send($request, $config);
        $result = $this->getResult($route, $request, $response);
        return $result;
    }

    public function http_post($route, $data, $params = [], $need_access_token = true){
        if ($need_access_token) {
            $params['access_token'] = $this->checkAccessToken();
        }

        if (empty($params)){
            $url = self::BASE_URL.$route;
        } else {
            $url = self::BASE_URL.$route.'?'.http_build_query($params);
        }

        $config = [
            'timeout'         => 10,
            'connect_timeout' => 10,
            'on_stats' => function (\GuzzleHttp\TransferStats $stats) use ($route) {
                Yii::info($stats->getHandlerStats(), __METHOD__.'.'.$route);
            },
        ];
        if (isset(\Yii::$app->params['http_proxy'])){
            $config['proxy'] = \Yii::$app->params['http_proxy'];
        }

        $client = new \GuzzleHttp\Client();
        $request = new Request('POST', $url, [], json_encode($data));
        //        $request = $client->createRequest('POST', $url, [
        //            'json' => $data,
        //        ]);

        $response = $client->send($request, $config);
        $result = $this->getResult($route, $request, $response);
        return $result;
    }

    public function http_post_file($route, $data, $file, $params = [], $need_access_token = true){
        if ($need_access_token) {
            $params['access_token'] = $this->checkAccessToken();
        }

        if (empty($params)){
            $url = self::BASE_URL.$route;
        } else {
            $url = self::BASE_URL.$route.'?'.http_build_query($params);
        }

        $config = [
            'timeout'         => 10,
            'connect_timeout' => 10,
            'on_stats' => function (\GuzzleHttp\TransferStats $stats) use ($route) {
                Yii::info($stats->getHandlerStats(), __METHOD__.'.'.$route);
            },
        ];
        if (isset(\Yii::$app->params['http_proxy'])){
            $config['proxy'] = \Yii::$app->params['http_proxy'];
        }

        $client = new \GuzzleHttp\Client();
        $client->post(['multipart' => [
            [
                'name'     => 'baz',
                'contents' => fopen('/path/to/file', 'r')
            ]
        ]]);
//        $request = new Request('POST', $url, [], json_encode($data));

                $request = $client->createRequest('POST', $url, [
                    'json' => $data,
                ]);
        $post_body = $request->getBody();
        $post_body->attach($file);
        $response = $client->send($request, $config);
        $result = $this->getResult($route, $request, $response);
        return $result;
    }

    /**
     * @param       string $route
     * @param       \Psr\Http\Message\ResponseInterface $route
     * @param       \Psr\Http\Message\ResponseInterface $response
     * @param array $data
     * @param string $method
     * @return array|mixed
     */
    private function getResult($route, $request, $response){
        $status_code = $response->getStatusCode();
        $content = $response->getBody()->getContents();

        $msg_info = "request: ". \GuzzleHttp\Psr7\str($request);
        $msg_info .= "response: ". \GuzzleHttp\Psr7\str($response);

        //日志可能超长,只记录固定固定长度的日志
        $msg_info = mb_substr($msg_info, 0, 6000, 'utf-8');

        if ($status_code !== 200) {
            Yii::warning($msg_info, __METHOD__.'.'.$route);
            throw new \Exception('状态码非200', 500);
            //            return ['status' => false, 'reason' => '状态码非200'];
        }

        $result = json_decode($content, true);

        if (!isset($result['errcode'])) {
            Yii::warning($msg_info, __METHOD__.'.'.$route );
            throw new \Exception('接口返回格式异常, 无 errcode', 500);
            //            return ['status' => false, 'reason' => '接口返回格式异常, 无 errcode'];
        }

        if ($result['errcode'] == 40091) { //用户授权码创建失败,需要用户重新授权
            Yii::warning($result['errmsg']."\n".$msg_info, __METHOD__.'.'.$route);
            //清空access_token缓存
            $this->clearAccessToken();
            throw new \Exception($result['errmsg'], 500);
            //            return ['status' => false, 'reason' => $result['errmsg']];
        }

        if ($result['errcode'] != 0) {
            Yii::warning($result['errmsg']."\n".$msg_info, __METHOD__.'.'.$route);
            throw new \Exception($result['errmsg'], 500);
            //            return ['status' => false, 'reason' => $result['errmsg']];
        }

        Yii::info($msg_info, __METHOD__.'.'.$route);
        return $result;
        //        return ['status' => true, 'value' => $result];
    }

    public function checkAccessToken(){
        if ($this->access_token === null) {
            $this->access_token = Yii::$app->cache->get(self::TOKEN_CACHE.$this->corp_secret);
        }

        if ($this->access_token) {
            return $this->access_token;
        }

        $route = 'gettoken';
        $params = [
            'corpid' => $this->corp_id,
            'corpsecret' => $this->corp_secret,
        ];
        $result = $this->http_get($route, $params , false);
        $this->access_token = $result['access_token'];
        if (!isset($result['expires_in']) || empty($result['expires_in'])) {
            $result['expires_in'] = 7200;
        }
        Yii::$app->cache->set(self::TOKEN_CACHE.$this->corp_secret, $result['access_token'], $result['expires_in']);
        $this->access_token = $result['access_token'];
        return $this->access_token;
    }

    public function clearAccessToken(){
        $this->access_token = null;
        Yii::$app->cache->delete(self::TOKEN_CACHE.$this->corp_secret);
    }


}
