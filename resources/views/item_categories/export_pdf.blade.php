<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>List of Item Categories</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            position: relative;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1;
            max-width: 800px;
            margin: 0 auto;
            padding-bottom: 60px;
            /* Tinggi footer */
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            background-color: #f2f2f2;
            width: 100%;
            position: absolute;
            bottom: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>List of Item Categories</h1>
        <table>
            <thead>
                <tr>
                    <th style="width: 7%">No</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $itemCategory)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $itemCategory->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="footer">
        <p>Printed on: {{ date('Y-m-d') }}</p>
        <p>Printed by: {{ auth()->user()->name }} - Kailila Terapi</p>
    </div>
</body>

</html>
