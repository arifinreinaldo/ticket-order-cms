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
                <form method="POST" id="formAction" action="{{url('/mgcenter')}}/{{$type}}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Game Center Name</label>
                            <input type="text" class="form-control" name="name" id="gcName"
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
                            @if(!empty($data))
                                <input type="file" class="form-control-file" id="gcImage" name="image"
                                       srcImage="{{$data->image}}">
                            @else
                                <input type="file" class="form-control-file" id="gcImage" name="image" srcImage="">
                            @endif

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Branch</label>
                        </div>
                        <div class="branch-body">
                            @if(!empty($data))
                                @foreach($data->getLocation as $location)
                                    <div class="card">
                                        <div class="card-header d-flex">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Main Branch Name</label>
                                                    <input type="text" class="form-control branch_name"
                                                           value="{{$location->name}}"
                                                           name="branch_name[]"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                            <span
                                                class='fa fa-fw fa-times fa-pull-right pointer main-branch-close'></span>
                                                <br>
                                                <span
                                                    class="btn btn-info fa-pull-right sub-branch-add">Add Sub Branch</span>
                                                <input type="hidden" name="branch_index[]" class="branch_index"
                                                       value="savedata{{$location->id}}">
                                                <input type="hidden" name="location_id[]" class="location_id"
                                                       value="{{$location->id}}">
                                            </div>
                                        </div>
                                        <div class="card-block table-border-style sub-branch-body">
                                            @foreach($location->getBranch as $branch)
                                                <div class="card">
                                                    <div class="card-header">
                                                    <span
                                                        class='fa fa-fw fa-times fa-pull-right pointer sub-branch-close'
                                                        branch_id="{{$branch->id}}"></span>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Sub Branch Name</label>
                                                                <input type="text" class="form-control sub_branch_name"
                                                                       value="{{$branch->name}}"
                                                                       name="subbranch_location[savedata{{$location->id}}][]"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Title</label>
                                                                <input type="text" class="form-control sub_branch_title"
                                                                       value="{{$branch->title}}"
                                                                       name="subbranch_name[savedata{{$location->id}}][]"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <img class='img-fluid img-thumbnail'
                                                                     src='{{$branch->getImage()}}'/>
                                                                <label for="image">Upload Banner Image ( Resolution
                                                                    100px x
                                                                    100px
                                                                    )</label>
                                                                <input type="file"
                                                                       srcImage="{{$branch->image}}"
                                                                       class="form-control-file sub_branch_image"
                                                                       id="image"
                                                                       name="subbranch_image[savedata{{$location->id}}][]">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="image">Article Body</label>
                                                                <textarea
                                                                    id="savedata{{$branch->id}}"
                                                                    class="wsiwyg sub_branch_content"
                                                                    name="subbranch_content[savedata{{$location->id}}][]">{{$branch->content}}</textarea>
                                                            </div>
                                                            <input type="hidden"
                                                                   name="branch_id[savedata{{$location->id}}][]"
                                                                   class="branch_id"
                                                                   value="{{$branch->id}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <span class="btn btn-info main-branch-add">Add Branch</span>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="btnSubmit">Submit</button>
                        </div>
                        @if (!empty($data))
                            <input type="hidden" name="id" value="{{$data->id}}">
                        @endif
                        <div class="location_delete_div">

                        </div>
                        <div class="branch_delete_div">

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
                        <label>Main Branch Name</label>
                        <input type="text" class="form-control branch_name" name="branch_name[]"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <span class='fa fa-fw fa-times fa-pull-right pointer main-branch-close'></span>
                    <br>
                    <span class="btn btn-info fa-pull-right sub-branch-add">Add Sub Branch</span>
                    <input type="hidden" name="branch_index[]" class="branch_index" value="idxku">
                    <input type="hidden" name="location_id[]" class="location_id" value="-1">
                </div>
            </div>
            <div class="card-block table-border-style sub-branch-body">
                <div class="card">
                    <div class="card-header">
                        <span class='fa fa-fw fa-times fa-pull-right pointer sub-branch-close' branch_id="-1"></span>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sub Branch Name</label>
                                <input type="text" class="form-control sub_branch_name"
                                       name="subbranch_location[idxku][]"/>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control sub_branch_title"
                                       name="subbranch_name[idxku][]"/>
                            </div>
                            <div class="form-group">
                                <label for="image">Upload Banner Image ( Resolution 100px x 100px
                                    )</label>
                                <input type="file" class="form-control-file sub_branch_image" id="image"
                                       name="subbranch_image[idxku][]"
                                       srcImage="">
                            </div>
                            <div class="form-group">
                                <label for="image">Article Body</label>
                                <textarea id="wsiwygcounter" class="sub_branch_content"
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
    <div class="d-none sub-branch-clone">
        <div class="card">
            <div class="card-header">
                <span class='fa fa-fw fa-times fa-pull-right pointer sub-branch-close' branch_id="-1"></span>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sub Branch Name</label>
                        <input type="text" class="form-control sub_branch_name" name="subbranch_location[idxke][]"/>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control sub_branch_title" name="subbranch_name[idxke][]"/>
                    </div>
                    <div class="form-group">
                        <label for="image">Upload Banner Image ( Resolution 100px x 100px
                            )</label>
                        <input type="file" class="form-control-file sub_branch_image" id="image"
                               name="subbranch_image[idxke][]" srcImage="">
                    </div>
                    <div class="form-group">
                        <label for="image">Article Body</label>
                        <textarea id="wsiwygcounter" class="sub_branch_content"
                                  name="subbranch_content[idxke][]"></textarea>
                    </div>
                    <input type="hidden" name="branch_id[idxke][]" class="branch_id"
                           value="-1">
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
            initEditor('.wsiwyg');
            $('#order').val($('#order_value').val());
        });
        $(document).on("click", "#btnSubmit", function (e) {
            e.preventDefault();
            var msg = "<ul>";
            if ($('#gcName').val() == "") {
                msg += "<li> Game center name is required";
            }
            if ($('#gcImage').get(0).files.length == 0 && $('#gcImage').attr('srcImage') == "") {
                msg += "<li> Game center banner is required";
            }
            var countBranchName = 0;
            $('.branch-body').find('.branch_name').each(function (idx) {
                countBranchName++;
                if ($(this).val() == "") {
                    msg += "<li> Game center main branch name is required";
                }
                var countSubBranch = 0;
                $(this).parent().parent().parent().parent().find('.sub-branch-body').find('.card').each(function (idxBranch) {
                    countSubBranch++;
                    if ($(this).find('.sub_branch_name').val() == "") {
                        msg += "<li> Game center sub branch name is required";
                    }
                    if ($(this).find('.sub_branch_title').val() == "") {
                        msg += "<li> Game center sub branch title is required";
                    }
                    if ($(this).find('.sub_branch_image').get(0).files.length == 0 && $(this).find('.sub_branch_image').attr('srcImage') == "") {
                        msg += "<li> Game center sub branch banner is required";
                    }
                    var tinyid = $(this).find('.sub_branch_content').attr('id');
                    if (tinymce.get(tinyid).getContent().trim() == "") {
                        msg += "<li> Game center sub branch content is required";
                    }
                });
                if (countSubBranch == 0) {
                    msg += "<li> Game center main branch requires minimum sub 1 branch";
                }
            });
            if (countBranchName == 0) {
                msg += "<li> Game center requires minimum 1 branch";
            }
            msg += "</ul>";
            if (msg.includes('li')) {
                showMessage(msg);
            } else {
                hideMessage();
                $('#formAction').submit();
            }
        });
        $(document).on("click", ".main-branch-close", function () {
            $(this).parent().parent().parent().remove();
            var id = $(this).siblings('.location_id').val();
            if (id != -1) {
                $('.location_delete_div').append('<input type="hidden" name="location_id_delete[]" value="' + id + '">');
            }
        });
        $(document).on("click", ".sub-branch-close", function () {
            $(this).parent().parent().remove();
            var id = $(this).attr('branch_id');
            if (id != -1) {
                $('.branch_delete_div').append('<input type="hidden" name="branch_id_delete[]" value="' + id + '">');
            }
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

