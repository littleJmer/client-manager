@extends('layouts.app')

@if(Session::has('sysmsg'))
<div class="alert alert-primary text-center" style="margin: 0;" role="alert">{{ Session::get('sysmsg') }}</div>
@endif

@section('css')
@endsection

@section('js')
<script defer src="https://use.fontawesome.com/releases/v5.6.3/js/all.js" integrity="sha384-EIHISlAOj4zgYieurP0SdoiBYfGJKkgWedPHH4jCzpCXLmzVsw1ouK59MuUtP4a1"
    crossorigin="anonymous"></script>
<script src="{{ asset('js/clients.js') }}" defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row" style="margin: 25px 0;">
        <div class="col-sm-12 text-center">
            <h2>Create Client</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form id="clientForm">
                <input type="hidden" name="id" value="{{ isset($client) ? $client->id : 0 }}">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="first_name" class="required">First name</label>
                        <input
                            type="text"
                            class="form-control"
                            id="first_name"
                            name="first_name"
                            autofocus
                            value="{{ isset($client) ? $client->first_name : '' }}"
                        />
                        <div class="invalid-feedback show"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name" class="required">Last name</label>
                        <input
                            type="text"
                            class="form-control"
                            id="last_name"
                            name="last_name"
                            value="{{ isset($client) ? $client->last_name : '' }}"
                        />
                        <div class="invalid-feedback show"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="gender" class="required">Gender</label>
                        <select class="form-control" name="gender" id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <div class="invalid-feedback show"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="date_of_birth" class="required">Date of birth</label>
                        <input
                            type="date"
                            class="form-control"
                            id="date_of_birth"
                            name="date_of_birth"
                            value="{{ isset($client) ? $client->date_of_birth : '' }}"
                        />
                        <div class="invalid-feedback show"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="address" class="required">Address</label>
                        <input
                            type="text"
                            class="form-control"
                            id="address"
                            name="address"
                            value="{{ isset($client) ? $client->address : '' }}"
                        />
                        <div class="invalid-feedback show"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="city" class="required">City</label>
                        <input
                            type="text"
                            class="form-control"
                            id="city"
                            name="city"
                            value="{{ isset($client) ? $client->city : '' }}"
                        />
                        <div class="invalid-feedback show"></div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="state" class="required">State</label>
                        <input
                            type="text"
                            class="form-control"
                            id="state"
                            name="state"
                            value="{{ isset($client) ? $client->state : '' }}"
                        />
                        <div class="invalid-feedback show"></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="zip_code" class="required">Zip Code</label>
                        <input
                            type="text"
                            class="form-control"
                            id="zip_code"
                            name="zip_code"
                            value="{{ isset($client) ? $client->zip_code : '' }}"
                        />
                        <div class="invalid-feedback show"></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email" class="required">Email</label>
                        <input
                            type="text"
                            class="form-control"
                            id="email"
                            name="email"
                            value="{{ isset($client) ? $client->email : '' }}"
                        />
                        <div class="invalid-feedback show"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="work_phone">Work Phone</label>
                        <input
                            type="text"
                            class="form-control" 
                            id="work_phone"
                            name="work_phone"
                            value="{{ isset($client) ? $client->work_phone : '' }}"
                        />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cell_phone">Cell Phone</label>
                        <input
                            type="text"
                            class="form-control"
                            id="cell_phone"
                            name="cell_phone"
                            value="{{ isset($client) ? $client->cell_phone : '' }}"
                        />
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection