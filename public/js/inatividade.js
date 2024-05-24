//função que verifica a inativadade do usuário
var inactivityTime = function () {
    var time = 3000;
    window.onload = resetTimer;
    // DOM Events
    document.onmousemove = resetTimer;
    document.onkeydown = resetTimer;

    function logout() {
        alert("Você foi desconectado por inatividade.");

        location.href = 'auth/logout/'
    }

    function resetTimer() {
        clearTimeout(time);
        time = setTimeout(logout, 1800000);
        // 1000 milliseconds = 1 second
    }

};

window.onload = function () {
    inactivityTime();
}