//display image/video input
function showDiv(select) {
    if (select.value == "image") {
        document.getElementById('image').style.display = "block";
        document.getElementById('video').style.display = "none";
        $("#image").attr("required", 'required');
        $("#video").removeAttr("required", 'required');
    } else {
        document.getElementById('image').style.display = "none";
        document.getElementById('video').style.display = "block";
        $("#video").attr("required", 'required');
        $("#image").removeAttr("required", 'required');
    }
}
//display image/video input
//addmoreingredient
/*$(document).on('click', '#addmoreingredient', function () {
    var i = $('#id_value').val();
    i++;
    var data = '<tr><td><div class="form-group"><input type="text" name="store[' + i + '][name]" style="width: -webkit-fill-available;" class="form-control-sm" placeholder="Name" required></div></td><td><div class="form-group"><input type="text" name="store[' + i + '][quantity]" style="width: -webkit-fill-available;"  class="form-control-sm" placeholder="Quantity" required></div></td><td><button type="button" class="btn btn-sm btn-danger removeingredient">Remove</button></td></tr>';
    $('#id_value').val(i);
    $('#addmoreingredientsection').append(data);
});*/
//addmoreingredient
//addmorediet
/*$(document).on('click', '#addmorediet', function () {
    var i = $('#id_value').val();
    i++;
    var data = '<tr><td><div class="form-group"><input type="text" name="store[' + i + '][meal]" style="width: -webkit-fill-available;" class="form-control-sm" placeholder="Meal" required></div></td><td><div class="form-group"><input type="text" name="store[' + i + '][quantity]" style="width: -webkit-fill-available;"  class="form-control-sm" placeholder="Quantity" required></div></td><td><button type="button" class="btn btn-sm btn-danger removeingredient">Remove</button></td></tr>';
    $('#id_value').val(i);
    $('#addmoredietsection').append(data);
});*/
//addmorediet
//removeingredient
$(document).on('click', '.removeingredient', function () {
    $(this).parent().parent().remove();
});
//removeingredient
//addmoredescription
$(document).on('click', '#addmoredescription', function () {
    var i = $('#id_value').val();
    i++;
    var data = '<tr><td><div class="form-group"><input type="text" name="description[' + i + ']" style="width: -webkit-fill-available;" class="form-control-sm" placeholder="Description" required></div></td><td><button type="button" class="btn btn-sm btn-danger removeingredient">Remove</button></td></tr>';
    $('#id_value').val(i);
    $('#addmoredescriptionsection').append(data);
});
//addmore
$(document).on('click', '#addmoreserviceexclude', function () {
    var i = $('#id_value2').val();
    
    i++;
    var data = '<tr><td><div class="form-group"><input type="text" name="service_exclude[' + i + ']" style="width: -webkit-fill-available;" class="form-control-sm" placeholder="Service" required></div></td><td><button type="button" class="btn btn-sm btn-danger removeingredient">Remove</button></td></tr>';
    $('#id_value2').val(i);
    $('#addmoreserviceexcludesection').append(data);
});

