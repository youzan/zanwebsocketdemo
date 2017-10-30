# ZanWebSocketDemo
zan php websocket server demo

##如何使用

1. 安装 [*zan扩展*](https://github.com/youzan/zan)
2. 安装[composer](https://getcomposer.org/)
3. 在根目录下执行composer update
4. 配置php.ini
```ini
zanphp.RUN_MODE = test
zanphp.DEBUG = true
```
5. 启动http server
`php bin/websocket`
6. 浏览器打开bin/test.html

##zan框架websocket前后端协议规范
###请求格式
```
{
	"path": "/module/controller/action",
	"data": "xxx"
}
```

- path: url中的path字段,用于请求路由，websocket可以复用HTTP的路由、filter等功能
- data: 请求数据

###响应格式
```
{
	"code": 0,
	"data": "xxx"
}
```

- code: 响应码，0表示success，其他值表示错误码
- data: code为0时代表响应，其他值时表示错误信息

7.测试

```php
启动server: 
    php bin/websocket
启动client:
    cd test
    phpunit --bootstrap bootstrap.php WebSocketTest
```

8.controller编写
参照示例中的controller实现即可。