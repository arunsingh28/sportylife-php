@extends('admin.layouts.main')
@section('breadcrumb')
Nutrition Recipe Update
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Nutrition Recipe Update</h3>
               </div>
               <div class="col-4 text-right">
                  <a href="{{route('nutrition-recipes')}}" class="btn btn-sm btn-default">List</a>
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
            <form method="post" action="{{route('nutrition-recipe-update')}}" enctype="multipart/form-data">
               @csrf
               <h6 class="heading-small text-muted mb-4">Nutrition Recipe information</h6>
               <div class="pl-lg-4">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label" >Category</label>
                            <input type="hidden" name="id"  class="form-control" value="{{$data->id}}">
                           <select name="category_id" id="" class="form-control" required>
                              <option value="">Select Option</option>
                              @foreach($catedata as $item)
                              <option value="{{$item->id}}" <?php if($item->id == $data->category_id){echo "selected";} ?>>{{$item->title}}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-6">
                     </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Select Meal</label>
                           <select  name="recipes_meal_id" id="recipes_meals" class="form-control js-example-basic-single">
                              <option value="">Select Option</option>
                              @foreach($recipes_meals as $key => $item)
                              <option value="{{$item->id}}" <?php if($data->recipes_meal_id == $item->id){echo "selected";} ?>>{{$item->title}}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Title</label>
                           <input type="text" id="title" name="title" value="{{$data->title}}" class="form-control" placeholder="Title" required>
                        </div>
                     </div>
                     
                     <div class="col-lg-3">
                        <div class="form-group">
                           <label class="form-control-label" >Calories</label>
                           <input type="text" id="calorie" name="calorie" value="{{$data->calorie}}" class="form-control" placeholder="Calories" required>
                        </div>
                     </div>
                     <div class="col-lg-3">
                        <div class="form-group">
                           <label class="form-control-label" >Protein</label>
                           <input type="text" id="protein" name="protein" value="{{$data->protein}}" class="form-control" placeholder="Protein" required>
                        </div>
                     </div>
                     <div class="col-lg-3">
                        <div class="form-group">
                           <label class="form-control-label" >Carbs</label>
                           <input type="text" id="carbs" name="carbs" value="{{$data->carbs}}" class="form-control" placeholder="Carbs" required>
                        </div>
                     </div>
                     <div class="col-lg-3">
                        <div class="form-group">
                           <label class="form-control-label" >Fat</label>
                           <input type="text" id="fats" name="fats" value="{{$data->fats}}" class="form-control" placeholder="Fat" required>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Upload Type</label>
                           <select name="type" id="" class="form-control" onchange="showDiv(this)" required>
                              <option value="image" <?php if($data->type == "image"){echo "selected";} ?>>Image</option>
                              <option value="video" <?php if($data->type == "video"){echo "selected";} ?>>Video</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Uploads</label>
                           @if($data->type == 'image')
                           <input type="file" class="form-control" id="image" name="uploadimage" accept="image/*">
                           <input type="file" style="display:none" class="form-control" id="video" name="uploadvideo" accept="video/*">
                           @else
                           <input type="file" style="display:none" class="form-control" id="image" name="uploadimage" accept="image/*">
                           <input type="file"  class="form-control" id="video" name="uploadvideo" accept="video/*">
                           @endif
                           <span>Image Size should be 620px*350px</span>
                           <br>
                           <br>
                           @if($data->type == 'image')
                               <img required disabled readonly alt="{{$data->title}}" src="{{asset($data->uploads)}}" height="50">
                            @else
                                <video width="200"  controls>
                                    <source src="{{asset($data->uploads)}}" type="video/mp4">
                                </video>
                            @endif
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="form-group">
                           <label class="form-control-label" >Time taken to prepare recipe (in min)</label>
                           <input type="text" name="preparation_time" value="{{$data->preparation_time}}" class="form-control" placeholder="Time taken to prepare recipe">
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="form-group">
                           <label class="form-control-label" >How many can be served?</label>
                           <input type="text" name="person_to_serve" value="{{$data->person_to_serve}}" class="form-control" placeholder="How many can be served?" required>
                        </div>
                     </div>
                     
                     <div class="col-lg-4">
                        <div class="form-group">
                           <label class="form-control-label" >Status</label>
                           <select name="status" class="form-control" required>
                              <option value="1" <?php if($data->status == "1"){echo "selected";} ?>>Active</option>
                              <option value="0" <?php if($data->status == "0"){echo "selected";} ?>>Inactive</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Source Link</label>
                           <input type="text" name="source_link" value="{{$data->source_link}}"  class="form-control" placeholder="Source Link" >
                        </div>
                     </div>
                  </div>

                  <div class="row">
                      <div class="col-lg-12">
                          <label class="form-control-label" >Ingredients</label>
                        <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="list" id="addmoreingredientsection">
                                <?php
                                    $i=1;
                                    $ingredientdata = $data->ingredients;
                                    $count = count($ingredientdata);
                                ?>
                                @foreach($ingredientdata as $key => $item)
                                <tr>
                                    <input type="hidden" id="id_value" value="<?php echo $count; ?>">
                                    <td>
                                        <div class="form-group">
                                            <select name="store[<?php echo $key; ?>][name]" style="width: -webkit-fill-available;" class="form-control-sm js-example-basic-single" required>
                                                <option value="">--- Select a Ingredients ---</option>
                                                @foreach($meals as $meal)
                                                    <option value="{{$meal->id}}" @if($meal->id == $item['name']) selected @endif>{{$meal->title}}</option>
                                                @endforeach
                                            </select>
                                            {{--<input type="text" name="store[<?php echo $key; ?>][name]" style="width: -webkit-fill-available;" class="form-control-sm" placeholder="Name" value="{{$item['name']}}" required>--}}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" name="store[<?php echo $key; ?>][quantity]" style="width: -webkit-fill-available;" value="{{$item['quantity']}}"  class="form-control-sm" placeholder="Quantity" required>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($key == "0") { ?>
                                            <button type="button" class="btn btn-sm btn-default" id="addmoreingredient">Add More</button>
                                        <?php }else{ ?>
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
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label class="form-control-label" >Preparation</label>
                           <textarea type="text" id="editor1" name="preparation" cols="5" rows="5" class="form-control" placeholder="Enter Preparation" value="{{$data->preparation}}" required>{{$data->preparation}}</textarea>
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
