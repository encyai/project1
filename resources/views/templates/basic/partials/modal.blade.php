@php
    $info = json_decode(json_encode(getIpInfo()), true);
    $mobileCode = @implode(',', $info['code']);
    $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
    $policyPages = getContent('policy_pages.element', false, null, true);
@endphp

<!-- Login -->
<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">@lang('Login your account')</h3>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="account-form verify-gcaptcha" action="{{ route('user.login') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>@lang('Username or Email')</label>
                        <input type="text" name="username" value="{{ old('username') }}" class="form--control"
                            required>
                    </div>
                    <div class="form-group">
                        <label>@lang('Password')</label>
                        <input id="password" type="password" class="form--control" name="password" required required>
                    </div>

                    <div class="mt-3">
                        <x-captcha />
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                @lang('Remember Me')
                            </label>
                        </div>
                        <a href="#" class="text-white" data-bs-toggle="modal" data-bs-target="#resetModal"
                            data-bs-dismiss="modal">@lang('Forgot Password')?</a>
                    </div>
                    <button type="submit" class="btn btn--base w-100">@lang('Login')</button>
                    <p class="text-center mt-3"><span class="text-white">@lang('Don\'t have an account')?
                        </span> <a href="#0" class="text--base" data-bs-toggle="modal"
                            data-bs-target="#registerModal" data-bs-dismiss="modal"> @lang('Register')</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Register --}}
<div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">@lang('Create an account')</h3>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="la la-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="account-form registration-form verify-gcaptcha" action="{{ route('user.register') }}"
                    method="post">
                    @csrf
                    <div class="row">
                        @if (session()->get('reference') != null)
                            <div class="col-lg-12 mb-3">
                                <label>@lang('Reference By')</label>
                                <input type="text" name="referBy" id="referenceBy" class="form--control"
                                    value="{{ session()->get('reference') }}" readonly>
                            </div>
                        @endif

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>{{ __('Username') }}</label>
                                <input id="username" type="text" class="form--control checkUser" name="username"
                                    value="{{ old('username') }}" required>
                                <small class="text-danger usernameExist"></small>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>@lang('E-Mail Address')</label>
                                <input id="email" type="email" class="form--control checkUser" name="email"
                                    value="{{ old('email') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>{{ __('Country') }}</label>
                                <select name="country" id="country" class="form--control" required>
                                    @foreach ($countries as $key => $country)
                                        <option data-mobile_code="{{ $country->dial_code }}"
                                            value="{{ $country->country }}" data-code="{{ $key }}">
                                            {{ __($country->country) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>@lang('Mobile')</label>
                                <div class="input-group">
                                    <span class="input-group-text mobile-code"></span>
                                    <input type="hidden" name="mobile_code">
                                    <input type="hidden" name="country_code">
                                    <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}"
                                        class="form--control checkUser" required>
                                </div>
                                <small class="text-danger mobileExist"></small>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>@lang('Password')</label>
                                <input id="registerPassword" type="password" class="form--control" name="password"
                                    required>
                                @if ($general->secure_password)
                                    <div class="input-popup">
                                        <p class="error lower">@lang('1 small letter minimum')</p>
                                        <p class="error capital">@lang('1 capital letter minimum')</p>
                                        <p class="error number">@lang('1 number minimum')</p>
                                        <p class="error special">@lang('1 special character minimum')</p>
                                        <p class="error minimum">@lang('6 character password')</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>@lang('Confirm Password')</label>
                                <input id="password-confirm" type="password" class="form--control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="mt-3">
                            <x-captcha />
                        </div>

                        @if ($general->agree)
                            <div class="col-lg-12 mt-4">
                                <div class="form-group">
                                    <input type="checkbox" id="agree" @checked(old('agree')) name="agree" required>
                                    <label for="agree">@lang('I agree with') </label>
                                    <span>
                                        @foreach ($policyPages as $policy)
                                            <a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}">{{ __($policy->data_values->title) }}</a>
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </span>

                                </div>
                            </div>
                        @endif

                    </div>
                    <button type="submit" id="recaptcha"
                        class="btn btn--base w-100 mt-3">@lang('Register')</button>
                    <p class="text-center mt-3"><span class="text-white"> @lang('Have an account')? </span> <a
                            href="#0" class="text--base" data-bs-toggle="modal" data-bs-target="#loginModal"
                            data-bs-dismiss="modal">@lang('Login')</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Exist-User-Credential --}}
<div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="la la-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <h6 class="text-center">@lang('You already have an account please Sign in ')</h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--danger text-white" data-bs-dismiss="modal">@lang('Close')</button>

                <button type="button" class="btn btn--base ex-email" data-bs-dismiss="modal" data-bs-toggle="modal"
                    data-bs-target="#loginModal">@lang('Login')</button>
            </div>
        </div>
    </div>
</div>

{{-- Password Reset --}}
<div class="modal fade" id="resetModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">@lang('Reset Password')</h3>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                    <i class="la la-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="account-form" method="POST" action="{{ route('user.password.email') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">@lang('Email or Username')</label>
                        <input type="text" class="form-control form--control" name="value"
                            value="{{ old('value') }}" required autofocus="off">
                    </div>

                    <button type="submit" class="btn btn--base w-100">@lang('Send Password Code')</button>
                    <p class="text-center mt-3"><span class="text-white">@lang('Have been remembering')?</span> <a href="#0"
                            class="text--base" data-bs-toggle="modal" data-bs-target="#loginModal"
                            data-bs-dismiss="modal">@lang('Login')</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

@if ($general->secure_password)
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif


@push('script')
    <script>
        "use strict";

        $(document).ready(function() {


            @if (@$mobile_code)
                $(`option[data-code={{ $mobile_code }}]`).attr('selected', '');
            @endif

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));


            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();

                var token = '{{ csrf_token() }}';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.ex} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });

            $('.ex-email').on('click', function() {
                $('#existModalCenter').modal('hide');
            })


            let anyError = '{{ @$errors->any() }}';

            let modalType = '{{ Session::get('modalType') }}';

            if (anyError || modalType) {
                let errorModal = '{{ Session::get('modal') }}';
                $(errorModal).modal('show');
            }

        });
    </script>
@endpush
