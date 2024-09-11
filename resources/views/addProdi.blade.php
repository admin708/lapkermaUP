<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Prodi</title>
</head>
<body>
    <center style="margin-top: 100px">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </center>

    @if(session('alertz'))
        {{session('alertz')}}
    @endif
    <form action="" method="POST">
        @csrf
        <center>
            <div style="width: 500px; margin-top: 50px">
                <label for="">Fakultas/Unit Kerja</label>
                <select name="fakultas">
                    <option value=""></option>
                    @foreach ($fakultasAll as $item)
                        <option value="{{$item->id}}">{{$item->nama_fakultas}}</option>
                    @endforeach
                </select>
                @error('fakultas')
                    <br>
                    {{$message}}
                @enderror
                <hr>
                <label for="">Prodi/Sub Unit Kerja</label>
                <input type="text" name="prodi">
                @error('prodi')
                    <br>
                    {{$message}}
                @enderror
                <hr>
                <button type="submit">Simpan</button>
            </div>
        </center>
    </form>
</body>
</html>