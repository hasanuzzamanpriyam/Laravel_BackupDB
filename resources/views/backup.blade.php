<!DOCTYPE html>
<html>
<head>
    <title>Database Backup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Manual Database Backup</h2>

    @if(session('status'))
        <div class="alert alert-success mt-3">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('backup.run') }}" method="POST">
        @csrf
        <button class="btn btn-primary mt-3">Backup Now</button>
    </form>
</div>
</body>
</html>
