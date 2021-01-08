@extends('layouts.app')
@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <a href="{{url('/mridecategory')}}">
                    <button type="button" class="btn btn-warning" title="">Back</button>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5>Edit Rides</h5>
            </div>
            <div class="card-block table-border-style">
                @if(empty($data))
                    @php($type= 'store')
                @else
                    @php($type= 'update')
                @endif
                <form method="POST" action="{{url('/mridecategory')}}/{{$type}}" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <div class="branch-body">
                            @foreach($data as $datum)

                            @endforeach
                        </div>
                        <span class="btn btn-info category-add">Add Category</span>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <input type="hidden" name="game_center_id" value="{{$id}}">
                        </div>
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
                        <label>Main Title</label>
                        <input type="text" class="form-control category_name" name="category_name[]"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <span class='fa fa-fw fa-times fa-pull-right pointer category-close'></span>
                    <br>
                    <span class="btn btn-info fa-pull-right sub-category-add">Add Rides</span>
                    <input type="hidden" name="branch_index[]" class="branch_index" value="idxku">
                    <input type="hidden" name="category_id[]" class="category_id" value="-1">
                </div>
            </div>
            <div class="card-block table-border-style sub-branch-body">
                <div class="card">
                    <div class="card-header">
                        <span class='fa fa-fw fa-times fa-pull-right pointer sub-category-close'
                              sub_category_id="-1"></span>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control sub_category_title"
                                       name="subbranch_name[idxku][]"/>
                            </div>
                            <div class="form-group">
                                <label for="image">Upload Cover Image ( Resolution 100px x 100px
                                    )</label>
                                <input type="file" class="form-control-file sub_category_cover" id="cover"
                                       name="subbranch_branch[idxku][]"
                                       srcImage="">
                            </div>
                            <div class="form-group">
                                <label for="image">Upload Banner Image ( Resolution 100px x 100px
                                    )</label>
                                <input type="file" class="form-control-file sub_category_image" id="image"
                                       name="subbranch_image[idxku][]"
                                       srcImage="">
                            </div>
                            <div class="form-group">
                                <label for="image">Body Content</label>
                                <textarea id="wsiwygcounter" class="sub_category_content"
                                          name="subbranch_content[idxku][]"></textarea>
                            </div>
                            <input type="hidden" name="branch_id[idxku][]" class="branch_id"
                                   value="-1">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('injectstyle')
@endsection
@section('injectscript')
    <script src="{{url('assets/js/tinymce/tinymce.min.js')}}"></script>
    <script>
        var counter = 0;
        var wsiwygcounter = 0;
        $(document).ready(function () {

        });
        $(document).on("click", ".category-add", function () {
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
