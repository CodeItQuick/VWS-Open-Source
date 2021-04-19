<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/dashboard/index.css" />
    <link rel="stylesheet" href="/css/dashboard/sidebar.css" />
    <link rel="stylesheet" href="/css/dashboard/surveyrightbar.css" />
    <title>{{$survey -> SurveyName}}</title>
</head>
<body>
    <div class="main">
        @section('leftsidebar')
            @include('dashboard.leftsidebar')
        @show
        <section class="right-panel">
            <h2>Good Morning {{auth()->user()->name}},</h2>
            <br>
            <div class="container" style="width:80%">
                <!--show all records for this survey-->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>User name</th>
                            <th>survey create date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($surveyUserList as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $survey->created_at }}</td>
                            <td><a class="btn btn-success" style="width: 150px;" href="/specificAnswerPage/{{$user->id}}/{{$survey->id}}">View</a><td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!--a button to download the CSV file-->
                @csrf
                <a class="btn btn-success" href="/export/{{ $survey->id }}">Download as CSV</a>
            </div>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
</body>
</html>
