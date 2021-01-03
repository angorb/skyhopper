<?php
require_once __DIR__ . "/config.php";
?>
<!doctype html>
<html lang="en">

<head>
    <title>Betaflight Profile Manager</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="shttps://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap.min.css">
    <style>
    div#fileUploader {
        margin-top: 15px;
    }

    button#uploadFormSubmit {
        margin-top: 15px;
    }
    </style>
</head>

<body>
    <?php include __DIR__ . "/views/navbar.php";?>
    <div class="container">
        <?=getSessionMessage()?>
        <?php include __DIR__ . "/views/files.php";?>

    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js">
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js">
    </script>
    <script src="//cdn.datatables.net/plug-ins/1.10.22/sorting/datetime-moment.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script>
    $(document).ready(function() {
        $.fn.dataTable.moment('MM/DD/YYYY h:mm:ssa');
        $('#profileTable').DataTable({
            stateSave: true
        });

        $('input[type="file"]').change(function(e) {
            var fileName = e.target.files[0].name;
            // change name of actual input that was uploaded
            $(e.target).next().html(fileName);
        });
    });
    </script>
</body>

</html>