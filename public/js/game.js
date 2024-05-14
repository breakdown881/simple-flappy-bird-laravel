// public/js/game.js
$(document).ready(function() {
    if (!localStorage.getItem('player_name') || !localStorage.getItem('phone_number')) {
        window.location.href = '/';
    }

    var canvas = $('#canvas')[0];
    var context = canvas.getContext('2d');
    var bird = { x: 50, y: 150, width: 20, height: 20, gravity: 0.6, lift: -10, velocity: 0 };
    var pipes = [];
    var score = 0;
    var pipeWidth = 20;
    var pipeGap = 150;
    var pipeInterval = 120;
    var pipeSpeed = 1.5;
    var frameCount = 0;
    var gameOver = false;

    function draw() {
        context.clearRect(0, 0, canvas.width, canvas.height);

        // Bird
        context.fillStyle = 'yellow';
        context.fillRect(bird.x, bird.y, bird.width, bird.height);

        bird.velocity += bird.gravity;
        bird.y += bird.velocity;

        if (bird.y + bird.height > canvas.height || bird.y < 0) {
            endGame();
        }

        // Pipes
        if (frameCount % pipeInterval === 0) {
            var pipeHeight = Math.floor(Math.random() * (canvas.height - pipeGap));
            pipes.push({ x: canvas.width, top: pipeHeight, bottom: pipeHeight + pipeGap });
        }

        for (var i = pipes.length - 1; i >= 0; i--) {
            pipes[i].x -= pipeSpeed;

            // Top pipe
            context.fillStyle = 'green';
            context.fillRect(pipes[i].x, 0, pipeWidth, pipes[i].top);
            // Bottom pipe
            context.fillRect(pipes[i].x, pipes[i].bottom, pipeWidth, canvas.height - pipes[i].bottom);

            if (pipes[i].x + pipeWidth < 0) {
                pipes.splice(i, 1);
                score++;
            }

            // Collision detection
            if (bird.x < pipes[i].x + pipeWidth &&
                bird.x + bird.width > pipes[i].x &&
                (bird.y < pipes[i].top || bird.y + bird.height > pipes[i].bottom)) {
                endGame();
            }
        }

        context.fillStyle = 'black';
        context.fillText('Score: ' + score, 10, 20);

        frameCount++;

        if (!gameOver) {
            requestAnimationFrame(draw);
        }
    }

    function endGame() {
        gameOver = true;
        submitScore();
    }

    function submitScore() {
        $.ajax({
            url: '/scores',
            type: 'POST',
            data: JSON.stringify({
                name: localStorage.getItem('player_name'),
                phone_number: localStorage.getItem('phone_number'),
                email: localStorage.getItem('email'),
                score: score
            }),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var reward = response.reward;
                showGameOverScreen(reward);
            },
            error: function(xhr, status, error) {
                showGameOverScreen(); // Show game over screen even if there is an error
            }
        });
    }

    function showGameOverScreen(reward = null) {
        context.fillStyle = 'rgba(0, 0, 0, 0.5)';
        context.fillRect(0, 0, canvas.width, canvas.height);
        context.fillStyle = 'white';
        context.font = '30px Arial';
        context.fillText('Game Over', 80, 200);
        context.fillText('Score: ' + score, 100, 250);

        if (score >= 5) {
            context.fillText('You won: ' + reward, 30, 300);
        } else {
            context.fillText('Cố gắng lên nhé', 50, 300);
        }

        context.font = '20px Arial';
        context.fillText('Press Space to Restart', 60, 350);

        $(document).on('keydown', restartGame);
    }

    function restartGame(event) {
        if (event.code === 'Space') {
            $(document).off('keydown', restartGame);
            resetGame();
            draw();
        }
    }

    function resetGame() {
        bird.y = 150;
        bird.velocity = 0;
        pipes = [];
        score = 0;
        frameCount = 0;
        gameOver = false;
    }

    $(document).on('keydown', function(event) {
        if (event.code === 'Space' && !gameOver) {
            bird.velocity = bird.lift;
        }
    });

    draw();
});
