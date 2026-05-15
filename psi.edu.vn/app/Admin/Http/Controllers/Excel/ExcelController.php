<?php

namespace App\Admin\Http\Controllers\Excel;

use Illuminate\Http\Request;
use App\Admin\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MultiSheetImport;
use App\Exports\MultiSheetExport;
use Exception;
use Illuminate\Support\Facades\DB;

class ExcelController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            DB::beginTransaction();
            Excel::import(new MultiSheetImport, $request->file('excel_file'));
            DB::commit();

            return back()->with('success', 'Dữ liệu đã được nhập thành công!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi nhập dữ liệu: ' . $e->getMessage());
        }
    }

    public function export()
    {
        try {
            return Excel::download(new MultiSheetExport(), 'database_export.xlsx');
        } catch (Exception $e) {
            return back()->with('error', 'Lỗi xuất dữ liệu: ' . $e->getMessage());
        }
    }
}
