<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laravel AI</title>
    <link rel="icon" href="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- End JavaScript -->

    <!-- CSS -->
    <link rel="stylesheet" href="/style.css">
    <!-- End CSS -->

</head>

<body>
    <div class="chat">

        <!-- Header -->
        <div class="top">
            <img src="{{ asset('img/man.jpg') }}" alt="Avatar" style="width: 50px; height: 50px; border-radius: 50%;">
            <div>
                <p>Amith</p>
                <small>Online</small>
            </div>
        </div>
        <!-- End Header -->

        <!-- Chat -->
        <div class="messages">
            <div class="left message">
                <img src="{{ asset('img/robo.jpg') }}" alt="Avatar">
                <p>Start chatting with LARAVEL CHAT AI below!!</p>
            </div>
        </div>
        <!-- End Chat -->

        <!-- Footer -->
        <div class="bottom">
            <form>
                <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
                <button type="submit"></button>
            </form>
        </div>
        <!-- End Footer -->

    </div>
</body>

<script>
    var manImg = "{{ asset('img/man.jpg') }}";
    var taffImg = "{{ asset('img/robo.jpg') }}";

    // Broadcast messages
    $("form").submit(function(event) {
        event.preventDefault();

        // Stop empty messages
        if ($("form #message").val().trim() === '') {
            return;
        }

        // Disable form
        $("form #message").prop('disabled', true);
        $("form button").prop('disabled', true);

        // Populate sending message
        $(".messages > .message").last().after('<div class="right message">' +
            '<p>' + $("form #message").val() + '</p>' +
            '<img src="' + manImg + '" alt="Avatar">' +
            '</div>');

        // Scroll to the bottom
        $(document).scrollTop($(document).height());

        // Send AJAX request
        $.ajax({
            url: "/openai",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            data: {
                "content": $("form #message").val(),
            }
        }).done(function(res) {
            // Populate receiving message
            $(".messages > .message").last().after('<div class="left message">' +
                '<img src="' + taffImg + '" alt="check">' +
                '<p>' + res + '</p>' +
                '</div>');

            // Scroll to the bottom
            $(document).scrollTop($(document).height());
        }).fail(function() {
            alert("Failed to send the message. Please try again.");
        }).always(function() {
            // Cleanup
            $("form #message").val('');
            $("form #message").prop('disabled', false);
            $("form button").prop('disabled', false);
        });
    });
</script>


</html>
