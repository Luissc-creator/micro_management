@extends('operator.layout')
@section('content')
    <style>
        .chat-container {
            display: flex;
            height: 100vh;
        }

        .sender-list {
            width: 25%;
            border-right: 1px solid #ddd;
            padding: 15px;
            overflow-y: auto;
        }

        .messages-area {
            flex-grow: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            height: calc(100vh - 100px);
            overflow-y: auto;
        }

        .chat-input {
            position: fixed;
            bottom: 0;
            left: 25%;
            right: 0;
            background-color: #fff;
            border-top: 1px solid #ddd;
            padding: 10px;
        }

        .message {
            display: flex;
            margin-bottom: 10px;
        }

        .message-avatar {
            margin-right: 10px;
        }

        .message-avatar img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .message-content {
            max-width: 75%;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 10px;
        }

        .message-content.outgoing {
            background-color: #dcf8c6;
            margin-left: auto;
        }

        .timestamp {
            font-size: 0.8rem;
            color: #aaa;
            margin-top: 5px;
        }
    </style>

    <div class="container-fluid chat-container">
        <!-- Left Sidebar (Sender List) -->
        <div class="sender-list">
            <h5>Senders</h5>
            <div class="list-group">
                @foreach ($chatters as $chatter)
                    <a href="#" class="list-group-item list-group-item-action" id="user{{ $chatter->id }}"
                        onclick="loadMessages({{ $chatter->id }}, '{{ $chatter->name }}')">
                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/40" class="rounded-circle" alt="User">
                            <span class="ms-3">{{ $chatter->name }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Right Side (Messages Area) -->
        <div class="messages-area">
            <div class="chat-header">
                <h4 id="chat-header">Select a User to Chat</h4>
            </div>
            <div id='messageContainer'></div>
        </div>
    </div>

    <!-- Message Input Area -->
    <div class="chat-input">
        <form id="message-form" method='POST' action="{{ route('communications.store') }}">
            @csrf
            <input type='hidden' name='receiver_id' id='receiver_id' value=''>
            <textarea class="form-control" name='message' id="message-input" rows="2" placeholder="Type a message..."></textarea>
            <button type="submit" class="btn btn-primary w-100 mt-2" id="send-button" disabled>Send</button>
        </form>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function loadMessages(chatterId, chatterName) {
            $('#receiver_id').val(chatterId); // Update hidden input
            $('#chat-header').text(`Chatting with ${chatterName}`); // Update header
            $('#send-button').prop('disabled', false); // Enable the send button

            // Highlight the active user
            $('.list-group-item').removeClass('active');
            $(`#user${chatterId}`).addClass('active');

            $.ajax({
                url: `/communications/${chatterId}`, // Endpoint for fetching messages
                method: 'GET',
                success: function(response) {
                    displayMessages(response, 0); // Display fetched messages
                },
                error: function(error) {
                    console.error('Error fetching messages:', error);
                    alert('Could not load messages. Please try again later.');
                },
            });
        }

        function displayMessages(messages, isAppend) {

            const messageContainer = $('#messageContainer'); // Messages container
            if (!isAppend) {
                messageContainer.empty(); // Clear existing messages    
            }
            if (messages.length === 0) {
                messageContainer.html('<p class="text-muted">No messages yet. Start the conversation!</p>');
                return;
            }

            messages.forEach((message) => {
                const senderName = message.sender.name === message.currentUserName ? 'You' : message.sender.name;
                const messageHtml = `
                    <div class="card my-2 shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-title mb-0 text-primary">${senderName}</h6>
                                <small class="text-muted">${new Date(message.created_at).toLocaleString()}</small>
                            </div>
                            <p class="card-text mt-2">${message.message}</p>
                        </div>
                    </div>`;
                messageContainer.append(messageHtml);
            });
        }

        $('#message-form').on('submit', function(e) {
            e.preventDefault(); // Prevent page reload

            const formData = $(this).serialize();
            const receiverId = $('#receiver_id').val();

            if (!receiverId) {
                alert('Please select a user to send a message.');
                return;
            }

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#message-input').val(''); // Clear the input
                    displayMessages([response.message], 1); // Append the new message
                },
                error: function(error) {
                    console.error('Error sending message:', error);
                    alert('Could not send the message. Please try again.');
                },
            });
        });
    </script>
@endsection
