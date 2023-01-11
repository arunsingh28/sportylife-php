@extends('layouts.main')
@section('style')
@endsection
@section('content')
    <div class="frequently_questions">
        <div class="container">
            <h3> FAQ </h3>
            <div class="row">
                <div class="col-lg-2 col-md-0">
                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="accordion" id="accordionExample">
                        @foreach ($data as $key => $item)
                            <h6>{{ $item->title }}</h6>
                            @if (!empty($item->faqdata[0]))
                                @foreach ($item->faqdata as $key1 => $item1)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $item1->id }}">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $item1->id }}"
                                                aria-expanded="false" aria-controls="collapse{{ $item1->id }}">
                                                {!! $item1->question !!}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $item1->id }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading{{ $item1->id }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                {!! $item1->answer !!}
                                            </div>
                                        </div>
                                        {{-- <div>
                                            <div class="accordion-body" style="color:#fff;background:#000;">
                                                Was this helpful?
                                                <span style="float:right;">
                                                    <i class="fa fa-thumbs-up" style="font-size:22px;margin-right: 8px; <?php if ($item1->faq_user_response == '1') {echo 'color:green';}  ?> " @if ($item1->faq_user_response == '0') onclick="submitResponse({{ $item1->id }}, '1')" @endif></i>
                                                    <i class="fa fa-thumbs-down" style="font-size:22px;<?php if ($item1->faq_user_response == '0') {echo 'color:green';}  ?>" @if ($item1->faq_user_response == '1') onclick="submitResponse({{ $item1->id }}, '0')" @endif></i>
                                                    
                                                    
                                                </span>
                                            </div>
                                        </div> --}}
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-2 col-md-0">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function submitResponse(faq_id, response) {
            $.ajax({
                url: "{{ url('faqUpdateResponseweb') }}",
                type: 'post',
                dataType: 'text',
                data: {
                    'faq_id': faq_id,
                    'response': response,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    var res = JSON.parse(data);
                    if (res.statusCode == "200") {
                        location.reload();
                    } else if (res.statusCode == "999") {
                        toastr.error(res.message)
                    } else {
                        toastr.error(res.message)
                    }
                },
                error: function() {}
            });
        }
    </script>
@endsection
