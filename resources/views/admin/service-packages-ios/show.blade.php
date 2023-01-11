@extends('admin.layouts.main')
@section('breadcrumb')
    IOS Service Packages Detail
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">IOS Service Packages Detail</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('service-packages-ios')}}" class="btn btn-sm btn-default">List</a>
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
                    {{--<form method="post" action="{{route('service-packages-add')}}" enctype="multipart/form-data">
                        @csrf--}}
                        <h6 class="heading-small text-muted mb-4">IOS Service Packages information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="hidden" name="id"  class="form-control" value="{{$data->id}}">
                                        <label class="form-control-label">Parent Package</label>
                                        <input type="text" value="{{$data->parent->title ?? '-'}}" class="form-control"  disabled readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Title</label>
                                        <input type="text" name="title" value="{{old('title') ?? $data->title}}" class="form-control" placeholder="Title"
                                               required disabled readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Price</label>
                                        <input type="number" name="price" value="{{old('price') ?? $data->price}}" min="0" class="form-control" placeholder="Price"
                                               required disabled readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">IOS PAckage Number</label>
                                        <input type="text" name="ios_package_id" value="{{old('ios_package_id') ?? $data->ios_package_id}}"  class="form-control" placeholder="IOS PAckage Number"
                                               required disabled readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Duration Type</label>
                                        <select name="duration_type" class="form-control" required disabled readonly>
                                            <option value="">Select Option</option>
                                            <option value="year" @if((old('duration_type') ?? $data->duration_type) == 'year') selected @endif>Year</option>
                                            <option value="day" @if((old('duration_type') ?? $data->duration_type) == 'day') selected @endif>Day</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Package Duration</label>
                                        <input type="number" name="package_duration" value="{{old('package_duration') ?? $data->package_duration}}" min="1" class="form-control" placeholder="Package Duration"
                                               required disabled readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Package Tag</label>
                                        <input type="text" name="package_tag" value="{{old('package_tag') ?? $data->package_tag}}" class="form-control" placeholder="Package Tag"
                                               required disabled readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Sports Count</label>
                                        <input type="number" name="sports_count" value="{{old('sports_count') ?? $data->sports_count}}" min="1" class="form-control" placeholder="Sports Count"
                                               required disabled readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Addon</label>
                                        <select name="addon" class="form-control" required disabled readonly>
                                            <option value="">Select Option</option>
                                            <option value="1" @if((old('addon') ?? $data->addon) == '1') selected @endif>Yes</option>
                                            <option value="0" @if((old('addon') ?? $data->addon) == '0') selected @endif>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Validity Extend</label>
                                        <input type="number" name="validity_extend" value="{{old('validity_extend') ?? $data->validity_extend}}" min="0" class="form-control" placeholder="Validity Extend" required disabled readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Status</label>
                                        <select name="status" class="form-control" required disabled readonly>
                                            <option value="">Select Option</option>
                                            <option value="1" @if((old('status') ?? $data->status) == '1') selected @endif>Active</option>
                                            <option value="0" @if((old('status') ?? $data->status) == '0') selected @endif>Inactive</option>
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
                                            <?php
                                            $i=1;
                                            $descriptions = $data->description;
                                            $count = count($descriptions);
                                            ?>
                                            @foreach($descriptions as $key => $item)
                                            <tr>
                                                <input type="hidden" id="id_value" value="<?php echo $key; ?>">
                                                <td>
                                                    {{$key+1}}- {{$item}}
                                                    {{--<div class="form-group">
                                                        <input type="text" name="description[<?php echo $key; ?>]" value="{{$item}}"
                                                               style="width: -webkit-fill-available;"
                                                               class="form-control-sm" placeholder="Description" required disabled readonly>
                                                    </div>--}}
                                                </td>
                                                {{--<td>
                                                    <?php if ($key == "0") { ?>
                                                    <button type="button" class="btn btn-sm btn-default" id="addmoredescription">Add More</button>
                                                    <?php }else{ ?>
                                                    <button type="button" class="btn btn-sm btn-danger removeingredient">Remove</button>
                                                    <?php } ?>
                                                </td>--}}
                                            </tr>
                                            @endforeach
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
                                            <?php
                                            $i=1;
                                            $services = $data->service_exclude;
                                            $count = count($services);
                                            ?>
                                            @foreach($services as $key => $item)
                                                <tr>
                                                    <input type="hidden" id="id_value2" value="<?php echo $key; ?>">
                                                    <td>
                                                        {{$key+1}}- {{$item}}
                                                        {{--<div class="form-group">
                                                            <input type="text" name="service_exclude[<?php echo $key; ?>]" value="{{$item}}"
                                                                   style="width: -webkit-fill-available;"
                                                                   class="form-control-sm" placeholder="Service" required disabled readonly>
                                                        </div>--}}
                                                    </td>
                                                    {{--<td>
                                                        <?php if ($key == "0") { ?>
                                                        <button type="button" class="btn btn-sm btn-default" id="addmoreserviceexclude">Add More</button>
                                                        <?php }else{ ?>
                                                        <button type="button" class="btn btn-sm btn-danger removeingredient">Remove</button>
                                                        <?php } ?>
                                                    </td>--}}
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4"/>
                        {{--<button type="submit" class="btn btn-sm btn-default">Save</button>
                    </form>--}}
                </div>
            </div>
        </div>
    </div>
@endsection
