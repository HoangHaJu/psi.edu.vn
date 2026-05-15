<?php

namespace App\Admin\Repositories\Transaction;

use App\Admin\Repositories\EloquentRepository;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Models\Transaction;

class TransactionRepository extends EloquentRepository implements TransactionRepositoryInterface
{

    protected $select = [];

    public function getModel()
    {
        return Transaction::class;
    }
    public function getAllByStudentId($studentId)
    {
        return $this->model->where('id', $studentId)->value('user_id');
    }
}
