<!DOCTYPE html>
<html>

<head>
    <title>Pending Client Response</title>
</head>

<body>
    <h1>Reminder: Pending Response on Project #{{ $project->id }}</h1>
    <p>
        Dear {{ $project->client->name }},
    </p>
    <p>
        You have not responded to the operator’s request for your project {{ $project->title }}. Please respond as soon
        as possible to avoid delays.
    </p>
    <p>Thank you,</p>
    <p>Your Project Management Team</p>
</body>

</html>
