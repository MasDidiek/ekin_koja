<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <h1>Hello, world!</h1>

    <div class="row">
        <div class="col-md-4">
            <table class="table table-sm table-bordered text-muted">
                <tr>
                    <th>No</th>
                    <th>PIN</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Delete</th>
                </tr>

                <?php
                $initial_date = $import[0]->tanggal;

                $initial_date = format_view($initial_date);

                for ($i = 0; $i < count($import); $i++) {

                    $date = $import[$i]->tanggal;
                    $tanggal = format_view($date);

                    if ($initial_date <> $tanggal) {
                        echo '
                         <tr class="bg-light">
                            <td colspan="2" style="text-align:left" class="badge bg-info-subtle text-info"">
                            <strong>' . format_full($tanggal) . '</strong>
                    
                            </td>
                       
                        </tr>';
                    }


                    echo ' <tr>
                            <td>' . ($i + 1) . '</td>
                            <td>' . $import[$i]->pin . '</td>
                            <td>' . date('H:i:s', strtotime($date)) . '</td>
                            <td>' . $import[$i]->status . '</td>
                            <td><a href="' . base_url() . 'admin/presensi/delete_import_absen/' . $this->uri->segment(4) . '/' . $import[$i]->id . '" class="btn btn-sm btn-danger">Delete</a></td>
                        </tr>';

                    $initial_date = $tanggal;
                }
                ?>

            </table>

        </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>