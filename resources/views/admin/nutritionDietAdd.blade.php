@extends('admin.layouts.main')
@section('breadcrumb')
    User Diet Chart Add
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12 order-xl-1">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">User Diet Chart Add</h3>
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
                <form method="post" action="{{route('nutrition-diet-add')}}" enctype="multipart/form-data">
                    @csrf
                    <h6 class="heading-small text-muted mb-4">Nutrition Diet information</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">User</label>
                                    <select name="user_id" id="" class="form-control js-example-basic-single" required>
                                        <option value="">Select User</option>
                                        @foreach($userdata as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">Frequency</label>
                                    <select name="frequency_id" id="" class="form-control" required>
                                        <option value="">Select Option</option>
                                        @foreach($catedata as $item)
                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> -->
                            <!-- <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label">Day</label>
                                    <select name="day_name" id="" class="form-control" required>
                                        <option value="">Select Option</option>
                                        <option value="sunday">Sunday</option>
                                        <option value="monday">Monday</option>
                                        <option value="tuesday">Tuesday</option>
                                        <option value="wednesday">wednesday</option>
                                        <option value="thursday">Thursday</option>
                                        <option value="friday">Friday</option>
                                        <option value="saturday">Saturday</option>
                                    </select>
                                </div>
                            </div> -->
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
                                            <?php $i = 1; ?>
                                            <tr>
                                                <input type="hidden" id="id_value" value="<?php echo $i; ?>">
                                                <td>
                                                    <div class="form-group">
                                                        <select name="store[<?php echo $i; ?>][frequency_id]" id="frequency_id<?php echo $i; ?>" style="width: -webkit-fill-available;" onchange="getMeal('<?php echo $i; ?>')" class="form-control-sm" required>
                                                            <option value="">--- Select a Frequency ---</option>
                                                            @foreach($catedata as $item)
                                                                <option value="{{$item->id}}">{{$item->title}}</option>
                                                            @endforeach
                                                        </select>
                                                        {{--<input type="text" name="store[<?php echo $i; ?>][meal]" style="width: -webkit-fill-available;" class="form-control-sm" placeholder="Meal" required>--}}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <select name="store[<?php echo $i; ?>][meal]" id="meal<?php echo $i; ?>" style="width: -webkit-fill-available;" class="form-control-sm" required>
                                                            <option value="">--- Select a Meal ---</option>
                                                            <!-- @foreach($meals as $meal)
                                                                <option value="{{$meal->id}}">{{$meal->title}}</option>
                                                            @endforeach -->
                                                        </select>
                                                        {{--<input type="text" name="store[<?php echo $i; ?>][meal]" style="width: -webkit-fill-available;" class="form-control-sm" placeholder="Meal" required>--}}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="text" oninput='digitValidate(this)' name="store[<?php echo $i; ?>][quantity]" style="width: -webkit-fill-available;" class="form-control-sm" placeholder="Quantity" required>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-default" id="addmorediet">Add More</button>
                                                </td>
                                            </tr>
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
