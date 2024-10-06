@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="show-filter mb-3 text-end">
                        <button type="button" class="btn btn--base showFilterBtn btn-sm"><i class="las la-filter"></i>
                            @lang('Filter')</button>
                    </div>
                    <div class="responsive-filter-card mb-4">
                        <form action="">
                            <div class="d-flex flex-wrap gap-4">
                                <div class="flex-grow-1">
                                    <label>@lang('Transaction Number')</label>
                                    <input type="search" name="search" value="{{ request()->search }}"
                                        class="form--control">
                                </div>
                                <div class="flex-grow-1">
                                    <label>@lang('Interest Type')</label>
                                    <select name="interest_type" class="form--control">
                                        <option value="">@lang('All')</option>
                                        <option value="1" @selected(request()->interest_type == 1)>@lang('Percent')</option>
                                        <option value="2" @selected(request()->interest_type == 2)>@lang('Fixed')</option>
                                    </select>
                                </div>
                                <div class="flex-grow-1">
                                    <label>@lang('Status')</label>
                                    <select name="status" class="form--control">
                                        <option value="">@lang('All')</option>
                                        <option value="2" @selected(request()->status == 2)>@lang('Running')</option>
                                        <option value="1" @selected(request()->status == 1)>@lang('Completed')</option>
                                    </select>
                                </div>
                                <div class="flex-grow-1 align-self-end">
                                    <button class="btn btn--base w-100"><i class="la la-filter"></i>
                                        @lang('Filter')</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive--md">
                        <table class="table custom--table">
                            <thead>
                                <tr>
                                    <th>@lang('Trx')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Per Return Interest')</th>
                                    <th>@lang('Interest Type')</th>
                                    <th>@lang('Total Return')</th>
                                    <th>@lang('Get Return')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Next Return Date')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($investments as $investment)
                                    <tr>
                                        <td> {{ $investment->trx }}</td>
                                        <td> {{ showAmount($investment->amount) }} {{ __($general->cur_text) }} </td>
                                        <td> {{ showAmount($investment->interest_amount) }} {{ __($general->cur_text) }}
                                        </td>
                                        <td>
                                            @if ($investment->interest_type == 1)
                                                @lang('Percent')
                                            @else
                                                @lang('Fixed')
                                            @endif
                                        </td>
                                        <td> {{ $investment->total_return }} @lang('Times')</td>
                                        <td> {{ $investment->total_paid }} @lang('Times')</td>
                                        <td> @php echo $investment->statusBadge @endphp </td>
                                        <td> {{ showDateTime($investment->next_return_date) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($investments->hasPages())
                    {{ paginateLinks($investments) }}
                @endif
            </div>
        </div>
    </section>
@endsection
