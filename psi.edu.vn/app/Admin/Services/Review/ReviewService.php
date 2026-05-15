<?php

namespace App\Admin\Services\Review;

use App\Admin\Repositories\Booking\BookingRepositoryInterface;
use App\Admin\Services\Review\ReviewServiceInterface;
use App\Admin\Repositories\Review\ReviewRepositoryInterface;
use App\Admin\Traits\AuthService;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use App\Traits\UseLog;
use Exception;
use Illuminate\Support\Facades\DB;

class ReviewService implements ReviewServiceInterface
{
    use Setup, UseLog, AuthService;
    protected $data;
    protected $repository;
    protected $bookingRepository;

    public function __construct(
        ReviewRepositoryInterface $repository,
        BookingRepositoryInterface $bookingRepository,
    ) {
        $this->repository = $repository;
        $this->bookingRepository = $bookingRepository;
    }

    public function store(Request $request)
    {
        $this->data = $request->validated();
        DB::beginTransaction();
        try {
            $booking = $this->bookingRepository->findOrFail($this->data['booking_id']);
            $this->data['admin_id'] = $booking['admin_id'];
            $this->data['course_id'] = $booking['course_id'];
            $this->repository->create($this->data);
            $booking->update(['is_reviewed' => 1]);
            DB::commit();
            return true;
        } catch (Exception $e) {
            $this->logError('Failed to process review: ', $e);
            DB::rollBack();
            return false;
        }
    }
}
