<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\Doctrine\Types\Tests;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;
use Sonata\Doctrine\Types\JsonType;

/**
 * NEXT_MAJOR: Remove this test.
 *
 * @group legacy
 */
class JsonTypeTest extends TestCase
{
    protected function setUp(): void
    {
        if (Type::hasType('json')) {
            Type::overrideType('json', JsonType::class);
        } else {
            Type::addType('json', JsonType::class);
        }
    }

    public function testConvertToDatabaseValue(): void
    {
        $platform = new MockPlatform();

        static::assertSame(
            '{"foo":"bar"}',
            Type::getType('json')->convertToDatabaseValue(['foo' => 'bar'], $platform)
        );
    }

    public function testConvertToPHPValue(): void
    {
        $platform = new MockPlatform();

        static::assertSame(
            ['foo' => 'bar'],
            Type::getType('json')->convertToPHPValue('{"foo":"bar"}', $platform)
        );
    }
}

class MockPlatform extends AbstractPlatform
{
    /**
     * Gets the SQL Snippet used to declare a BLOB column type.
     */
    public function getBlobTypeDeclarationSQL(array $column)
    {
        throw Exception::notSupported(__METHOD__);
    }

    public function getBooleanTypeDeclarationSQL(array $column)
    {
        return '';
    }

    public function getIntegerTypeDeclarationSQL(array $column)
    {
        return '';
    }

    public function getBigIntTypeDeclarationSQL(array $column)
    {
        return '';
    }

    public function getSmallIntTypeDeclarationSQL(array $column)
    {
        return '';
    }

    public function _getCommonIntegerTypeDeclarationSQL(array $column)
    {
        return '';
    }

    public function getVarcharTypeDeclarationSQL(array $column)
    {
        return 'DUMMYVARCHAR()';
    }

    public function getCurrentDatabaseExpression(): string
    {
        return '';
    }

    /** @override */
    public function getClobTypeDeclarationSQL(array $column)
    {
        return 'DUMMYCLOB';
    }

    public function getVarcharDefaultLength()
    {
        return 255;
    }

    public function getName()
    {
        return 'mock';
    }

    protected function initializeDoctrineTypeMappings()
    {
    }

    protected function getVarcharTypeDeclarationSQLSnippet($length, $fixed)
    {
        return '';
    }
}
