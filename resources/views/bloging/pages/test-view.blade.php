<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Test View</title>
</head>
<body>
  <table>
    <tr>
      <th>No</th>
      <th>Desc</th>
      <th>No</th>
      <th>Desc</th>
    </tr>
    @php
      var_dump($allItems);
    @endphp
    @for ($i = 0; $i < 6; $i++)
    <tr>
      <td>{{ $allItems[0][$i]['num_1'] }}</td>
      <td>{{ $allItems[0][$i]['desc1'] }}</td>
      <td>{{ $allItems[1][$i]['num_2'] }}</td>
      <td>{{ $allItems[1][$i]['desc2'] }}</td>
    </tr>
    @endfor
  </table>
</body>
</html>