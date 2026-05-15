<?php

namespace App\Admin\Http\Controllers\Transaction;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Transaction\TransactionRequest;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Admin\Services\Transaction\TransactionServiceInterface;
use App\Admin\DataTables\Transaction\TransactionDataTable;
use App\Admin\Repositories\Ticket\TicketRepositoryInterface;
use App\Enums\Transaction\TransactionStatus;

class TransactionController extends Controller
{
    protected $ticketRepository;
    public function __construct(
        TransactionRepositoryInterface $repository,
        TicketRepositoryInterface $ticketRepository,
        TransactionServiceInterface $service
    ) {

        parent::__construct();

        $this->repository = $repository;
        $this->ticketRepository = $ticketRepository;

        $this->service = $service;
    }

    public function getView()
    {
        return [
            'index' => 'admin.transactions.index',
            'create' => 'admin.transactions.create',
            'edit' => 'admin.transactions.edit',
            'payment' => 'admin.transactions.payment',
            'ticket-modal' => 'components.quickticketview',
        ];
    }

    public function getRoute()
    {
        return [
            'index' => 'admin.transaction.index',
            'create' => 'admin.transaction.create',
            'edit' => 'admin.transaction.edit',
            'delete' => 'admin.transaction.delete',
            'payment' => 'admin.transaction.payment',
        ];
    }
    public function index(TransactionDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('Danh sách đăng ký gói vé'))
        ]);
    }

    public function payment($id)
    {
        $transaction = $this->repository->findOrFail($id);
        return view($this->view['payment'], [
            'transaction' => $transaction,
        ]);
    }

    public function renderModalProduct($id)
    {
        $ticket = $this->ticketRepository->findOrFail($id);
        return view($this->view['ticket-modal'], [
            'ticketModal' => $ticket,
        ]);
    }

    public function create()
    {
        $tickets = $this->ticketRepository->getTicketsWithPaginate();
        return view($this->view['create'], [
            'tickets' => $tickets,
        ]);
    }

    public function store(TransactionRequest $request)
    {
        try {
            $response = $this->service->store($request);

            if ($response === 1) {
                return back()->with('error', __('Số vé không đủ'))->withInput();
            }

            if ($response) {
                return to_route($this->route['payment'], $response->id)->with('success', __('notifySuccess'));
            }

            return back()->with('error', __('notifyFail'))->withInput();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $transaction = $this->repository->findOrFail($id);
        return view(
            $this->view['edit'],
            [
                'transaction' => $transaction,
                'status' => TransactionStatus::asSelectArray(),
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách đăng ký'),
                    route($this->route['index'])
                )->add(__('edit'))
            ]
        );
    }

    public function update(TransactionRequest $request)
    {
        $response = $this->service->update($request);
        if (!$response) {
            return back()->with('error', __('notifyFail'))->withInput();
        }
        return back()->with('success', __('notifySuccess'));
    }

    public function paymentUpdate(TransactionRequest $request)
    {
        $response = $this->service->uploadPaymentImage($request);
        if ($response) {
            return back()->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'));
    }

    public function delete($id)
    {

        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));
    }

    public function confirm($id)
    {
        try {
            $result = $this->service->confirm($id);
            if ($result) {
                return to_route($this->route['index'])->with('success', __('Duyệt thành công'));
            }

            return to_route($this->route['index'])->with('error', __('Duyệt thất bại không rõ nguyên nhân'));
        } catch (\Throwable $e) {
            return to_route($this->route['index'])->with('error', __('Duyệt thất bại: ') . $e->getMessage());
        }
    }


    public function cancel($id)
    {
        $result = $this->service->cancel($id);
        if ($result) {
            return to_route($this->route['index'])->with('success', __('Huỷ thành công'));
        }
        return to_route($this->route['index'])->with('error', __('Huỷ thất bại'));
    }
}
