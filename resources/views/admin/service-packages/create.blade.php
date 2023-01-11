@extends('admin.layouts.main')
@section('breadcrumb')
    Service Packages Add
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Service Packages Add</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('service-packages')}}" class="btn btn-sm btn-default">List</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        {!! implode('', $errors->all('
                            <div class="alert alert-warning" role="alert">
                                :message
                            </div>
                        ')) !!}
                    @endif
                    <form method="post" action="{{route('service-packages-add')}}" enctype="multipart/form-data">
                        @csrf
                        <h6 class="heading-small text-muted mb-4">Service Packages information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="hidden" name="id"  class="form-control" value="">
                                        <label class="form-control-label">Parent Package</label>
                                        <select name="parent_id" id="parent_id" class="form-control">
                                            <option value="">Select Option</option>
                                            @foreach($catedata as $item)
                                                <option value="{{$item->id}}">{{$item->title}}</option>
                                            @endforeach
                                        </select>
                                    </div> 
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Title</label>
                                        <input type="text" name="title" value="{{old('title')}}" class="form-control" placeholder="Title"
                                               required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Price</label>
                                        <input type="number" name="price" value="{{old('price')}}" min="1" class="form-control" placeholder="Price"
                                               required>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">IOS Package Number</label>
                                        <input type="text" name="ios_package_id" value="{{old('ios_package_id')}}"  class="form-control" placeholder="IOS Package Number">
                                    </div>
                                </div> --}}
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Duration Type</label>
                                        <select name="duration_type" class="form-control" required>
                                            <option value="">Select Option</option>
                                            <option value="year">Year</option>
                                            <option value="month">Month</option>
                                            <option value="day">Day</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Package Duration</label>
                                        <input type="number" name="package_duration" value="{{old('package_duration')}}" min="1" class="form-control" placeholder="Package Duration"
                                               required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Package Tag</label>
                                        <input type="text" name="package_tag" value="{{old('package_tag')}}" class="form-control" placeholder="Package Tag"
                                               required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Sports Count</label>
                                        <input type="number" name="sports_count" value="{{old('sports_count')}}" min="1" class="form-control" placeholder="Sports Count"
                                               required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Addon</label>
                                        <select name="addon" id="addon" class="form-control" required>
                                            <option value="">Select Option</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6" id="addon_price_type_div" style="display:none;">
                                    <div class="form-group">
                                        <label class="form-control-label">Addon Type</label>
                                        <select name="addon_price_type" id="addon_price_type" class="form-control">
                                            <option value="">Select Option</option>
                                            <option value="sport">Sport</option>
                                            <option value="person">Person</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6" id="addon_adult_count_div" style="display:none;">
                                    <div class="form-group">
                                        <label class="form-control-label">Addon Adult Count</label>
                                        <input type="text" name="addon_adult_count" id="addon_adult_count" value="{{old('addon_adult_count')}}" class="form-control" placeholder="Addon Adult Count">
                                    </div>
                                </div>
                                <div class="col-lg-6" id="addon_kid_count_div" style="display:none;">
                                    <div class="form-group">
                                        <label class="form-control-label">Addon Kid Count</label>
                                        <input type="text" name="addon_kid_count" id="addon_kid_count" value="{{old('addon_kid_count')}}" class="form-control" placeholder="Addon Kid Count">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Validity Extend</label>
                                        <input type="number" name="validity_extend" min="0" class="form-control" placeholder="Validity Extend" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="">Select Option</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label class="form-control-label">Description</label>
                                    <div class="table-responsive">
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Description</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody class="list" id="addmoredescriptionsection">
                                            <?php $i = 1; ?>
                                            <tr>
                                                <input type="hidden" id="id_value" value="<?php echo $i; ?>">
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" name="description[<?php echo $i; ?>]"
                                                               style="width: -webkit-fill-available;"
                                                               class="form-control-sm" placeholder="Description" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-default"
                                                            id="addmoredescription">Add More
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label class="form-control-label">Service Exclude</label>
                                    <div class="table-responsive">
                                        <table class="table align-items-center table-flush">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Service</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody class="list" id="addmoreserviceexcludesection">
                                            <?php $i = 1; ?>
                                            <tr>
                                                <input type="hidden" id="id_value2" value="<?php echo $i; ?>">
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" name="service_exclude[<?php echo $i; ?>]"
                                                               style="width: -webkit-fill-available;"
                                                               class="form-control-sm" placeholder="Service" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-default"
                                                            id="addmoreserviceexclude">Add More
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4"/>
                        <button type="submit" class="btn btn-sm btn-default">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    $(function(){
        $("#parent_id").change(function () { 
            var parent_id = $("#parent_id").val();
            if (!parent_id) {
                $("#addon_price_type_div").hide();
                $("#addon_price_type").removeAttr("required");
                 $("#addon_adult_count_div").hide();
                $("#addon_kid_count_div").hide();
                $("#addon_adult_count").removeAttr("required");
                $("#addon_kid_count").removeAttr("required");
            }else{
                $("#addon_price_type_div").show();
                $("#addon_price_type").attr("required","required");
            }
        });
    });
    $(function(){
        $("#addon_price_type").change(function () { 
            var addon_price_type = $("#addon_price_type").val();
            if (addon_price_type == "person") {
                $("#addon_adult_count_div").show();
                $("#addon_kid_count_div").show();
                $("#addon_adult_count").attr("required","required");
                $("#addon_kid_count").attr("required","required");
            }else{
                $("#addon_adult_count_div").hide();
                $("#addon_kid_count_div").hide();
                $("#addon_adult_count").removeAttr("required");
                $("#addon_kid_count").removeAttr("required");
            }
        }); 
    });
    $(function(){
        $("#addon").change(function () { 
            var addon = $("#addon").val();
            if (addon == "1") { 
                $("#addon_adult_count_div").show();
                $("#addon_kid_count_div").show();
            }else{
                $("#addon_adult_count_div").hide();
                $("#addon_kid_count_div").hide();
            }
        }); 
    });
</script>
@endsection