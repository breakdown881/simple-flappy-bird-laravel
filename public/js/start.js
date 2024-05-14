$(document).ready(function() {
    $('#startForm').on('submit', function(event) {
        event.preventDefault();
        var playerName = $('#player_name').val();
        var phoneNumber = $('#phone_number').val();
        var email = $('#email').val();
        localStorage.setItem('player_name', playerName);
        localStorage.setItem('phone_number', phoneNumber);
        localStorage.setItem('email', email);
        window.location.href = '/game';
    });
});
