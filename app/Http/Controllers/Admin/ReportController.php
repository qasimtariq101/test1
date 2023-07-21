<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paste;
use App\Models\Report;
use Datatables;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index')->with('page_title', __('Reported Books'));
    }

    public function destroy(Request $request)
    {
        $report = Report::findOrfail($request->id);
        $report->delete();

        if($request->ajax()) return alert_messages_admin(__('Successfully deleted'));
        return redirect()->back()->withSuccess(__('Successfully deleted'));
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            $reports = Report::select();
            return Datatables::of($reports)
                ->addColumn('check', function ($report) {
                    return '<input type="checkbox" class="check" name="check[]" value="' . $report->id . '" data-pid="' . $report->book_id . '">';
                })
                ->addColumn('book', function ($report) {
                    if (isset($report->book)) {
                        return '<a target="_blank" href="' . $report->book->url . '">' . $report->book->title_f . '</a>';
                    } else {
                        return 'deleted book';
                    }

                })
                ->editColumn('reason', function ($report) {
                    return '<a class="view_report" data-reason="' . $report->reason . '"><i class="fa fa-eye"></i> View</a>';
                })
                ->addColumn('user', function ($report) {
                    if (isset($report->user)) {
                        return '<a target="_blank" href="' . url('admin/users/' . $report->user->id . '/edit') . '">' . $report->user->name . '</a>';
                    } else {
                        return __('deleted user');
                    }

                })
                ->addColumn('action', function ($report) {
                    $action = '<a class="btn btn-sm btn-danger eco_link" href="' . url('admin/reported-books/' . $report->id . '/delete') . '"><i class="fa fa-trash"></i> '.__('Delete Report').'</a>';
                    if (isset($report->book)) {
                        $action .= '<a class="btn btn-sm btn-danger eco_link ml-2" href="' . url('admin/books/' . $report->book->id . '/delete') . '"><i class="fa fa-trash"></i> '.__('Delete book').'</a>';
                    }

                    return $action;
                })
                ->make(true);
        }
    }

    public function deleteSelected(Request $request)
    {
        if (!empty($request->ids)) {
            $reports = Report::whereIn('id', $request->ids)->delete();
            echo "success";
        } else {
            echo "error";
        }
    }

}
