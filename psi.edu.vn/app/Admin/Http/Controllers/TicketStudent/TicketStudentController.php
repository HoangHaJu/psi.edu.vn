<?php

namespace App\Admin\Http\Controllers\TicketStudent;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Traits\AuthService;
use App\Admin\Services\TicketStudent\TicketStudentServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TicketStudentController extends Controller
{
    use AuthService;

    protected $service;

    public function __construct(
        TicketStudentServiceInterface $service
    ) {
        parent::__construct();
        $this->service = $service;
    }

    public function getView(): array
    {
        return [
            'index' => 'admin.ticket_students.index',
        ];
    }

    public function getRoute(): array
    {
        return [
            'index' => 'admin.ticket_students.index',
            'api_tickets' => 'admin.api.tickets', // Make sure this matches your route name for this method
        ];
    }

    public function index()
    {
        return view($this->view['index'], [
            'breadcrumbs' => $this->crums->add(__('Danh sách vé'))
        ]);
    }

    /**
     * Get tickets via API for frontend rendering.
     * Filters tickets based on the logged-in user's role (admin sees all, student sees their own).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTicketsApi(Request $request)
    {
        try {
            $user = auth('admin')->user();
            $adminId = null;
            if ($user && isset($user->isStudent) && $user->isStudent) {
                $adminId = $user->id;
            }

            $ticketType = $request->query('ticket_type');

            $result = $this->service->getTickets($adminId, $ticketType);

            return response()->json([
                'success' => true,
                'data' => $result, // trả về trực tiếp
            ]);
        } catch (\Exception $e) {
            Log::error("Error fetching tickets in TicketStudentController::getTicketsApi: "
                . $e->getMessage() . " - " . $e->getFile() . " on line " . $e->getLine());

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lấy dữ liệu vé.'
            ], 500);
        }
    }
}
