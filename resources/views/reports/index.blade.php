@extends('default')

@section('content')

<div class="mb-3">

    {{ Form::label('Select the user', 'Select the user', ['class'=>'form-label']) }}
    {{ Form::select('is_done', $users, null, ['class' => 'form-label selected_user'], ['class' => 'form-control']) }}
	{{ Form::button('Search', array('class' => 'btn btn-primary searchButton')) }}

</div>
<div id="searchResults">

</div>

    <script>
        $(document).ready(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $('.searchButton').click(function () {
                var searchTerm = $('.selected_user').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('search') }}',
                    data: { searchTerm: searchTerm },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.length > 0) {
                            var resultsHtml = '<table class="table table-bordered"><thead><tr><th>Id</th><th>Title</th><th>Description</th><th>Starts in</th><th>Ends in</th><th>Task status</th></tr></thead><tbody>';

                            for (var i = 0; i < data.length; i++) {
                                resultsHtml += '<tr>';
                                resultsHtml += '<td>' + data[i].id + '</td>';
                                resultsHtml += '<td>' + data[i].title + '</td>';
                                resultsHtml += '<td>' + data[i].description + '</td>';
                                resultsHtml += '<td>' + data[i].started_at + '</td>';
                                resultsHtml += '<td>' + data[i].ended_at + '</td>';
                                resultsHtml += '<td>' + data[i].is_done + '</td>';
                                resultsHtml += '</tr>';
                            }

                            resultsHtml += '</tbody></table>';
                            $('#searchResults').html(resultsHtml);
                        } else {
                            $('#searchResults').html("No data for this user at the moment.");
                        }
                    }
                });
            });
        });
    </script>

	
@stop
