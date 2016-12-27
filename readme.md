# union-middlware

laravel开发 常用中间件

### 使用示例

配置:

config/union.php

不对 test/mid进行校验的配置
````
<?php
return [
    'mid'=>[
        'excepturl'=>[
            'test/mid'
        ],
        'signsecret'=>[
            'android'=>'11111111111111111111',
            'ios'=>'2222222222222222222'
        ]
    ]
];

````

Kernel.php
匹配签名校验
```

<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
       \Union\Mid\CheckSignMiddleware::class
    ];
    protected $routeMiddleware = [
    ];
}

```

签名验证规则:
从header中取