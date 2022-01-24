<?php

namespace App\TransactionsBoundedContext\Application;

use App\TransactionsBoundedContext\Application\Services\RepositoryFactory;

class GetAllTransactions
{
    private RepositoryFactory $factory;

    public function __construct(RepositoryFactory $factory)
    {
        $this->factory = $factory;
    }

    public function __invoke(GetAllTransactionsRequest $request): GetAllTransactionsResponse
    {
        $repository = $this->factory->create($request->getSource());
        $data = $repository->findAll();
        $response = new GetAllTransactionsResponse($request->getSource());
        foreach ($data as $d) {
            $response->add($d);
        }

        return $response;
    }
}
