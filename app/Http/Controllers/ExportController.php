<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;


class ExportController
{
    use AuthorizesRequests;

    /**
     * @param Request $request
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws ValidationException
     */
    public function download(Request $request)
    {
        $this->authorize('access export utility');

        $from = $request->input('from');
        $until = $request->input('until');

        return Excel::download(new SalesExport($from, $until), 'sales.csv');
    }
}
