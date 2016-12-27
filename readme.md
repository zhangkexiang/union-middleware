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
//            'test/mid'
        ],
        'sign'=>[
            'secret'=>[
                'android'=>[
                    'first'=>'11111111111111111111',
                    'second'=>'22222222222222222222'
                ],
                'ios'=>[
                    'first'=>'33333333333333333333',
                    'second'=>'44444444444444444444'
                ]
            ],
            'headers'=>[
                'uid'
            ]
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