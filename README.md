## weather
基于 [高德开放平台](https://lbs.amap.com/dev/id/newuser) 的 PHP 天气信息组件。

[![Build Status](https://travis-ci.org/sssword/weather.svg?branch=master)](https://travis-ci.org/sssword/weather)

## 安装Installing

```shell
$ composer require sssword/weather -vvv
```

## 配置

在使用本扩展之前，你需要去 [高德开放平台](https://lbs.amap.com/dev/id/newuser) 注册账号，然后创建应用，获取应用的 API Key。

## 使用Usage

```php
use Sssword\Weather\Weather;

$key = '高德开放平台APP Key';

$weather = new Weather($key);
```

## 获取实时天气

```php
$response = $weather->getWeather('230100');
```

示例：
```json
{
    "status": "1",
    "count": "1",
    "info": "OK",
    "infocode": "10000",
    "lives": [
        {
            "province": "黑龙江",
            "city": "哈尔滨市",
            "adcode": "230100",
            "weather": "多云",
            "temperature": "-6",
            "winddirection": "西",
            "windpower": "≤3",
            "humidity": "53",
            "reporttime": "2019-01-22 17:12:22"
        }
    ]
}

```


## 获取预报天气

```php
$response = $weather->getWeather('230100', 'all');
```

示例：
```json
{
    "status": "1",
    "count": "1",
    "info": "OK",
    "infocode": "10000",
    "forecasts": [
        {
            "city": "哈尔滨市",
            "adcode": "230100",
            "province": "黑龙江",
            "reporttime": "2019-01-22 17:12:22",
            "casts": [
                {
                    "date": "2019-01-22",
                    "week": "2",
                    "dayweather": "多云",
                    "nightweather": "多云",
                    "daytemp": "-3",
                    "nighttemp": "-17",
                    "daywind": "西",
                    "nightwind": "西",
                    "daypower": "4",
                    "nightpower": "4"
                },
                {
                    "date": "2019-01-23",
                    "week": "3",
                    "dayweather": "晴",
                    "nightweather": "晴",
                    "daytemp": "-8",
                    "nighttemp": "-20",
                    "daywind": "西北",
                    "nightwind": "西北",
                    "daypower": "4",
                    "nightpower": "4"
                },
                {
                    "date": "2019-01-24",
                    "week": "4",
                    "dayweather": "多云",
                    "nightweather": "多云",
                    "daytemp": "-7",
                    "nighttemp": "-18",
                    "daywind": "西北",
                    "nightwind": "西北",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2019-01-25",
                    "week": "5",
                    "dayweather": "阵雪",
                    "nightweather": "多云",
                    "daytemp": "-9",
                    "nighttemp": "-19",
                    "daywind": "西北",
                    "nightwind": "西北",
                    "daypower": "4",
                    "nightpower": "4"
                }
            ]
        }
    ]
}

```


## 参数说明
```php
array | string  getWeather(string $city, string $type = 'base', string $format = 'json')
```
* $city     -城市名，e.g. "哈尔滨";
* $type     -返回内容类型，*`base`*: 返回实况天气，*`all`*: 返回预报天气;
* $format   -输出数据格式，*`json`*: JSON格式，*`xml`*: XML格式;


## 参考

* [高德开放平台天气接口](https://lbs.amap.com/api/webservice/guide/api/weatherinfo/)


## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/sssword/weather/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/sssword/weather/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT