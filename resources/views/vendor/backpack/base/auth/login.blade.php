@extends(backpack_view('layouts.plain'))

@section('content')
<style>
body {
    background-image: url('https://thumbs.web.sapo.io/?W=1920&H=0&crop=center&delay_optim=1&epic=ZDhkZT+bIJYvfxZbKhK29x0h9mGJ2Lr3/I0/r9zdKWrbSgT1VV22fx7KHStaloAsoDUSK6wP54LSQkyr8yN3QgYym1fHEqqiqhvNcYssca88ahI=');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
}

.card {
	background-color: rgba(0, 0, 0, 0.5);
	margin: auto auto;
	border-radius: 5px;
	box-shadow: 0 0 10px #000;
}


</style>

    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-4">
            <div class="card">
             <h3 class="text-center mb-4" style="color:white">{{ trans('backpack::base.login') }}</h3>
                <div class="card-body">
                    <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('backpack.auth.login') }}">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="control-label" style="color:white" for="{{ $username }}">{{ config('backpack.base.authentication_column_name') }}</label>

                            <div>
                                <input type="text" class="form-control{{ $errors->has($username) ? ' is-invalid' : '' }}" name="{{ $username }}" value="{{ old($username) }}" id="{{ $username }}">

                                @if ($errors->has($username))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first($username) }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" style="color:white" for="password">{{ trans('backpack::base.password') }}</label>

                            <div>
                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <div class="checkbox">
                                    <label style="color:white">
                                        <input type="checkbox" name="remember"> {{ trans('backpack::base.remember_me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-block btn-primary">
                                    {{ trans('backpack::base.login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            
            @if (backpack_users_have_email() && backpack_email_column() == 'email' && config('backpack.base.setup_password_recovery_routes', true))
                <div class="text-center"><a style="color:white" href="{{ route('backpack.auth.password.reset') }}">{{ trans('backpack::base.forgot_your_password') }}</a></div>
            @endif
            @if (config('backpack.base.registration_open'))
                <div class="text-center"><a style="color:white" href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a></div>
            @endif
            </div>
        </div>
    </div>
@endsection
