<?php

namespace App\Http\Controllers;

use App\TransactionsBoundedContext\Application\GetAllTransactions;
use App\TransactionsBoundedContext\Application\GetAllTransactionsRequest;
use App\TransactionsBoundedContext\Application\Services\RepositoryFactory;
use Illuminate\Routing\Controller as BaseController;

class TransactionController extends BaseController
{
    public function getJSON($source)
    {
        $useCase = new GetAllTransactions(new RepositoryFactory());

        $request = new GetAllTransactionsRequest($source);
        $response = $useCase->__invoke($request);

        return $response->getJson();
    }
}