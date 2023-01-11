@extends('admin.layouts.main')
@section('breadcrumb')
    About us 
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">About us Update</h3>
                        </div>
                        
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        {!! implode(
                            '',
                            $errors->all('
                                                    <div class="alert alert-warning" role="alert">
                                                        :message
                                                    </div>
                                                '),
                        ) !!}
                    @endif
                    <form method="post" action="{{ route('about-us-update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="pl-lg-4">
                            <h6 class="heading-small text-muted "><b><u>About the Sporty Life information</u></b></h6>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Title</label>
                                        <input type="text" name="content[1][title]" value="{{$content1->title}}" placeholder="Enter Title" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Image</label>
                                        <input type="file" name="content[1][des_image]" class="form-control" accept="images/*">
                                        <br>
                                        @if(!empty($content1->des_image))
                                            <a href="{{asset($content1->des_image)}}" target="_blank"><img src="{{asset($content1->des_image)}}" height="50"  alt="{{$content1->title}}"></a>
                                        @else
                                            <span style="color: red;">No Image Uploaded!</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Status</label>
                                        <select name="content[1][status]" class="form-control" id="">
                                            <option value="">Select Option</option>
                                            <option value="1" <?php if($content1->status == '1'){echo "selected";} ?>>Active</option>
                                            <option value="0" <?php if($content1->status == '0'){echo "selected";} ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Description</label>
                                        <textarea name="content[1][description]" class="form-control" id="editor1" cols="5" rows="5" placeholder="Enter Description" value="{{$content1->description}}">{{$content1->description}}</textarea>
                                    </div>
                                </div>
                                

                            </div>
                            
                            <h6 class="heading-small text-muted mt-4"><b><u>Our History information</u></b></h6>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Title</label>
                                        <input type="text" name="content[2][title]" value="{{$content2->title}}" placeholder="Enter Title" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Image</label>
                                        <input type="file" name="content[2][des_image]" class="form-control" accept="images/*">
                                        <br>
                                        @if(!empty($content2->des_image))
                                            <a href="{{asset($content2->des_image)}}" target="_blank"><img src="{{asset($content2->des_image)}}" height="50"  alt="{{$content2->title}}"></a>
                                        @else
                                            <span style="color: red;">No Image Uploaded!</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Status</label>
                                        <select name="content[2][status]" class="form-control" id="">
                                            <option value="">Select Option</option>
                                            <option value="1" <?php if($content2->status == '1'){echo "selected";} ?>>Active</option>
                                            <option value="0" <?php if($content2->status == '0'){echo "selected";} ?>>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Description</label>
                                        <textarea  id="editor2" name="content[2][description]" class="form-control" cols="5" rows="5" placeholder="Enter Description" value="{{$content2->description}}">{{$content2->description}}</textarea>
                                    </div>
                                </div>
                                
                            </div>
                              
                            
                            {{-- <h6 class="heading-small text-muted mt-4"><b><u>Exclusive Members</u></b></h6>
                            <?php
                                $i = 1;
                                $count = count($members);

                            ?>
                            <div id="addmormember_aboutsection">
                            @if (!empty($members[0]))
                                @foreach ($members as $key => $item)
                                    <input type="hidden" id="id_value" value="<?php echo $count; ?>">
                                    <div class="row" >
                                        <input type="hidden" name="member[<?php echo $key; ?>][member_id]" value="{{$item->id}}" >
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Name</label>
                                                <input type="text" name="member[<?php echo $key; ?>][member_name]" value="{{$item->member_name}}" placeholder="Enter Name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Designation</label>
                                                <input type="text" name="member[<?php echo $key; ?>][member_role]" value="{{$item->member_role}}" placeholder="Enter Designation" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4" style="margin-top: 2.5rem !important;">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-sm btn-primary float-right "  id="addmoremember_about">Add More</button>
                                                <button type="button" class="btn btn-sm btn-danger removemember_about float-right mr-3" onclick="removeMemberAboutus({{$item->id}})" id="removemember_about{{$item->id}}">Remove</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-control-label">Image</label>
                                                <input type="file" name="member[<?php echo $key; ?>][member_image]" class="form-control" placeholder="Enter Image" accept="images/*">
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                        @if(!empty($item->member_image))
                                            <a href="{{asset($item->member_image)}}" target="_blank" style="margin-top: 2.3rem;float: right;"><img src="{{asset($item->member_image)}}" height="50"  alt="{{$item->member_name}}"></a>
                                        @endif
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Facebook Link</label>
                                                <input type="text" name="member[<?php echo $key; ?>][facebook_link]" value="{{$item->facebook_link}}" placeholder="Enter Facebook Link" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Instagram Link</label>
                                                <input type="text" name="member[<?php echo $key; ?>][instagram_link]" value="{{$item->instagram_link}}" placeholder="Enter Instagram Link" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Youtube Link</label>
                                                <input type="text" name="member[<?php echo $key; ?>][youtube_link]" value="{{$item->youtube_link}}" placeholder="Enter Youtube Link" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Status</label>
                                                <select name="member[<?php echo $key; ?>][status]" class="form-control" id="">
                                                    <option value="">Select Option</option>
                                                    <option value="1" <?php if($item->status == '1'){echo "selected";} ?>>Active</option>
                                                    <option value="0" <?php if($item->status == '0'){echo "selected";} ?>>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                            @else
                                    <input type="hidden" id="id_value" value="<?php echo $count; ?>">
                                    <div class="row" >
                                        <input type="hidden" name="member[0][member_id]">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Name</label>
                                                <input type="text" name="member[0][member_name]"  placeholder="Enter Name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Designation</label>
                                                <input type="text" name="member[0][member_role]"  placeholder="Enter Designation" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4" style="margin-top: 2.5rem !important;">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-sm btn-primary float-right"  id="addmoremember_about">Add More</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-control-label">Image</label>
                                                <input type="file" name="member[0][member_image]" class="form-control" placeholder="Enter Image" accept="images/*">
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                        
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Facebook Link</label>
                                                <input type="text" name="member[0][facebook_link]"  placeholder="Enter Facebook Link" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Instagram Link</label>
                                                <input type="text" name="member[0][instagram_link]"  placeholder="Enter Instagram Link" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Youtube Link</label>
                                                <input type="text" name="member[0][youtube_link]"  placeholder="Enter Youtube Link" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Status</label>
                                                <select name="member[0][status]" class="form-control" id="">
                                                    <option value="">Select Option</option>
                                                    <option value="1" >Active</option>
                                                    <option value="0" >Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                            @endif
                            </div> --}}
                        </div>
                        <hr class="my-4" />
                        <button type="submit" class="btn btn-sm btn-default">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).on('click', '#addmoremember_about', function () {
            var i = $('#id_value').val();
            i++;

            // var data = '<tr><td><div class="form-group"><input type="text" name="description[' + i + ']" style="width: -webkit-fill-available;" class="form-control-sm" placeholder="Description" required></div></td><td><button type="button" class="btn btn-sm btn-danger removemember_about">Remove</button></td></tr>';


            var data = '<div class="row" ><input type="hidden" name="member[' + i + '][member_id]"  value="">    <div class="col-lg-4">        <div class="form-group">            <label class="form-control-label">Name</label>            <input type="text" name="member[' + i + '][member_name]" placeholder="Enter Name" class="form-control">        </div>    </div>    <div class="col-lg-4">        <div class="form-group">            <label class="form-control-label">Designation</label>            <input type="text" name="member[' + i + '][member_role]" placeholder="Enter Designation" class="form-control">        </div>    </div>    <div class="col-lg-4" style="margin-top: 2.5rem !important;">        <div class="form-group">  <button type="button" class="btn btn-sm btn-primary float-right "  id="addmoremember_about">Add More</button>  <button type="button" class="btn btn-sm btn-danger removemember_about float-right mr-3">Remove</button>            </div>    </div>    <div class="col-lg-3">        <div class="form-group">            <label class="form-control-label">Image</label>            <input type="file" name="member[' + i + '][member_image]" class="form-control" placeholder="Enter Image" accept="images/*">        </div>    </div>    <div class="col-lg-1">       </div>    <div class="col-lg-4">        <div class="form-group">            <label class="form-control-label">Facebook Link</label>            <input type="text" name="member[' + i + '][facebook_link]" placeholder="Enter Facebook Link" class="form-control">        </div>    </div>    <div class="col-lg-4">        <div class="form-group">            <label class="form-control-label">Instagram Link</label>            <input type="text" name="member[' + i + '][instagram_link]" placeholder="Enter Instagram Link" class="form-control">        </div>    </div>    <div class="col-lg-4">        <div class="form-group">            <label class="form-control-label">Youtube Link</label>            <input type="text" name="member[' + i + '][youtube_link]" placeholder="Enter Youtube Link" class="form-control">        </div>    </div>    <div class="col-lg-4">        <div class="form-group">            <label class="form-control-label">Status</label>            <select name="member[' + i + '][status]" class="form-control" id="">                <option value="">Select Option</option>                <option value="1" >Active</option>                <option value="0" >Inactive</option>            </select>        </div>    </div><hr></div><hr>';
            $('#id_value').val(i);
            $('#addmormember_aboutsection').append(data);
        });

        $(document).on('click', '.removemember_about', function () {
            $(this).parent().parent().parent().remove();
        });

        function removeMemberAboutus(member_id) {
            
            $.ajax({
                url: "{{url('/admin/removeMemberAboutus')}}",
                type: 'post',
                dataType: 'text',
                data: {
                    'member_id':member_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    console.log(data);
                    var res = JSON.parse(data);
                    if (res.statusCode == "200") {
                        // if (res.count == 0) {
                            location.reload(true);
                        // }
                        // else{
                        //     $('#removemember_about'+member_id).parent().parent().parent().remove();
                        // }
                    }else{
                        toastr.error(res.message)
                    }
                },
                error: function(){
                }
            });
        }
    </script>
@endsection
