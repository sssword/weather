<?php

namespace Sssword\Weather\Tests;

use Sssword\Weather\Weather;
use PHPUnit\Framework\TestCase;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Mockery\Matcher\AnyArgs;
use Sssword\Weather\Exceptions\HttpException;
use Sssword\Weather\Exceptions\InvalidArgumentException;

/**
 * 测试
 */
class WeatherTest extends TestCase
{

    // 异常测试，检查$type 参数
    public function testGetWeatherWithInvalidType()
    {
        $w = new Weather('mock-key');
        // 断言会抛出异常
        $this->expectException(InvalidArgumentException::class);
        // 断言消息
        $this->expectExceptionMessage('Invalid type value(base/all): foo');
        // 传入 array 会抛出异常
        $w->getWeather('哈尔滨', 'foo');
        // 如果没有抛出异常，就会运行到这行，标记当前测试失败！
        $this->fail('断言 $type 参数异常失败！');
    }

    // 异常测试，检查$format 参数
    public function testGetWeatherWithInvalidFormat()
    {
        $w = new Weather('mock-key');
        $this->expectException(InvalidArgumentException::class);

        $this->expectExceptionMessage('Invalid response format: array');

        $w->getWeather('哈尔滨', 'base', 'array');

        $this->fail('断言 $format 参数异常失败！');
    }

    // 请求异常测试
    public function testGetWeatherWithGuzzleRuntimeException()
    {
        $client = \Mockery::mock(Client::class);
        $client->allows()
            ->get(new AnyArgs())
            ->andThrow(new \Exception('request timeout'));
        $w = \Mockery::mock(Weather::class, ['mock-key'])->makePartial();
        $w->allows()->getHttpClient()->andReturn($client);

        // 断言
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('request timeout');

        $w->getWeather('哈尔滨');
    }

    public function testGetWeather()
    {
        // 创建模拟接口响应
        $response = new Response(200, [], '{"success": true}');
        // 创建模拟HTTP Client
        $client = \Mockery::mock(Client::class);
        // 指定将会产生的行为（在后续的测试中将会按照下面的参数来调用）。
        $client->allows()->get('https://restapi.amap.com/v3/weather/weatherInfo',[
            'query' => [
                'key' => 'mock-key',
                'city'  => '哈尔滨',
                'output'    =>  'json',
                'extensions'=>  'base',
            ],
        ])->andReturn($response);

        // 将 `getHttpClient` 方法替换为上面创建的 http client
        $w = \Mockery::mock(Weather::class, ['mock-key'])->makePartial();
        $w->allows()->getHttpClient()->andReturn($client);

        // 断言 `getWeather` 方法返回值为模拟接口的返回值
        $this->assertSame(['success' => true], $w->getWeather('哈尔滨'));

        // xml
        $response = new Response(200, [], '<hello>content</hello>');
        $client = \Mockery::mock(Client::class);
        $client->allows()->get('https://restapi.amap.com/v3/weather/weatherInfo',[
            'query' => [
                'key' => 'mock-key',
                'city'  => '哈尔滨',
                'output'    =>  'xml',
                'extensions'=>  'all',
            ],
        ])->andReturn($response);

        $w = \Mockery::mock(Weather::class, ['mock-key'])->makePartial();
        $w->allows()->getHttpClient()->andReturn($client);

        $this->assertSame('<hello>content</hello>', $w->getWeather('哈尔滨', 'all', 'xml'));
    }

    public function testGetHttpClient()
    {
        $w = new Weather('mock-key');
        // 断言返回结果为 GuzzleHttp\ClientInterface 实例
        $this->assertInstanceOf(ClientInterface::class, $w->getHttpClient());

    }

    public function testSetGuzzleOptions()
    {
        $w = new Weather('mock-key');
        // 设置参数前，timeout 为 null
        $this->assertNull($w->getHttpClient()->getConfig('timeout'));
        $w->SetGuzzleOptions(['timeout' => 5000]);
        $this->assertSame(5000, $w->getHttpClient()->getConfig('timeout'));
    }
}


 ?>