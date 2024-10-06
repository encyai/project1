@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('Email')</th>
                                    <th>@lang('Phone')</th>
                                    <th>@lang('Total Deposit')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($referrals as $user)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.users.detail', $user->id) }}">{{ $user->username }}</a>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->mobile }}</td>
                                        <td>{{ getAmount($user->deposits->sum('amount')) }} {{ $general->cur_text }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center"> {{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($referrals) }}
                </div>
            </div><!-- card end -->
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <x-search-form placeholder="Username / Email" />
@endpush
