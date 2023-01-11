@extends('admin.layouts.main')
@section('breadcrumb')
    Meal Update
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Meal Update</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{route('meals')}}" class="btn btn-sm btn-default">List</a>
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
                    <form method="post" action="{{route('meals-add')}}" enctype="multipart/form-data">
                        @csrf
                        <h6 class="heading-small text-muted mb-4">Meal information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                        <label class="form-control-label">Frequency</label>
                                        <select name="frequency_id" class="form-control js-example-basic-single" required>
                                            @foreach($frqdata as $item)
                                            <option value="{{$item->id}}" <?php if ($data->frequency_id == $item->id) {
                                                echo "selected";
                                            } ?>>{{$item->title}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                    <label class="form-control-label" >Select Recipe</label>
                                    <select  name="recipe_id" id="recipe_detail_id" class="form-control js-example-basic-single">
                                        <option value="">Select Option</option>
                                        @foreach($allrecipes as $key => $item)
                                        <option value="{{$item->id}}" <?php if($data->recipe_id == $item->id){echo "selected";} ?>>{{$item->title}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                        <label class="form-control-label">Title</label>
                                        <input type="text" name="title" id="title" value="{{$data->title}}" class="form-control"
                                               placeholder="Title" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Calories</label>
                                        <input type="text" name="calorie" id="calorie" value="{{$data->calorie}}"
                                               class="form-control" placeholder="Calories" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Protein</label>
                                        <input type="text" name="protein" id="protein" value="{{$data->protein}}"
                                               class="form-control" placeholder="Protein" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Carbs</label>
                                        <input type="text" name="carbs" id="carbs" value="{{$data->carbs}}" class="form-control"
                                               placeholder="Carbs" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Fat</label>
                                        <input type="text" name="fats" id="fats" value="{{$data->fats}}" class="form-control"
                                               placeholder="Fat" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="1" <?php if ($data->status == "1") {
                                                echo "selected";
                                            } ?>>Active
                                            </option>
                                            <option value="0" <?php if ($data->status == "0") {
                                                echo "selected";
                                            } ?>>Inactive
                                            </option>
                                        </select>
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
