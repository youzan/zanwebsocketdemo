<?php

namespace Com\Youzan\ZanWebSocketDemo\Model\Index;

use Zan\Framework\Store\Facade\Cache;

class GetCacheData {
    public function doCacheCmd()
    {
        yield Cache::set("pf.test.test", ["a", "b"], 1);
        //demo.demo_sql_id1_1对应resource/sql/demo.php中的配置
        yield Cache::get("pf.test.test", ["a", "b"]);
    }
}