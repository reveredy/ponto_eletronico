(function () {
  const menuToggle = document.querySelector(".menu-toggle");

  menuToggle.onclick = function (e) {
    const body = document.querySelector("body");

    body.classList.toggle("hide-sidebar");
  };
})();

function addOneSecond(hours, minuts, seconds) {
  const date = new Date();

  date.setHours(parseInt(hours));
  date.setMinutes(parseInt(minuts));
  date.setSeconds(parseInt(seconds) + 1);

  //método padStart marca com quantos casas queremos ver as horas, nesse caso 2 dígitos, e o segundo parametro diz para preencher com 0 a esquerda caso menor seja 1 digito só
  const h = `${date.getHours()}`.padStart(2, 0);
  const m = `${date.getMinutes()}`.padStart(2, 0);
  const s = `${date.getSeconds()}`.padStart(2, 0);

  return `${h}:${m}:${s}`;
}

function activateClock() {
  const activeClock = document.querySelector("[active-clock]");

  if (!activateClock) return;

  setInterval(function () {
    //'07:27:19' => ['07', '27', '19']
    const parts = activeClock.innerHTML.split(":");
    activeClock.innerHTML = addOneSecond(...parts);
  }, 1000);
}

activateClock();
