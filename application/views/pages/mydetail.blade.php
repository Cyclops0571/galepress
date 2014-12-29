@layout('layouts.master')

@section('content')
    
    <?php
    $timezones = DB::table('Timezone')
                    ->order_by('TimezoneID', 'ASC')
                    ->get();
    ?>
    <div class="col-md-8">    
        <div class="block bg-light-ltr">
            <div class="header">
                <h2>{{ __('common.detailpage_caption') }}</h2>
            </div>
            {{ Form::open(__('route.mydetail'), 'POST') }}
                {{ Form::token() }}
                <div class="content controls">
                    <div class="form-row">
                        <div class="col-md-3">{{ __('common.users_firstname') }} <span class="error">*</span></div>
                        {{ $errors->first('FirstName', '<p class="error">:message</p>') }}
                        <div class="col-md-9">
                            <input type="text" name="FirstName" id="FirstName" class="form-control textbox required" value="{{ Auth::User()->FirstName }}" />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">{{ __('common.users_lastname') }} <span class="error">*</span></div>
                        {{ $errors->first('LastName', '<p class="error">:message</p>') }}
                        <div class="col-md-9">
                            <input  type="text" name="LastName" id="LastName" class="form-control textbox required" value="{{ Auth::User()->LastName }}"/>
                        </div>
                    </div>                        
                    <div class="form-row">
                        <div class="col-md-3">{{ __('common.users_email') }} <span class="error">*</span></div>
                         {{ $errors->first('Email', '<p class="error">:message</p>') }}
                        <div class="col-md-9">
                            <input type="text" name="Email" id="Email" class="form-control textbox required" value="{{ Auth::User()->Email }}"/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">{{ __('common.users_password') }}</div>
                        <div class="col-md-9">
                            <input class="form-control" type="password" name="Password" id="Password" value="" />
                        </div>
                    </div>                        
                    <div class="form-row">
                        <div class="col-md-3">{{ __('common.users_password2') }}</div>
                        <div class="col-md-9">
                            <input class="form-control" type="password" name="Password2" id="Password2" value="" />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">{{ __('common.users_timezone') }}</div>
                        <div class="col-md-9">
                            <select class="form-control select2" style="width: 100%;" tabindex="-1" id="Timezone" name="Timezone">
                                <option value=""{{ (Auth::User()->Timezone == '' ? ' selected="selected"' : '') }}></option>
                                @foreach ($timezones as $timezone)
                                <option value="{{ $timezone->Value }}"{{ (Auth::User()->Timezone == $timezone->Value ? ' selected="selected"' : '') }}>{{ $timezone->Text }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            {{ Form::close() }}
            <div class="footer tar">
                <div style="float:right;">
                    <input class="btn my-btn-success" type="button" onclick="cUser.saveMyDetail();" value="{{ __('common.detailpage_update') }}">
                </div>
            </div>
        </div>
    </div>
@endsection
            
