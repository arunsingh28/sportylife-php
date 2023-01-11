<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Plan Purchased</title>
    <style>
    table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
    }

    td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
    }

    tr:nth-child(even) {
    background-color: #dddddd;
    }
    </style>
</head>
<body>
    <p>{{$message_data}}</p>
    <br>
    <table>
        
  <tr>
    <td>User Name</td>
    <td>{{@$name}}</td>
  </tr>
  <tr>
    <td>Package Title</td>
    <td>{{@$package_title}}</td>
  </tr>
  <tr>
    <td>Package Duration</td>
    <td>{{@$package_duration .' '.@$duration_type}}</td>
  </tr>
  <tr>
    <td>Purchased Games Details</td>
    <td>{{@$purchase_games}}</td>
  </tr>
  
</table>
</body>
</html>