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
                <h5>Edit {{$data->name}} Rides</h5>
            </div>
            <div class="card-block table-border-style">
                @if(empty($data))
                    @php($type= 'store')
                @else
                    @php($type= 'update')
                @endif
                <form method="POST" id="formAction" action="{{url('/mridecategory')}}/{{$type}}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="category_delete_div">

                    </div>
                    <div class="sub_category_delete_div">

                    </div>
                    <div class="sub_category_item_delete_div">

                    </div>
                    <div class="col-md-12">
                        <div class="branch-body">
                            @if(!empty($data))
                                @foreach($data->getCategory as $datum)
                                    <div class="card">
                                        <div class="card-header d-flex">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Main Title</label>
                                                    <input type="text" class="form-control category_name"
                                                           value="{{$datum->name}}"
                                                           name="category_name[]"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <span class='fa fa-fw fa-times fa-pull-right pointer category-close'
                                                      category_id="{{$datum->id}}"></span>
                                                <br>
                                                <span
                                                    class="btn btn-info fa-pull-right sub-category-add">Add Rides</span>
                                                <input type="hidden" name="branch_index[]" class="branch_index"
                                                       value="savedidxku{{$datum->id}}">
                                                <input type="hidden" name="category_id[]" class="category_id"
                                                       value="{{$datum->id}}">
                                            </div>
                                        </div>
                                        <div class="card-block table-border-style sub-branch-body">
                                            @foreach($datum->getRide as $ride)
                                                <div class="card">
                                                    <div class="card-header">
                        <span class='fa fa-fw fa-times fa-pull-right pointer sub-category-close'
                              sub_category_id="{{$ride->id}}"></span>
                                                        <div class="col-md-11">
                                                            <div class="col-md-7">
                                                                <div class="form-group">
                                                                    <label>Title</label>
                                                                    <input type="text"
                                                                           value="{{$ride->name}}"
                                                                           class="form-control sub_category_title"
                                                                           name="subbranch_name[savedidxku{{$datum->id}}][]"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <img class='img-fluid img-thumbnail'
                                                                         src='{{$ride->getCover()}}'/>
                                                                    <label for="image">Upload Cover Image ( Resolution
                                                                        100px
                                                                        x 100px
                                                                        )</label>
                                                                    <input type="file"
                                                                           class="form-control-file sub_category_cover"
                                                                           id="cover"
                                                                           name="subbranch_cover[savedidxku{{$datum->id}}][]"
                                                                           srcImage="{{$ride->cover}}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Format Type</label>
                                                                    <select class="form-control format_type"
                                                                            name="subbranch_type[savedidxku{{$datum->id}}][]"
                                                                            vindex="savedidxku{{$datum->id}}">
                                                                        <option value="1"
                                                                                @if($ride->type==1) selected @endif>
                                                                            Single Content
                                                                        </option>
                                                                        <option value="2"
                                                                                @if($ride->type==2) selected @endif>
                                                                            Multiple Content
                                                                        </option>
                                                                        <input type="hidden" id="role_value" value="-1">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="subcategory-body">
                                                                @if($ride->type==1)
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <img class='img-fluid img-thumbnail'
                                                                                 src='{{$ride->getBanner()}}'/>
                                                                            <label for="image">Upload Banner Image (
                                                                                Resolution
                                                                                100px x 100px
                                                                                )</label>
                                                                            <input type="file"
                                                                                   class="form-control-file sub_category_image"
                                                                                   id="image"
                                                                                   name="subbranch_banner[savedidxku{{$datum->id}}][]"
                                                                                   srcImage="{{$ride->banner}}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="image">Body Content</label>
                                                                            <textarea id="wsiwygcounter"
                                                                                      class="sub_category_content wsiwyg"
                                                                                      name="subbranch_content[savedidxku{{$datum->id}}][]">{{$ride->content}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    @foreach($ride->getDetail as $detail)
                                                                        <div class="card">
                                                                            <div class="card-header">
            <span class='fa fa-fw fa-times fa-pull-right pointer sub-category-item-close'
                  sub_category_item_id="{{$detail->id}}"></span>
                                                                                <div class="col-md-7">
                                                                                    <div class="form-group">
                                                                                        <label>Title</label>
                                                                                        <input type="text"
                                                                                               value="{{$detail->name}}"
                                                                                               class="form-control sub_category_multi_title"
                                                                                               name="sub_category_multi_title[savedidxku{{$datum->id}}][savedidxmu{{$ride->id}}][]"/>
                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <img
                                                                                            class='img-fluid img-thumbnail'
                                                                                            src='{{$detail->getImage()}}'/>
                                                                                        <label for="image">Upload Banner
                                                                                            Image ( Resolution 100px x
                                                                                            100px
                                                                                            )</label>
                                                                                        <input type="file"
                                                                                               class="form-control-file sub_category_multi_banner"
                                                                                               id="image"
                                                                                               name="sub_category_multi_banner[savedidxku{{$datum->id}}][savedidxmu{{$ride->id}}][]"
                                                                                               srcImage="{{$detail->image}}">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="image">Body
                                                                                            Content</label>
                                                                                        <textarea id="wsiwygcounter"
                                                                                                  class="sub_category_multi_content wsiwyg"
                                                                                                  name="sub_category_multi_content[savedidxku{{$datum->id}}][savedidxmu{{$ride->id}}][]">{{$detail->content}}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden"
                                                                                       name="sub_category_multi_id[savedidxku{{$datum->id}}][savedidxmu{{$ride->id}}][]"
                                                                                       value="{{$detail->id}}">
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <span class="btn btn-info add-subcategory-item m-3"
                                                                  vindex="savedidxmu{{$ride->id}}"
                                                                  bindex="savedidxku{{$datum->id}}"
                                                                  @if($ride->type==1)style="display: none"@endif>Add More</span>
                                                            <input type="hidden"
                                                                   name="branch_id[savedidxku{{$datum->id}}][]"
                                                                   class="branch_id"
                                                                   value="{{$ride->id}}">
                                                            <input type="hidden"
                                                                   name="key_id[savedidxku{{$datum->id}}][]"
                                                                   class="key_id"
                                                                   value="savedidxmu{{$ride->id}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <span class="btn btn-info category-add">Add Category</span>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btnSubmit">Submit</button>
                            <input type="hidden" name="game_center_id" value="{{$data->id}}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="d-none single-content-clone">
        <div class="col-md-6">
            <div class="form-group">
                <label for="image">Upload Banner Image ( Resolution 100px x 100px
                    )</label>
                <input type="file" class="form-control-file sub_category_image" id="image"
                       name="subbranch_banner[idxku][]"
                       srcImage="">
            </div>
            <div class="form-group">
                <label for="image">Body Content</label>
                <textarea id="wsiwygcounter" class="sub_category_content"
                          name="subbranch_content[idxku][]"></textarea>
            </div>
        </div>
    </div>

    <div class="d-none multi-content-clone">
        <div class="card">
            <div class="card-header">

            <span class='fa fa-fw fa-times fa-pull-right pointer sub-category-item-close'
                  sub_category_item_id="-1"></span>
                <div class="col-md-7">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control sub_category_multi_title"
                               name="sub_category_multi_title[idxku][idxmu][]"/>
                    </div>

                    <div class="form-group">
                        <label for="image">Upload Banner Image ( Resolution 100px x 100px
                            )</label>
                        <input type="file" class="form-control-file sub_category_multi_banner" id="image"
                               name="sub_category_multi_banner[idxku][idxmu][]"
                               srcImage="">
                    </div>
                    <div class="form-group">
                        <label for="image">Body Content</label>
                        <textarea id="wsiwygcounter" class="sub_category_multi_content"
                                  name="sub_category_multi_content[idxku][idxmu][]"></textarea>
                    </div>
                </div>
                <input type="hidden" name="sub_category_multi_id[idxku][idxmu][]" value="-1">
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
                    <span class='fa fa-fw fa-times fa-pull-right pointer category-close' category_id="-1"></span>
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
                        <div class="col-md-11">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control sub_category_title"
                                           name="subbranch_name[idxku][]"/>
                                </div>
                                <div class="form-group">
                                    <label for="image">Upload Cover Image ( Resolution 100px x 100px
                                        )</label>
                                    <input type="file" class="form-control-file sub_category_cover" id="cover"
                                           name="subbranch_cover[idxku][]"
                                           srcImage="">
                                </div>
                                <div class="form-group">
                                    <label>Format Type</label>
                                    <select class="form-control format_type" name="subbranch_type[idxku][]"
                                            vindex="idxku">
                                        <option value="1" selected>Single Content</option>
                                        <option value="2">Multiple Content</option>
                                        <input type="hidden" id="role_value" value="-1">
                                    </select>
                                </div>
                            </div>
                            <div class="subcategory-body">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Upload Banner Image ( Resolution 100px x 100px
                                            )</label>
                                        <input type="file" class="form-control-file sub_category_image" id="image"
                                               name="subbranch_banner[idxku][]"
                                               srcImage="">
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Body Content</label>
                                        <textarea id="wsiwygcounter" class="sub_category_content"
                                                  name="subbranch_content[idxku][]"></textarea>
                                    </div>
                                </div>
                            </div>
                            <span class="btn btn-info add-subcategory-item m-3" style="display: none">Add More</span>
                            <input type="hidden" name="branch_id[idxku][]" class="branch_id"
                                   value="-1">
                            <input type="hidden" name="key_id[idxku][]" class="key_id"
                                   value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-none sub-branch-clone">
        <div class="card">
            <div class="card-header">
                        <span class='fa fa-fw fa-times fa-pull-right pointer sub-category-close'
                              sub_category_id="-1"></span>
                <div class="col-md-11">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control sub_category_title"
                                   name="subbranch_name[idxku][]"/>
                        </div>
                        <div class="form-group">
                            <label for="image">Upload Cover Image ( Resolution 100px x 100px
                                )</label>
                            <input type="file" class="form-control-file sub_category_cover" id="cover"
                                   name="subbranch_cover[idxku][]"
                                   srcImage="">
                        </div>
                        <div class="form-group">
                            <label>Format Type</label>
                            <select class="form-control format_type" name="subbranch_type[idxku][]"
                                    vindex="idxku">
                                <option value="1" selected>Single Content</option>
                                <option value="2">Multiple Content</option>
                                <input type="hidden" id="role_value" value="-1">
                            </select>
                        </div>
                    </div>
                    <div class="subcategory-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Upload Banner Image ( Resolution 100px x 100px
                                    )</label>
                                <input type="file" class="form-control-file sub_category_image" id="image"
                                       name="subbranch_banner[idxku][]"
                                       srcImage="">
                            </div>
                            <div class="form-group">
                                <label for="image">Body Content</label>
                                <textarea id="wsiwygcounter" class="sub_category_content"
                                          name="subbranch_content[idxku][]"></textarea>
                            </div>
                        </div>
                    </div>
                    <span class="btn btn-info add-subcategory-item m-3" style="display: none">Add More</span>
                    <input type="hidden" name="branch_id[idxku][]" class="branch_id"
                           value="-1">
                    <input type="hidden" name="key_id[idxku][]" class="key_id"
                           value="">
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
        var rideitem = 0;
        $(document).ready(function () {
            initEditor(".wsiwyg");
            if ($('.branch-body').children().length == 0) {
                addMainBranch();
            }
        });

        function addMainBranch() {
            var wsiwyg = 'wsiwyg' + wsiwygcounter;
            $('.branch-body').append($('.main-branch-clone').html().replace(/idxku/g, 'idxku' + counter).replace('wsiwygcounter', wsiwyg));
            counter++;
            initEditor('#' + wsiwyg);
            wsiwygcounter++;
        }

        $(document).on("click", ".category-add", function () {
            addMainBranch()
        });
        $(document).on("click", ".sub-category-add", function () {
            var indexku = $(this).parent().find('.branch_index').val();
            var content = $('.sub-branch-clone').html().replace(/idxku/g, indexku).replace('wsiwygcounter', 'wsiwyg' + wsiwygcounter);
            $(this).parent().parent().parent().find('.sub-branch-body').append(content);
            initEditor('#wsiwyg' + wsiwygcounter);
            wsiwygcounter++;
        });
        $(document).on('click', '.add-subcategory-item', function () {
            $(this).siblings('.subcategory-body').append($('.multi-content-clone').html().replace('wsiwygcounter', 'wsiwyg' + wsiwygcounter).replace(/idxmu/g, $(this).attr('vindex')).replace(/idxku/g, $(this).attr('bindex')));
            initEditor('#wsiwyg' + wsiwygcounter);
            wsiwygcounter++;


        });
        $(document).on("change", '.format_type', function () {
            var body = $(this).parent().parent().siblings('.subcategory-body');
            body.children().remove();
            if ($(this).val() == "1") {
                body.html($('.single-content-clone').html().replace(/idxku/g, $(this).attr('vindex')).replace('wsiwygcounter', 'wsiwyg' + wsiwygcounter));
                initEditor('#wsiwyg' + wsiwygcounter);
                wsiwygcounter++;
                body.siblings('.add-subcategory-item').hide();
            } else {
                var idxmu = "idxmu" + rideitem;
                var bindex = $(this).attr('vindex');
                body.html($('.multi-content-clone').html().replace(/idxku/g, bindex).replace(/idxmu/g, idxmu).replace('wsiwygcounter', 'wsiwyg' + wsiwygcounter));
                initEditor('#wsiwyg' + wsiwygcounter);
                rideitem++;
                wsiwygcounter++;
                body.siblings('.key_id').val(idxmu);
                body.siblings('.add-subcategory-item').attr('vindex', idxmu).attr('bindex', bindex).show();
            }
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

        $(document).on('click', '.btnSubmit', function (e) {
            e.preventDefault();
            var msg = "<ul>";
            var countBranchName = 0;
            $('.branch-body').find('.category_name').each(function () {
                countBranchName++;
                if ($(this).val() == "") {
                    msg += "<li> Main title name is required";
                }
                var countSubBranch = 0;
                $(this).parent().parent().parent().siblings('.sub-branch-body').children('.card').each(function () {
                    countSubBranch++;
                    if ($(this).find('.sub_category_title').val() == "") {
                        msg += "<li> Ride title name is required";
                    }
                    if ($(this).find('.sub_category_cover').get(0).files.length == 0 && $(this).find('.sub_category_cover').attr('srcImage') == "") {
                        msg += "<li> Ride cover is required";
                    }
                    if ($(this).find('.format_type').val() == 1) {
                        if ($(this).find('.sub_category_image').get(0).files.length == 0 && $(this).find('.sub_category_image').attr('srcImage') == "") {
                            msg += "<li> Ride image is required";
                        }
                        var tinyid = $(this).find('.sub_category_content').attr('id');
                        if (tinymce.get(tinyid).getContent().trim() == "") {
                            msg += "<li> Ride content is required";
                        }
                    } else {
                        var subBranchItem = 0;
                        $(this).find('.subcategory-body').children('.card').each(function () {
                            subBranchItem++;
                            if ($(this).find('.sub_category_multi_title').val() == "") {
                                msg += "<li> Article title is required";
                            }
                            if ($(this).find('.sub_category_multi_banner').get(0).files.length == 0 && $(this).find('.sub_category_multi_banner').attr('srcImage') == "") {
                                msg += "<li> Article image is required";
                            }
                            var tinyid = $(this).find('.sub_category_multi_content').attr('id');
                            if (tinymce.get(tinyid).getContent().trim() == "") {
                                msg += "<li> Article content is required";
                            }

                        });
                        if (subBranchItem == 0) {
                            msg += "<li> Minimum 1 content is required per ride";
                        }
                    }
                });
                if (countBranchName == 0) {
                    msg += "<li> Minimum 1 ride is required per category";
                }
            });
            if (countBranchName == 0) {
                msg += "<li> Rides requires minimum 1 category";
            }
            msg += "</ul>";
            if (msg.includes('li')) {
                showMessage(msg);
            } else {
                hideMessage();
                $('#formAction').submit();
            }
        });
        $(document).on("click", ".category-close", function () {
            $(this).parent().parent().parent().remove();
            var id = $(this).attr('category_id');
            if (id != -1) {
                $('.category_delete_div').append('<input type="hidden" name="category_delete[]" value="' + id + '">');
            }
        });
        $(document).on("click", ".sub-category-close", function () {
            $(this).parent().parent().remove();
            var id = $(this).attr('sub_category_id');
            if (id != -1) {
                $('.sub_category_delete_div').append('<input type="hidden" name="sub_category_delete[]" value="' + id + '">');
            }
        });
        $(document).on("click", ".sub-category-item-close", function () {
            $(this).parent().parent().remove();
            var id = $(this).attr('sub_category_item_id');
            if (id != -1) {
                $('.sub_category_item_delete_div').append('<input type="hidden" name="sub_category_item_delete[]" value="' + id + '">');
            }
        });
    </script>
@endsection
