@extends('layouts.app')

@section('content')
    <div class="col-xl-12">
        <div class="card">
            {{--            <div class="card-header">--}}
            {{--                <h5>Activity Log</h5>--}}
            {{--            </div>--}}
            <div class="card-block table-border-style">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <li><a class="nav-link text-left {{$activity}}" id="v-pills-settings-tab"
                                   href="{{url('/mactivity')}}" role="tab">Activity Trail</a></li>
                            <li><a class="nav-link text-left {{$error}}" id="v-pills-messages-tab"
                                   href="{{url('/mactivity/display/error')}}" role="tab">Error
                                    Log</a></li>
                        </ul>
                    </div>
                    <div class="col-md-9 col-sm-12">
                        <div class="tab-content" id="v-pills-tabContent">
                            @if($activities->count()==0)
                                <div class="row">
                                    <div class="col">
                                    </div>
                                    <div class="col">
                                        <span class='fa fa-4x text-c-red fa-times-circle ml-3'></span>
                                        <h3 class="text-c-red ">No Data</h3>
                                    </div>
                                    <div class="col">
                                    </div>
                                </div>
                            @else
                                <div class="scrolling-pagination">
                                    @php($now = \Carbon\Carbon::now())
                                    @foreach($activities as $activity)
                                        <div class="d-flex">
                                            <div class="mr-3 mt-4">
                                                <span class='fa fa-2x fa-fw fa-clock'/>
                                            </div>
                                            <div class="w-100 card p-3">
                                                <div>
                                                    @php($time = \Carbon\Carbon::parse($activity->updated_at))
                                                    @if($time->diff($now)->days <  1)
                                                        {{$time->diffForHumans()}}
                                                    @else
                                                        {{$time->format('d M Y')}}
                                                    @endif
                                                </div>
                                                <div>
                                                    {{$activity->exception}}
                                                </div>
{{--                                                <div><b>{{$activity->name}}</b> has {{$activity->description}} data--}}
{{--                                                    <b>{{$activity->log_name}}</b></div>--}}
                                            </div>
                                        </div>
                                    @endforeach
                                    {{ $activities->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js" defer></script>
        <script>
            var table = "";
            $(document).ready(function () {
                $('.scrolling-pagination ul.pagination').hide();
                $('.scrolling-pagination').jscroll({
                    autoTrigger: true,
                    padding: 0,
                    nextSelector: 'ul.pagination li.active + li a',
                    contentSelector: 'div.scrolling-pagination',
                    callback: function () {
                        $('.scrolling-pagination ul.pagination').remove();
                    }
                });
            });
        </script>
@endsection

