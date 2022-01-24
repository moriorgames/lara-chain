<?php

namespace Tests\Unit\TransactionsBoundedContext\Application\Services;

use App\TransactionsBoundedContext\Application\Services\RepositoryFactory;
use App\TransactionsBoundedContext\Domain\RepositoryType;
use App\TransactionsBoundedContext\Domain\SourceNotValidException;
use App\TransactionsBoundedContext\Infrastructure\CsvTransactionRepository;
use App\TransactionsBoundedContext\Infrastructure\MysqlTransactionRepository;
use PHPUnit\Framework\TestCase;

class RepositoryFactoryTest extends TestCase
{
    private RepositoryFactory $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new RepositoryFactory();
    }

    public function test_throws_an_exception_when_not_a_valid_source()
    {
        $this->expectException(SourceNotValidException::class);

        $source = 'html';
        $result = $this->sut->create($source);

        $this->assertInstanceOf(CsvTransactionRepository::class, $result);
    }

    public function test_is_able_to_create_a_database_repository()
    {
        $source = RepositoryType::DATABASE;
        $result = $this->sut->create($source);

        $this->assertInstanceOf(MysqlTransactionRepository::class, $result);
    }

    public function test_is_able_to_create_a_csv_repository()
    {
        $source = RepositoryType::CSV;
        $result = $this->sut->create($source);

        $this->assertInstanceOf(CsvTransactionRepository::class, $result);
    }
}
