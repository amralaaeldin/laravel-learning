<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>

    <div class="container">
        <h1 class='my-3'>Hello Images</h1>
        <form method="POST" enctype="multipart/form-data" action="{{ route('imgs.upload') }}">
            @csrf
            <label for="avatar" class="form-label">Avatar</label>
            <input name="avatar" id='avatar' class="form-control" type="file">
            <button class='btn btn-success mt-3' type="submit">Upload Image</button>
        </form>
        <div class="row row-cols-4">
            @foreach ($imgs as $img)
            <div  class="card my-3 col gx-5" style="width: 18rem;">
                <img width="200" height="250" src="{{ asset("$img->path") }}" class="card-img-top" alt=" image{{ $img->id }}">
            </div>
            @endforeach
        </div>
    </div>

</body>
</html>
