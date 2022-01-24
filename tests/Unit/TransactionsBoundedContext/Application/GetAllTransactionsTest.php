<?php

namespace Tests\Unit\TransactionsBoundedContext\Application;

use App\TransactionsBoundedContext\Application\GetAllTransactions;
use App\TransactionsBoundedContext\Application\GetAllTransactionsRequest;
use App\TransactionsBoundedContext\Domain\TransactionRepository;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophecy\ObjectProphecy;

class GetAllTransactionsTest extends TestCase
{
    use ProphecyTrait;

    private TransactionRepository|ObjectProphecy $repository;
    private GetAllTransactions $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->prophesize(TransactionRepository::class);
        $this->sut = new GetAllTransactions($this->repository->reveal());
    }

    public function test_is_able_to_return_a_json_with_transactions_data()
    {
        $returnedArray = [
            [
                'id' => 1,
                'code' => 'T_218_ljydmgebx',
                'amount' => '8617.19',
                'user_id' => 375,
                'created_at' => '2020-01-19 16:08:59',
                'updated_at' => '2020-01-19 16:08:59'
            ],
            [
                'id' => 2,
                'code' => 'T_335_wmhrbjxld',
                'amount' => '6502.72',
                'user_id' => 1847,
                'created_at' => '2020-01-19 16:08:59',
                'updated_at' => '2020-01-19 16:08:59'
            ]
        ];
        /** @var MethodProphecy $repositoryExpectation */
        $repositoryExpectation = $this->repository->findAll()
            ->willReturn($returnedArray);
        $source = 'db';
        $request = new GetAllTransactionsRequest($source);

        $result = $this->sut->__invoke($request);

        $expected = [
            'source' => $source,
            [
                'id' => 1,
                'code' => 'T_218_ljydmgebx',
                'amount' => '8617.19',
                'user_id' => 375,
                'created_at' => '2020-01-19 16:08:59',
                'updated_at' => '2020-01-19 16:08:59'
            ],
            [
                'id' => 2,
                'code' => 'T_335_wmhrbjxld',
                'amount' => '6502.72',
                'user_id' => 1847,
                'created_at' => '2020-01-19 16:08:59',
                'updated_at' => '2020-01-19 16:08:59'
            ]
        ];

        $repositoryExpectation->shouldBeCalledOnce();
        $this->assertEquals(json_encode($expected), $result->getJson());
    }
}
