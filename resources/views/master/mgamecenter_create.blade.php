@extends('layouts.app')

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <a href="{{url('/mgcenter')}}">
                    <button type="button" class="btn btn-warning" title="">Back</button>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                @if (!empty($data))
                    <h5>Edit Game Center</h5>
                @else
                    <h5>Create New Game Center</h5>
                @endif
            </div>
            <div class="card-block table-border-style">
                @if(empty($data))
                    @php($type= 'store')
                @else
                    @php($type= 'update')
                @endif
                <form method="POST" action="{{url('/mgcenter')}}/{{$type}}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Game Center Name</label>
                            <input type="text" class="form-control" name="name"
                                   @if (!empty($data))
                                   value="{{$data->name}}"
                                @endif
                            >
                        </div>
                        <div class="form-group">
                            @if(!empty($data))
                                <img class='img-fluid img-thumbnail' src='{{$data->getImage()}}'
                            @endif
                            <label for="image">Upload Banner Image ( Resolution 100px x 100px )</label>
                            <input type="file" class="form-control-file" id="image" name="image">

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Branch</label>
                        </div>
                        <div class="branch-body">

                        </div>
                        <span class="btn btn-info main-branch-add">Add Branch</span>
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
    <div class="d-none main-branch-clone">
        <div class="card">
            <div class="card-header d-flex">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Main Branch Name</label>
                        <input type="text" class="form-control branch_name" name="branch_name[]"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <span class='fa fa-fw fa-times fa-pull-right pointer main-branch-close'></span>
                    <br>
                    <span class="btn btn-info fa-pull-right sub-branch-add">Add Sub Branch</span>
                    <input type="hidden" name="branch_index[]" class="branch_index" value="idxku">
                </div>
            </div>
            <div class="card-block table-border-style sub-branch-body">
                <div class="card">
                    <div class="card-header">
                        <span class='fa fa-fw fa-times fa-pull-right pointer sub-branch-close'></span>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sub Branch Name</label>
                                <input type="text" class="form-control" name="subbranch_location[idxku][]"/>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="subbranch_name[idxku][]"/>
                            </div>
                            <div class="form-group">
                                <label for="image">Upload Banner Image ( Resolution 100px x 100px
                                    )</label>
                                <input type="file" class="form-control-file" id="image" name="subbranch_image[idxku][]">
                            </div>
                            <div class="form-group">
                                <label for="image">Article Body</label>
                                <textarea id="wsiwygcounter" name="subbranch_content[idxku][]"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-none sub-branch-clone">
        <div class="card">
            <div class="card-header">
                <span class='fa fa-fw fa-times fa-pull-right pointer sub-branch-close'></span>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sub Branch Name</label>
                        <input type="text" class="form-control" name="subbranch_location[idxke][]"/>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="subbranch_name[idxke][]"/>
                    </div>
                    <div class="form-group">
                        <label for="image">Upload Banner Image ( Resolution 100px x 100px
                            )</label>
                        <input type="file" class="form-control-file" id="image" name="subbranch_image[idxke][]">
                    </div>
                    <div class="form-group">
                        <label for="image">Article Body</label>
                        <textarea id="wsiwygcounter" name="subbranch_content[idxke][]"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#order').val($('#order_value').val());
        });
    </script>
@endsection



@section('injectscript')
    <script src="{{url('assets/js/tinymce/tinymce.min.js')}}"></script>
    <script>
        var counter = 0;
        var wsiwygcounter = 0;
        $(document).ready(function () {

            $('#order').val($('#order_value').val());
        });
        $(document).on("click", ".main-branch-close", function () {
            $(this).parent().parent().parent().remove();
        });
        $(document).on("click", ".sub-branch-close", function () {
            $(this).parent().parent().remove();
        });
        $(document).on("click", ".sub-branch-add", function () {
            var indexku = $(this).parent().find('.branch_index').val();
            var content = $('.sub-branch-clone').html().replace(/idxke/g, indexku).replace('wsiwygcounter', 'wsiwyg' + wsiwygcounter);
            $(this).parent().parent().parent().find('.sub-branch-body').append(content);
            initEditor('#wsiwyg' + wsiwygcounter);
            wsiwygcounter++;
        });
        $(document).on("click", ".main-branch-add", function () {
            $('.branch-body').append($('.main-branch-clone').html().replace(/idxku/g, 'idxku' + counter).replace('wsiwygcounter', 'wsiwyg' + wsiwygcounter));
            counter++;
            initEditor('#wsiwyg' + wsiwygcounter);
            wsiwygcounter++;
        });

        function initEditor(pointer) {
            tinymce.init({
                selector: pointer,
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
                toolbar: 'undo redo | styleselect | code bold italic | alignleft aligncenter alignright alignjustify | ' +
                    'bullist numlist outdent indent | link | print preview media fullpage | ' +
                    'forecolor backcolor emoticons | help',
                menu: {},
                menubar: 'file edit insert format ',
                // menubar: 'file edit view insert format tools table help',
                content_css: 'css/content.css'
            });
        }
    </script>
@endsection

