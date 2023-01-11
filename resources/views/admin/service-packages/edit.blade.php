@extends('admin.layouts.main')
@section('breadcrumb')
    Service Packages Update
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Service Packages Update</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('service-packages') }}" class="btn btn-sm btn-default">List</a>
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
                    <form method="post" action="{{ route('service-packages-add') }}" enctype="multipart/form-data">
                        @csrf
                        <h6 class="heading-small text-muted mb-4">Service Packages information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="hidden" name="id" class="form-control"
                                            value="{{ $data->id }}">
                                        <label class="form-control-label">Parent Package</label>
                                        <input type="text" value="{{ $data->parent->title ?? '-' }}"
                                            class="form-control" disabled readonly>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Title</label>
                                        <input type="text" name="title" value="{{ old('title') ?? $data->title }}"
                                            class="form-control" placeholder="Title" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Price</label>
                                        <input type="number" name="price" onkeyup="updateFinalAmount()" id="price"
                                            value="{{ old('price') ?? $data->price }}" min="0" class="form-control"
                                            placeholder="Price" required>
                                    </div>
                                </div>



                                {{-- <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Discount (if available)</label>
                                        <input type="number" name="discount" onkeyup="updateFinalAmount()" id="discount"
                                            value="{{ old('discount') ?? $data->discount }}" min="0"
                                            class="form-control" placeholder="Enter Discount">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Total Amount (after discount)</label>
                                        <input type="number" name="total_amount_after_discount"
                                            id="total_amount_after_discount"
                                            value="{{ old('total_amount_after_discount') ?? $data->total_amount_after_discount }}"
                                            class="form-control" placeholder="Total Amount (after discount)" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">GST (on total amount)</label>
                                        <input type="number" name="gst_on_total_amount" id="gst_on_total_amount"
                                            value="{{ old('gst_on_total_amount') ?? $data->gst_on_total_amount }}"
                                            class="form-control" placeholder="GST (on total amount)" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Final Amount (after GST)</label>
                                        <input type="number" name="final_amount_after_gst" id="final_amount_after_gst"
                                            value="{{ old('final_amount_after_gst') ?? $data->final_amount_after_gst }}"
                                            class="form-control" placeholder="Final Amount (after GST)" readonly>
                                    </div>
                                </div> --}}




                                {{-- <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">IOS Package Number</label>
                                        <input type="text" name="ios_package_id"
                                            value="{{ old('ios_package_id') ?? $data->ios_package_id }}"
                                            class="form-control" placeholder="IOS Package Number">
                                    </div>
                                </div> --}}
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Duration Type</label>
                                        <select name="duration_type" class="form-control" required>
                                            <option value="">Select Option</option>
                                            <option value="year" @if ((old('duration_type') ?? $data->duration_type) == 'year') selected @endif>Year
                                            </option>
                                            <option value="month" @if ((old('duration_type') ?? $data->duration_type) == 'month') selected @endif>Month
                                            </option>
                                            <option value="day" @if ((old('duration_type') ?? $data->duration_type) == 'day') selected @endif>Day
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Package Duration</label>
                                        <input type="number" name="package_duration"
                                            value="{{ old('package_duration') ?? $data->package_duration }}"
                                            min="1" class="form-control" placeholder="Package Duration" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Package Tag</label>
                                        <input type="text" name="package_tag"
                                            value="{{ old('package_tag') ?? $data->package_tag }}" class="form-control"
                                            placeholder="Package Tag" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Sports Count</label>
                                        <input type="text" name="sports_count"
                                            value="{{ old('sports_count') ?? $data->sports_count }}" min="1"
                                            class="form-control" placeholder="Sports Count" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Addon</label>
                                        <select name="addon" class="form-control" required>
                                            <option value="">Select Option</option>
                                            <option value="1" @if ((old('addon') ?? $data->addon) == '1') selected @endif>Yes
                                            </option>
                                            <option value="0" @if ((old('addon') ?? $data->addon) == '0') selected @endif>No
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6" id="addon_price_type_div" style="<?php if (empty($data->parent_id)) {
                                    echo 'display:none';
                                } ?>">
                                    <div class="form-group">
                                        <label class="form-control-label">Addon Type</label>
                                        <select name="addon_price_type" class="form-control" required>
                                            <option value="sport" @if ((old('addon_price_type') ?? $data->addon_price_type) == 'sport') selected @endif>Sport
                                            </option>
                                            <option value="person" @if ((old('addon_price_type') ?? $data->addon_price_type) == 'person') selected @endif>Person
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6" id="addon_adult_count_div">
                                    <div class="form-group">
                                        <label class="form-control-label">Addon Adult Count</label>
                                        <input type="text" name="addon_adult_count" id="addon_adult_count"
                                            value="{{ old('addon_adult_count') ?? $data->addon_adult_count }}"
                                            class="form-control" placeholder="Addon Adult Count" required>
                                    </div>
                                </div>
                                <div class="col-lg-6" id="addon_kid_count_div">
                                    <div class="form-group">
                                        <label class="form-control-label">Addon Kid Count</label>
                                        <input type="text" name="addon_kid_count" id="addon_kid_count"
                                            value="{{ old('addon_kid_count') ?? $data->addon_kid_count }}"
                                            class="form-control" placeholder="Addon Kid Count" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Validity Extend</label>
                                        <input type="number" name="validity_extend"
                                            value="{{ old('validity_extend') ?? $data->validity_extend }}"
                                            min="0" class="form-control" placeholder="Validity Extend" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="">Select Option</option>
                                            <option value="1" @if ((old('status') ?? $data->status) == '1') selected @endif>Active
                                            </option>
                                            <option value="0" @if ((old('status') ?? $data->status) == '0') selected @endif>
                                                Inactive</option>
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
                                                $i = 1;
                                                $descriptions = $data->description;
                                                $count = count($descriptions);
                                                ?>
                                                @foreach ($descriptions as $key => $item)
                                                    <tr>
                                                        <input type="hidden" id="id_value" value="<?php echo $count; ?>">
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text"
                                                                    name="description[<?php echo $key; ?>]"
                                                                    value="{{ $item }}"
                                                                    style="width: -webkit-fill-available;"
                                                                    class="form-control-sm" placeholder="Description"
                                                                    required>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php if ($key == "0") { ?>
                                                            <button type="button" class="btn btn-sm btn-default"
                                                                id="addmoredescription">Add More</button>
                                                            <?php }else{ ?>
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger removeingredient">Remove</button>
                                                            <?php } ?>
                                                        </td>
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
                                                $i = 1;
                                                $services = $data->service_exclude;
                                                $count = count($services);
                                                ?>
                                                @foreach ($services as $key => $item)
                                                    <tr>
                                                        <input type="hidden" id="id_value2" value="<?php echo $key; ?>">
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text"
                                                                    name="service_exclude[<?php echo $key; ?>]"
                                                                    value="{{ $item }}"
                                                                    style="width: -webkit-fill-available;"
                                                                    class="form-control-sm" placeholder="Service"
                                                                    required>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php if ($key == "0") { ?>
                                                            <button type="button" class="btn btn-sm btn-default"
                                                                id="addmoreserviceexclude">Add More</button>
                                                            <?php }else{ ?>
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger removeingredient">Remove</button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
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
        $(function() {
            $("#parent_id").change(function() {
                var parent_id = $("#parent_id").val();
                if (!parent_id) {
                    $("#addon_price_type_div").hide();
                    $("#addon_price_type").removeAttr("required");
                } else {
                    $("#addon_price_type_div").show();
                    $("#addon_price_type").attr("required", "required");
                }
            });
        });
        $(function() {
            $("#addon_price_type").change(function() {
                var addon_price_type = $("#addon_price_type").val();
                if (addon_price_type == "person") {
                    $("#addon_adult_count_div").show();
                    $("#addon_kid_count_div").show();
                    $("#addon_adult_count").attr("required", "required");
                    $("#addon_kid_count").attr("required", "required");
                } else {
                    $("#addon_adult_count_div").hide();
                    $("#addon_kid_count_div").hide();
                    $("#addon_adult_count").removeAttr("required");
                    $("#addon_kid_count").removeAttr("required");
                }
            });
        });

        function updateFinalAmount() {
            var price = $('#price').val();
            var discount = $('#discount').val();
            if (!price) {
                return false;
            }
            $.ajax({
                url: "{{ url('admin/updateFinalAmount') }}",
                type: 'get',
                dataType: 'json',
                data: {
                    'price': price,
                    'discount': discount,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.statusCode == "200") {
                        $('#total_amount_after_discount').val(data.total_price_after_discount);
                        $('#gst_on_total_amount').val(data.gst_amount);
                        $('#final_amount_after_gst').val(data.final_amount);
                    } else {
                        $('#total_amount_after_discount').val('');
                        $('#gst_on_total_amount').val('');
                        $('#final_amount_after_gst').val('');
                    }
                },
                error: function() {}
            });
        }
    </script>
@endsection
