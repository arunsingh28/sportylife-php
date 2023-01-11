<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Enquiry Mail</title>
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
    <table>
        
  <tr>
    <td>Name</td>
    <td>{{$name}}</td>
  </tr>
  <tr>
    <td>Phone</td>
    <td>{{$phone}}</td>
  </tr>
  <tr>
    <td>Subject</td>
    <td>{{$subject}}</td>
  </tr>
  <tr>
    <td>Description</td>
    <td>{{$description}}</td>
  </tr>
  
</table>
</body>
</html>