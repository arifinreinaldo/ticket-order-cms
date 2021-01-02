@extends('layouts.app')

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <a href="{{url('/mconfiguration')}}">
                    <button type="button" class="btn btn-warning" title="">Back</button>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                @if (!empty($data))
                    <h5>Edit Social Media</h5>
                @else
                    <h5>Create New Social Media</h5>
                @endif
            </div>
            <div class="card-block table-border-style">
                @if(empty($data))
                    @php($type= 'store')
                @else
                    @php($type= 'update')
                @endif
                <form method="POST" action="{{url('/mconfiguration')}}/{{$type}}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Social Media Name</label>
                            <input type="text" class="form-control" name="name"
                                   @if (!empty($data))
                                   value="{{$data->name}}"
                                @endif
                            >
                        </div>
                        <div class="form-group">
                            <label for="image">Social Media Icon</label>
                            <input type="file" class="form-control-file" id="image" name="icon">

                        </div>

                        <div class="form-group">
                            <label>Social Media Link</label>
                            <input type="text" class="form-control" name="link"
                                   @if (!empty($data))
                                   value="{{$data->link}}"
                                @endif
                            >
                        </div>
                        <div class="form-group">
                            <label>Social Media Order</label>
                            <select class="form-control selectpicker"
                                    id="order"
                                    name="order"
                                    data-live-search="true">
                                <option value="">Select Order</option>
                                @for ($i = 1; $i <= $size; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                                @if(empty($data))
                                    @php($value= $size)
                                @else
                                    @php($value = $data->order)
                                @endif
                                <input type="hidden" id="order_value" value="{{$value}}">
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        @if (!empty($data))
                            <input type="hidden" name="id" value="{{$data->id}}">
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#order').val($('#order_value').val());
        });
    </script>
@endsection

