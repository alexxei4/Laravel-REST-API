<!DOCTYPE html>
<html>
    <head>
        <title>Patient Records</title>
        <style>
            tr,td{
                border: 1px solid black;
                padding:5px;
            }
        </style>
    </head>
    <body>
        <h1>Patient Records</h1>
        <table>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Status</th>
            </tr>
            @foreach ($patients as $patient)
                <tr>
                    <td>{$patient -> firstname}</td>
                    <td>{$patient -> lastname}</td>
                    <td>{$patient -> status}</td>
                </tr>
            @endforeach
        </table>

    </body>

</html>