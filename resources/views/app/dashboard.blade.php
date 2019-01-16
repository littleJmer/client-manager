@extends('layouts.app')

@if(Session::has('sysmsg'))
<div class="alert alert-primary text-center" style="margin: 0;" role="alert">{{ Session::get('sysmsg') }}</div>
@endif

@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endsection

@section('js')
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
<script defer src="https://use.fontawesome.com/releases/v5.6.3/js/all.js" integrity="sha384-EIHISlAOj4zgYieurP0SdoiBYfGJKkgWedPHH4jCzpCXLmzVsw1ouK59MuUtP4a1"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.33.1/dist/sweetalert2.all.min.js" integrity="sha256-Qfxgn9jULeGAdbaeDjXeIhZB3Ra6NCK3dvjwAG8Y+xU=" crossorigin="anonymous"></script>
<script src="{{ asset('js/dashboard.js') }}" defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row" style="margin: 25px 0;">
        <div class="col-sm-12 text-right">
            <a href="{{ route('app.client-create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;Create Client</a>
            <a href="{{ route('app.import-csv') }}" class="btn btn-primary"><i class="fas fa-file-import"></i>&nbsp;Import</a>
            <button class="btn btn-primary" id="btnExport"><i class="fas fa-file-export"></i>&nbsp;Export</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div>
                <div class="row">
                    <div class="col-sm-6">
                        Total of Clients <span data-pagination-total></span>
                    </div>
                    <div class="col-sm-6 text-right">
                        Page <span data-pagination-current></span> of <span data-pagination-last></span>
                    </div>
                </div>
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <td>Full Name</td>
                            <td>Age</td>
                            <td>City + State</td>
                            <td>Controls</td>
                        </tr>
                    </thead>
                    <tbody data-clients-table></tbody>
                </table>
                <nav aria-label="">
                    <ul class="pagination justify-content-end" data-pagination></ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection