<?php

declare(strict_types=1);

namespace BenTools\MercurePHP\Tests\Unit\Hub\Transport;

use BenTools\MercurePHP\Hub\Transport\PHP\PHPTransport;
use BenTools\MercurePHP\Hub\Transport\Redis\RedisTransport;
use BenTools\MercurePHP\Hub\Transport\TransportFactory;
use InvalidArgumentException;

it('picks the appropriate factory', function (string $dsn, string $transportClass) {
    $factory = new TransportFactory();
    expect($factory->create($dsn))->toBeInstanceOf($transportClass);
})->with(function () {
    yield ['php://default?size=1000', PHPTransport::class];
    yield ['redis://localhost?size=1000', RedisTransport::class];
});

it('yells when DSN is not matched by a subsequent factory', function () {
    (new TransportFactory())->create('foo://bar');
})->throws(InvalidArgumentException::class);
