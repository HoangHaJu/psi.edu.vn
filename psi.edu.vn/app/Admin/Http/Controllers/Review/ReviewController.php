<?php

namespace App\Admin\Http\Controllers\Review;

use App\Admin\DataTables\Review\ReviewDataTable;
use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Review\ReviewRepositoryInterface;
use App\Admin\Services\Review\ReviewServiceInterface;
use App\Admin\Http\Requests\Review\ReviewRequest;
use Illuminate\Http\RedirectResponse;
use App\Admin\Traits\AuthService;
use App\Traits\ResponseController;
use Exception;
use App\Traits\UseLog;
use App\Exports\ReviewsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReviewController extends Controller
{
    use ResponseController, AuthService, UseLog;
    public function __construct(
        ReviewRepositoryInterface $repository,
        ReviewServiceInterface $service
    ) {
        parent::__construct();
        $this->repository = $repository;
        $this->service = $service;
    }
    public function getView(): array
    {
        return [
            'index' => 'admin.reviews.index',
        ];
    }

    public function index(ReviewDataTable $dataTable)
    {
        return $dataTable->render($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('Danh sách đánh giá'))
        ]);
    }

    public function store(ReviewRequest $request): RedirectResponse
    {
        $instance = $this->service->store($request);
        if ($instance) {
            return back()->with('success', __('notifySuccess'));
        }
        return back()->with('error', __('notifyFail'));
    }

    public function export()
    {
        try {
            $reviews = $this->repository->getAllDetails();
            return Excel::download(new ReviewsExport($reviews), 'review.xlsx');
        } catch (Exception $e) {
            $this->logError('Lỗi xuất dữ liệu danh mục!', $e);
            return redirect()->back()->with('error', 'Lỗi xuất dữ liệu danh mục!');
        }
    }
}
