<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>data</title>
</head>
<body>
    <table>
        @foreach ($data as $item)
            <tr>
                <td>
                    {{$item->nama_pihak}}
                </td>
                <td>
                    {{$item->get_data_ia}}
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>