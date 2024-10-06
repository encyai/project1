@extends($activeTemplate.'layouts.master')
@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6">
                @if(Auth::user()->ts)
                    <div class="custom--card">
                        <div class="card-body text-center">
                            <p class="fs--14px mb-2">@lang('Use Google Authentication ') <a class="text--base" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('App Link')</a></p>
                            <div class="form-group mx-auto text-center">
                                <a href="#0"  class="btn btn--base w-100" data-bs-toggle="modal" data-bs-target="#disableModal">
                                    @lang('Disable Two Factor Authenticator')</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="custom--card">
                        <div class="card-body">
                            <div class="form-group mx-auto text-center">
                                <img class="mx-auto" src="{{$qrCodeUrl}}">
                                <p class="fs--14px mt-2">@lang('Use Google Authentication App to scan the QR code') <a class="text--base" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="_blank">@lang('App Link')</a></p>
                            </div>
                            
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="key" value="{{$secret}}" class="form-control form--control referralURL" readonly>
                                    <button type="button" class="input-group-text copytext bg--base" id="copyBoard"> <i class="fa fa-copy"></i> </button>
                                </div>
                            </div>

                            <div class="form-group mx-auto text-center">
                                <a href="#0" class="btn btn--base mt-3 mb-1 w-100" data-bs-toggle="modal" data-bs-target="#enableModal">@lang('Enable Two Factor Authenticator')</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>


    <!--Enable Modal -->
    <div id="enableModal" class="modal fade" role="dialog">
        <div class="modal-dialog ">
            <!-- Modal content-->
            <div class="modal-content ">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Verify Your Otp')</h4>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <form action="{{route('user.twofactor.enable')}}" method="POST">
                    @csrf
                    <div class="modal-body ">
                        <div class="form-group">
                            <input type="hidden" name="key" value="{{$secret}}">
                            <input type="text" class="form--control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--base">@lang('Verify')</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!--Disable Modal -->
    <div id="disableModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Verify Your Otp Disable')</h4>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <form action="{{route('user.twofactor.disable')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form--control" name="code" placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--sm btn--secondary" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--sm btn--base">@lang('Verify')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>

@endsection
@push('style')
<style>
    .copied::after {
        background-color: #{{ $general->base_color }};
    }
</style>
@endpush

@push('script')
    <script>
        (function($){
            "use strict";
            $('#copyBoard').click(function(){
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 1500);
            });
        })(jQuery);
    </script>
@endpush



