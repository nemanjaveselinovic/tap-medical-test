<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Webtest Login">
        <title>Tap Medical</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    </head>
    <body class="bg-light">
        <nav class="navbar navbar-dark navbar-expand-md sticky-top bg-dark p-0">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0"
            href="./">Website Logo</a>
            <div class="w-100 order-1 order-md-0">
                <ul class="navbar-nav px-3">
                </ul>
            </div>
            <div class="order-2 order-md-1">
                <ul class="navbar-nav px-3">
                    <li class="nav-item text-nowrap">
                        <a class="nav-link" href="">Log in</a>
                    </li>
                    <li class="nav-item text-nowrap">
                        <a class="nav-link" href="">Register</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main" class="container">
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <h1>Tap Medical</h1>
                <br />
                <form action="" method="post">
                    {{ csrf_field() }}
                    <div>
                        <div class="form-group">
                            <label for="select-doctor">Select doctor:</label>
                            <select class="form-control" id="select-doctor" name="doctor">
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->doctor_name }}" 
                                        @if(isset($selectedDoctor) && $doctor->doctor_name == $selectedDoctor) 
                                            selected 
                                        @endif>
                                        {{ $doctor->doctor_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="select-doctor">Select date:</label>
                            <input id="datepicker" name="appointments_date" class="form-control" required="required" value="{{ $selectedDate }}"/>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group">
                            <button type="submit" id="show-appointments" name="show-appointments" class="btn-secondary btn">Show Appointments</button>
                        </div>
                    </div>
                </form>
                <br />
                @if (isset($appointments))
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Start Time</th>
                                <th scope="col">Specialty</th>
                                <th scope="col">Patient Name</th>
                                <th scope="col">State</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->appointment_time }}</td>
                                    <td>{{ $appointment->specialty }}</td>
                                    <td>{{ $appointment->patient_name }}</td>
                                    <td>{{ $appointment->state }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </main> 
    </body>
    <script type="text/javascript">
        $(function () {
            $('#datepicker').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'mm/dd/yyyy'
            });
        });
    </script>
</html>
