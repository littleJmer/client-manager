@extends('layouts.app')

@section('css')
<script defer src="https://use.fontawesome.com/releases/v5.6.3/js/all.js" integrity="sha384-EIHISlAOj4zgYieurP0SdoiBYfGJKkgWedPHH4jCzpCXLmzVsw1ouK59MuUtP4a1"
    crossorigin="anonymous"></script>
@endsection

@section('js')
<script src="{{ asset('js/csv.js') }}" defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row" style="margin: 25px 0;">
        <div class="col-md-12 text-right">&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="jumbotron jumbotron-fluid hover" onClick="CSV.select();">
                <div class="container text-center">
                    <p class="display-4">Click to select and upload CSV</p>
                    <i class="fas fa-upload fa-7x"></i>
                </div>
            </div>
            <form id="formCsv" enctype="multipart/form-data">
                <input type="file" id="fileCsv" name="fileCsv" style="display: none;" />
            </form>
            <div class="alert alert-danger invisible" role="alert" id="errorCsv">
                <strong>:'(</strong> Please check your template
                <ul data-extra-errors></ul>
            </div>
            <div class="alert alert-warning invisible" role="alert" id="msgCsv">
                <strong>:O</strong> <span></span>
            </div>
        </div>
    </div>
</div>
@endsection