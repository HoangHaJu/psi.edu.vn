<?php

namespace App\Admin\Http\Controllers\Student;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Http\Requests\Admin\AdminCreateRequest;
use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Services\Admin\AdminServiceInterface;
use App\Admin\DataTables\Admin\StudentDataTable;
use App\Admin\Http\Requests\Admin\AdminUpdateRequest;
use App\Enums\User\Gender;
use App\Traits\UseLog;
use App\Models\Transaction;
use App\Models\TicketStudent;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Exports\StudentSingleExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class StudentController extends Controller
{
    use UseLog;
    public function __construct(
        AdminRepositoryInterface $repository,
        AdminServiceInterface $service
    ) {

        parent::__construct();

        $this->repository = $repository;

        $this->service = $service;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.students.index',
            'create' => 'admin.students.create',
            'edit' => 'admin.students.edit'
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.student.index',
            'create' => 'admin.student.create',
            'edit' => 'admin.student.edit',
            'delete' => 'admin.student.delete'
        ];
    }
    public function index(StudentDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('Danh sách học viên'))
        ]);
    }
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            if (auth()->user()->isSuperAdmin) {
                DB::beginTransaction();

                $path = $request->file('excel_file')->getRealPath();
                $data = \Maatwebsite\Excel\Facades\Excel::toArray([], $path);

                if (empty($data[0])) {
                    return redirect()->back()->with('error', 'File Excel không có dữ liệu!');
                }

                $headers = $data[0][0];

                foreach ($data[0] as $index => $row) {
                    if ($index === 0) continue;

                    $rowData = array_combine($headers, $row);

                    // Tạo admin mới
                    $admin = $this->repository->create($rowData);

                    // Gán role student
                    if ($admin) {
                        $admin->assignRole('student');
                    }
                }

                DB::commit();
                return redirect()->back()->with('success', 'Dữ liệu đã được nhập thành công!');
            }

            return back()->with('error', 'Bạn không có quyền thực hiện thao tác này!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->logError('Lỗi nhập dữ liệu từ file Excel!', $e);
            return redirect()->back()->with('error', 'Lỗi nhập dữ liệu từ file Excel!');
        }
    }


    public function export()
    {
        try {
            $categories = $this->repository->getAll();
            return Excel::download(new StudentSingleExport($categories), 'student_list.xlsx');
        } catch (Exception $e) {
            $this->logError('Lỗi xuất dữ liệu khoá học!', $e);
            return redirect()->back()->with('error', 'Lỗi xuất dữ liệu khoá học!');
        }
    }

    public function create(): Factory|View|Application
    {
        return view($this->view['create'], [
            'gender' => Gender::asSelectArray(),
            'breadcrumbs' => $this->crums->add(
                __('Danh sách học viên'),
                route($this->route['index'])
            )->add(__('add')),
        ]);
    }


    public function store(AdminCreateRequest $request): RedirectResponse
    {
        $instance = $this->service->store($request, 'student');
        return to_route($this->route['edit'], $instance->id);
    }

    public function edit($id): Factory|View|Application
    {
        $admin = $this->repository->findOrFail($id);

        $tickets = \App\Models\Ticket::all(); // Danh sách tất cả loại vé
        $ticketDetails = []; // Chi tiết vé theo từng loại
        $currentType = 'none';
        $gender = Gender::asSelectArray();

        if ($admin) {
            // Vé đang dùng
            $currentType = $admin->current_type_ticket ?? 'none';

            // Lấy tất cả vé của học viên, nạp quan hệ ticket
            $ticketDetails = TicketStudent::where('admin_id', $admin->id)
                ->with('ticket')
                ->get()
                ->groupBy(fn($t) => $t->ticket->name ?? 'Không rõ')
                ->map(function ($tickets, $name) {
                    return [
                        'name' => $name,
                        'remaining_tickets' => $tickets->sum('remaining_tickets'),
                        'expired_min' => $tickets->min('expired_date'),
                        'expired_max' => $tickets->max('expired_date'),
                    ];
                })
                ->values(); // reset key để dễ foreach

        }

        return view($this->view['edit'], compact(
            'tickets',
            'ticketDetails',
            'currentType',
            'admin',
            'gender'
        ));
    }



    public function update(AdminUpdateRequest $request): RedirectResponse
    {

        $this->service->update($request);

        return back()->with('success', __('notifySuccess'));
    }

    public function delete($id): RedirectResponse
    {

        $this->service->delete($id);

        return to_route($this->route['index'])->with('success', __('notifySuccess'));
    }
}
