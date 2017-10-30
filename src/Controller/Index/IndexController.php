<?php

namespace Com\Youzan\ZanWebSocketDemo\Controller\Index;

use Com\Youzan\ZanWebSocketDemo\Demo\Service\HttpCall;
use Com\Youzan\ZanWebSocketDemo\Demo\Service\TcpCall;
use Com\Youzan\ZanWebSocketDemo\Model\Index\GetCacheData;
use Zan\Framework\Foundation\Domain\WebSocketController as Controller;
use Com\Youzan\ZanWebSocketDemo\Model\Index\GetDBData;

class IndexController extends Controller {

    //字符串输出示例
    public function index()
    {
        $msg = $this->request->getData();
        yield $this->output($msg);
    }

    public function error()
    {
        yield $this->send(503, "error response");
    }

    //操作数据库示例
    public function dbOperation()
    {
        $demo = new GetDBData();
        //执行sql语句
        $result = (yield $demo->doSql());
        $result = json_encode($result);
        yield $this->output($result);
    }

    public function redisOperation()
    {
        $demo = new GetCacheData();

        //执行Redis命令
        $result = (yield $demo->doCacheCmd());
        $result = json_encode($result);
        yield $this->output($result);
    }

    public function sendToFd()
    {
        $fd = $this->request->getFd();
        yield $this->sendRaw($fd, 0, "send to fd msg");
    }

    //Http服务调用示例
    public function httpRemoteService()
    {
        $http = new HttpCall();
        $resp = (yield $http->visit());

        $resp = new Response($resp->getBody());
        $resp->withHeaders(['Content-Type' => 'text/javascript;charset=utf-8']);

        yield $resp;
    }

    // 调用 远程NOVA 服务
    public function novaRemoteService()
    {
        try {
            $tcp = new NovaCall();
            $result = (yield $tcp->invokeRemoteNovaMethod());
            yield $this->r(0, 'json string', $result);
        } catch (\Exception $e) {
            $msg = get_class($e) . ":" . $e->getMessage();
            sys_error($msg);
            yield $this->r(0, $msg, null);
        }
    }
}