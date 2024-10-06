@extends('admin.layouts.app')

@section('panel')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Username')</th>
                                    <th>@lang('Plan')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Interest Type')</th>
                                    <th>@lang('Total Return')</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($investments as $data)

                                    <tr>
                                        <td>{{ $investments->firstItem() + $loop->index }}</td>
                                        <td>
                                            <span class="fw-bold">
                                                <a href="{{ route('admin.users.detail', $data->user_id) }}" class="text--primary">
                                                    {{ $data->user->username }} </a>
                                            </span>
                                        </td>
                                        <td class="fw-bold">{{ __($data->plan->name) }}</td>
                                        <td>
                                           {{ showAmount($data->amount) }} {{ $general->cur_text }}
                                        </td>
                                        <td>
                                            @php echo $data->statusBadge @endphp
                                        </td>
                                        <td>
                                           {{ $data->total_return }} . @lang('Times')
                                        </td>
                                        

                                       
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table><!-- table end -->
                    </div>
                </div>

                @if($investments->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($investments) }}
                </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
   
@endsection

@push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end align-items-center has-search-form">
        <x-search-form placeholder="Search By Plan/Username"/>
    </div>
@endpush


