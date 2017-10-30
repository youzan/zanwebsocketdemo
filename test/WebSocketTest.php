<?php

namespace Com\Youzan\ZanWebSocketDemo\Test;

class WebSocketTest extends \PHPUnit_Framework_TestCase
{
    private $data = "Hello WebSocket";

    public function testRequest()
    {
        $client = new WebSocketClient();

        $client->on("open",function ($client) {
            $fd = $client->getTcpClient()->sock;
            echo "fd: $fd is open\n";
            $msg = [
                "path" => "/index/index/index",
                "data" => $this->data
            ];
            $client->send(json_encode($msg));

        });

        $client->on("message", function ($client, $frame) {
            $this->assertEquals($frame->data, json_encode([
                "code" => 0,
                "data" => $this->data
            ]));
            $client->getTcpClient()->close();
        });

        $client->on("close", function ($client) {
            $fd = $client->getTcpClient()->sock;
            echo "fd: $fd is closed\n";
            swoole_event_exit();
        });

        $client->connect("127.0.0.1", 8030);
    }
}
