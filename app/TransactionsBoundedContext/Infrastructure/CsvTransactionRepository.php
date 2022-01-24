<?php

namespace App\TransactionsBoundedContext\Infrastructure;

use App\TransactionsBoundedContext\Domain\TransactionRepository;

class CsvTransactionRepository implements TransactionRepository
{
    public function findAll(): array
    {
        $output = [];
        $row = 1;
        if (($handle = fopen("app/TransactionsBoundedContext/Infrastructure/transactions.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                $row++;
                for ($c = 0; $c < $num; $c++) {
                    $output[$row][] = $data[$c];
                }
            }
            fclose($handle);
        }

        return $output;
    }
}
