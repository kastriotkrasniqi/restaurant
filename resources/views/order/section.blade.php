<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/restaurant.css">

    <title>Document</title>
</head>

<body class="p-3">

    <div class="row table_order p-3">
        <div class="col-2 kategorite  pe-4">
            @foreach ($sections as $section)
                <a class="py-4 btn  fw-bold mb-1 kategoria text-center text-decoration-none text-white fw-bold "
                    data-id="{{ $section->id }}">{{ $section->name }}</a>
            @endforeach

        </div>

        <div class="col-7" style="overflow-y:auto;height:80vh;">

            <div class="row px-2 gap-2 produktet"></div>

        </div>


    </div>


    <div class="log-out-btn pt-3">
        <a href="#" class="btn btn-danger text-white" id="log-out">
            <i class=" fas fa-sign-out-alt"></i>
            <strong>LOGOUT</strong>
        </a>
    </div>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('.kategoria').click(function() {
        $.get('/section/getTablesById/' + $(this).data('id'), function(data) {
            $('.produktet').html(data);
        });
    });
</script>

</html>
