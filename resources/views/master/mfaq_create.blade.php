@extends('layouts.app')
@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <a href="{{url('/mstatic')}}">
                    <button type="button" class="btn btn-warning" title="">Back</button>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                @if (!empty($data))
                    <h5>Edit FAQ</h5>
                @else
                    <h5>Create New FAQ</h5>
                @endif
            </div>
            <div class="card-block table-border-style">
                @if(empty($data))
                    @php($type= 'store')
                @else
                    @php($type= 'update')
                @endif
                <form method="POST" action="{{url('/mfaq')}}/{{$type}}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Question</label>
                            <input type="text" class="form-control" name="question"
                                   @if (!empty($data))
                                   value="{{$data->question}}"
                                @endif
                            >
                        </div>
                        <div class="form-group">
                            <textarea id="wsiwyg" name="answer">
                                @if (!empty($data))
                                    {{$data->answer}}
                                @endif
                            </textarea>
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
@endsection
@section('injectstyle')
@endsection
@section('injectscript')
    <script src="{{url('assets/js/tinymce/tinymce.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            tinymce.init({
                selector: '#wsiwyg',
                width: 700,
                height: 350,
                plugins: [
                    'advlist autolink link lists charmap print preview hr ',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    ' paste'
                ],
                // plugins: [
                //     'advlist autolink link image lists charmap print preview hr anchor pagebreak',
                //     'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                //     'table emoticons template paste help'
                // ],
                toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
                    'bullist numlist outdent indent | link image | print preview media fullpage | ' +
                    'forecolor backcolor emoticons | help',
                menu: {},
                menubar: 'file edit insert format ',
                // menubar: 'file edit view insert format tools table help',
                content_css: 'css/content.css'
            });
        });
    </script>
@endsection
