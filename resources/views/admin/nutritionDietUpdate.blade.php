@extends('admin.layouts.main')
@section('breadcrumb')
    User Diet Chart Update
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12 order-xl-1">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">User Diet Chart Update</h3>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{route('nutrition-diet')}}" class="btn btn-sm btn-default">List</a>
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
                <form method="post" action="{{route('nutrition-diet-update')}}" enctype="multipart/form-data">
                    @csrf
                    <h6 class="heading-small text-muted mb-4">Nutrition Diet information</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">User</label>
                                    <input type="hidden" name="id" class="form-control" value="{{$data->id}}">
                                    <select name="user_id" id="" class="form-control" required>
                                        <option value="">Select User</option>
                                        @foreach($userdata as $item)
                                        <option value="{{$item->id}}" <?php if ($item->id == $data->user_id) {
                                                                            echo "selected";
                                                                        } ?>>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="form-control-label">Meals/Quantity</label>
                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Frequency</th>
                                                <th>Meal</th>
                                                <th>Quantity</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody class="list" id="addmoredietsection">
                                            <?php
                                            $i = 1;
                                            $user_dietdata = $data->diet;
                                            $count = count($user_dietdata);
                                            ?>
                                            @foreach($user_dietdata as $key => $item)
                                            <tr>
                                                <input type="hidden" id="id_value" value="<?php echo $count; ?>">
                                                <td>
                                                    <div class="form-group">
                                                        <select name="store[<?php echo $key; ?>][frequency_id]" id="frequency_id<?php echo $key; ?>" style="width: -webkit-fill-available;" onchange="getMeal('<?php echo $key; ?>')" class="form-control-sm" required>
                                                            <option value="">--- Select a Frequency ---</option>
                                                            @foreach($catedata as $cate)
                                                                <option value="{{$cate->id}}" @if($cate->id == $item['frequency_id']) selected @endif>{{$cate->title}}</option>
                                                            @endforeach
                                                        </select>
                                                        {{--<input type="text" name="store[<?php echo $i; ?>][meal]" style="width: -webkit-fill-available;" class="form-control-sm" placeholder="Meal" required>--}}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <select name="store[<?php echo $key; ?>][meal]" id="meal<?php echo $key; ?>" style="width: -webkit-fill-available;" class="form-control-sm" required>
                                                            <option value="">--- Select a Meal ---</option>
                                                            @foreach($filtermeal[$item['frequency_id']] as $meal)
                                                                <option value="{{$meal->id}}" @if($meal->id == $item['meal']) selected @endif>{{$meal->title}}</option>
                                                            @endforeach
                                                        </select>
                                                        {{--<input type="text" name="store[<?php echo $key; ?>][meal]" style="width: -webkit-fill-available;" class="form-control-sm" value="{{$item['meal']}}" placeholder="Meal" required>--}}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" oninput='digitValidate(this)' name="store[<?php echo $key; ?>][quantity]" style="width: -webkit-fill-available;" class="form-control-sm" value="{{$item['quantity']}}" placeholder="Quantity" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if ($key == "0") { ?>
                                                        <button type="button" class="btn btn-sm btn-default" id="addmorediet">Add More</button>
                                                    <?php } else { ?>
                                                        <button type="button" class="btn btn-sm btn-danger removeingredient">Remove</button>
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
