<?php

namespace App\Admin\Http\Controllers\Ticket;

use App\Admin\DataTables\Ticket\TicketDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Ticket\TicketRequest;
use App\Admin\Repositories\Ticket\TicketRepositoryInterface;
use App\Admin\Services\Ticket\TicketServiceInterface;
use App\Admin\Traits\AuthService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{
    use AuthService;

    public function __construct(
        TicketRepositoryInterface $repository,
        TicketServiceInterface    $service
    ) {

        parent::__construct();

        $this->repository = $repository;
        $this->service = $service;
    }

    public function getView(): array
    {

        return [
            'extend' => 'admin.tickets.extend',
            'index' => 'admin.tickets.index',
            'create' => 'admin.tickets.create',
            'edit' => 'admin.tickets.edit',
            'detail' => 'admin.tickets.detail',
        ];
    }

    public function getRoute(): array
    {

        return [
            'extend' => 'admin.ticket.extend',
            'index' => 'admin.ticket.index',
            'create' => 'admin.ticket.create',
            'edit' => 'admin.ticket.edit',
            'detail' => 'admin.ticket.detail',
        ];
    }

    public function index(TicketDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('Danh sách gói vé'))
        ]);
    }


    public function detail($id): View|Application
    {
        $response = $this->repository->findOrFail($id);
        return view(
            $this->view['detail'],
            [
                'ticket' => $response,
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách gói vé'),
                    route($this->route['index'])
                )->add(__('Chi tiết'))
            ],
        );
    }

    public function create(): View|Application
    {
        return view($this->view['create'], [
            'breadcrumbs' => $this->crums->add(
                __('Danh sách gói vé'),
                route($this->route['index'])
            )->add(__('add')),
        ]);
    }
    public function store(TicketRequest $request)
    {
        $response = $this->service->store($request);
        if ($response) {
            return redirect()->route($this->route['edit'], $response->id)->with('success', __('notifySuccess'));
        }
        return redirect()->route($this->route['create'])->with('error', __('notifyFail'));
    }


    public function extend(): View|Application
    {
        $packageTickets = $this->repository->getAll();
        return view(
            $this->view['extend'],
            [
                'packageTickets' => $packageTickets,
            ]
        );
    }

    public function extendStore(Request $request)
    {
        $response = $this->service->extendStore($request);

        if ($response === true) {
            return redirect()->route($this->route['extend'])
                ->with('success', __('notifySuccess'));
        }

        return redirect()->route($this->route['extend'])
            ->with('error', $response['error'] ?? __('notifyError'));
    }

    public function edit($id): View|Application
    {
        $response = $this->repository->findOrFail($id);
        return view(
            $this->view['edit'],
            [
                'ticket' => $response,
                'breadcrumbs' => $this->crums->add(
                    __('Danh sách gói vé'),
                    route($this->route['index'])
                )->add(__('edit'))
            ],
        );
    }

    public function update(TicketRequest $request): RedirectResponse
    {
        $response = $this->service->update($request);
        if ($response) {
            return back()->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'));
    }


    public function delete($id): RedirectResponse
    {

        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));
    }
}
