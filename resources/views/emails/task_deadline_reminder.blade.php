<!DOCTYPE html>
<html>

<head>
    <title>Task Deadline Approaching</title>
</head>

<body>
    <h2>Reminder: Task Deadline is Approaching</h2>
    <p>Dear {{ $task->operator->name }},</p>
    <p>The task <strong>{{ $task->title }}</strong> is approaching its deadline.</p>
    <p>Deadline: {{ $task->deadline->toFormattedDateString() }} at {{ $task->deadline->format('H:i') }}</p>
    <p>Please complete the task before the deadline to avoid delays.</p>
    <p>Thank you!</p>
</body>

</html>
