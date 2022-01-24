<?php

namespace App\TransactionsBoundedContext\Application;

use App\TransactionsBoundedContext\Domain\TransactionRepository;

class GetAllTransactions
{
    private TransactionRepository $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetAllTransactionsRequest $request): GetAllTransactionsResponse
    {
        $data = $this->repository->findAll();
        $response = new GetAllTransactionsResponse($request->getSource());
        foreach ($data as $d) {
            $response->add($d);
        }

        return $response;
    }
}
