let score = 0;
let gameInterval;
let gameDuration = 30; // 遊戲時間（秒）
let targetSpeed = 1000; // 目標移動速度（毫秒）
let timeLeft = gameDuration;
let gameTimer;

const target = document.getElementById('target');
const scoreDisplay = document.getElementById('score');
const timeLeftDisplay = document.getElementById('time-left'); // 獲取時間顯示元素的引用
const startBtn = document.getElementById('start-btn');
const gameArea = document.getElementById('game-area');

function getRandomPosition() {
    const gameAreaRect = gameArea.getBoundingClientRect();
    const x = Math.floor(Math.random() * (gameArea.offsetWidth - target.offsetWidth));
    const y = Math.floor(Math.random() * (gameArea.offsetHeight - target.offsetHeight));
    return {x, y};
}

function moveTarget() {
    const pos = getRandomPosition();
    target.style.left = pos.x + 'px';
    target.style.top = pos.y + 'px';
}

function startGame() {
    score = 0;
    timeLeft = gameDuration;
    scoreDisplay.innerText = score;
    timeLeftDisplay.innerText = timeLeft; // 初始化剩餘時間顯示
    startBtn.disabled = true;

    moveTarget();
    gameInterval = setInterval(moveTarget, targetSpeed);

    gameTimer = setInterval(() => {
        timeLeft--;
        timeLeftDisplay.innerText = timeLeft; // 更新剩餘時間顯示
        if(timeLeft <= 0){
            endGame();
        }
    }, 1000);
}

function endGame() {
    clearInterval(gameInterval);
    clearInterval(gameTimer);
    target.style.display = 'none';
    alert(`遊戲結束！你的分數是：${score}`);
    submitScore(score);
    startBtn.disabled = false;
    target.style.display = 'block';
}

function submitScore(score) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "submit_score.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4 && xhr.status === 200){
            console.log(xhr.responseText);
        }
    };
    xhr.send(`score=${score}`);
}

target.addEventListener('click', () => {
    score++;
    scoreDisplay.innerText = score;
    moveTarget();
});

startBtn.addEventListener('click', startGame);

// 確保DOM載入後執行
document.addEventListener('DOMContentLoaded', function() {
    timeLeftDisplay.innerText = gameDuration; // 初始化剩餘時間
});