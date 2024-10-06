@php
    $kyc = getContent('kyc_info.content', true);
@endphp
@extends($activeTemplate . 'layouts.master')
@section('content')
    <!-- dashboard section start -->
    <section class="py-5">
        <div class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-lg-12 mb-30">
                    @if (auth()->user()->kv == Status::KYC_UNVERIFIED)
                        <div class="alert alert-danger package-card text--danger border" role="alert">
                            <h4 class="alert-heading">@lang('KYC Verification required')</h4>
                            <hr>
                            <p class="mb-0">{{ __(@$kyc->data_values->verification_instruction) }}
                                <a class="text--base" href="{{ route('user.kyc.form') }}">@lang('Click Here to Verify')</a>
                            </p>
                        </div>
                    @elseif(auth()->user()->kv == Status::KYC_PENDING)
                        <div class="alert alert-warning package-card text--warning border" role="alert">
                            <h4 class="alert-heading">@lang('KYC Verification pending')</h4>
                            <hr>
                            <p class="mb-0">{{ __(@$kyc->data_values->pending_instruction) }}
                                <a class="text--base" href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a>
                            </p>
                        </div>
                    @endif

                </div>

                <div class="col-lg-12 mb-30">

                    @include($activeTemplate . 'partials.referral_link')

                </div>

                <div class="col-lg-3 col-sm-6">
                    <a class="d-block" href="{{ route('user.transactions') }}">
                        <div class="balance-card">
                            <span class="text--dark">@lang('Total Balance')</span>
                            <h3 class="number text--dark">
                                {{ $general->cur_sym . showAmount($user->balance) }}
                            </h3>
                        </div><!-- dashboard-card end -->
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="dashboard-card">
                        <span>@lang('Total Deposit')</span>
                        <a class="view--btn" href="{{ route('user.deposit.history') }}">@lang('View all')</a>
                        <h3 class="number">
                            {{ $general->cur_sym . showAmount($totalDeposit) }}
                        </h3>
                        <i class="las la-dollar-sign icon"></i>
                    </div><!-- dashboard-card end -->
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="dashboard-card">
                        <span>@lang('Total Withdraw')</span>
                        <a class="view--btn" href="{{ route('user.withdraw.history') }}">@lang('View all')</a>
                        <h3 class="number">
                            {{ $general->cur_sym . showAmount($totalWithdraw) }}
                        </h3>
                        <i class="las la-hand-holding-usd icon"></i>
                    </div><!-- dashboard-card end -->
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="dashboard-card">
                        <span>@lang('Total Investment')</span>
                        <a class="view--btn" href="{{ route('user.investment.log') }}">@lang('View all')</a>
                        <h3 class="number">
                            {{ $general->cur_sym . showAmount($totalInvest) }}
                        </h3>
                        <i class="las la-dollar-sign icon"></i>
                    </div><!-- dashboard-card end -->
                </div>
            </div><!-- row end -->
            <div class="row justify-content-center gx-4 gy-5 mt-5">

                <!-- Here Attach Plans cardfrom view partial blade  -->
                @include('partials.plans_card')

            </div>
            <div class="row mt-5">
                <div class="col-lg-12">

                    <div class="table-responsive--md">
                        <h4 class="mb-3">@lang('Latest Transactions')</h4>
                        <table class="custom--table table">
                            <thead>
                                <tr>
                                    <th>@lang('Trx')</th>
                                    <th>@lang('Transacted')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Charge')</th>
                                    <th>@lang('Post Balance')</th>
                                    <th>@lang('Detail')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($latestTrx as $data)
                                    <tr>
                                        <td>{{ $data->trx }}</td>
                                        <td>
                                            {{ showDateTime($data->created_at) }}</td>

                                        <td class="budget">
                                            <span
                                                class="fw-bold @if ($data->trx_type == '+') text-success @else text-danger @endif">
                                                {{ $data->trx_type }} {{ showAmount($data->amount) }}
                                                {{ $general->cur_text }}
                                            </span>
                                        </td>

                                        <td>{{ showAmount($data->charge) }} {{ __($general->cur_text) }}</td>
                                        <td class="budget">
                                            {{ showAmount($data->post_balance) }} {{ __($general->cur_text) }}
                                        </td>
                                        <td>{{ __($data->details) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- dashboard section end -->

        <!-- Here is Buying Plan Modal Component  -->
        <x-plan-modal />

    </section>
@endsection
