@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @include($activeTemplate . 'partials.referral_link')
                    <div class="table-responsive--md mt-5">
                        <table class="table custom--table">
                            <thead>
                                <tr>
                                    <th>@lang('Username')</th>
                                    <th>@lang('Email')</th>
                                    <th>@lang('Phone')</th>
                                    <th>@lang('Total Deposit')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($referrals as $user)
                                    <tr>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->mobile }}</td>
                                        <td>{{ getAmount($user->deposits->sum('amount')) }} {{ $general->cur_text }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center"> {{ $emptyMessage }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($referrals->hasPages())
                        {{ paginateLinks($referrals) }}
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
