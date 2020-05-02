let par = document.getElementsByTagName("p");
var cid;
let today;
let coloredCell;

class Calendar {

  constructor(domTarget) {
    // Get calendar div
    domTarget = domTarget || '.calendar';
    this.domElement = document.querySelector(domTarget);

    // calendar not found
    if (!this.domElement) throw "Calendar - L'élément spécifié est introuvable";

    // months list
    if (lang == "fr") {
      this.monthList = new Array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'aôut', 'septembre', 'octobre', 'novembre', 'décembre');
    }
    if (lang == "en") {
      this.monthList = new Array('january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');
    }


    // days list
    if (lang == "fr") {
      this.dayList = new Array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
    }
    if (lang == "en") {
      this.dayList = new Array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
    }

    // today's day number
    this.today = new Date();
    this.today.setHours(0, 0, 0, 0);

    // today's month
    this.currentMonth = new Date(this.today.getFullYear(), this.today.getMonth(), 1);

    // calendar header
    let header = document.createElement('div');
    header.classList.add('header');
    this.domElement.appendChild(header);

    // calendar days header
    this.content = document.createElement('div');
    this.domElement.appendChild(this.content);

    // back button
    let previousButton = document.createElement('button');
    previousButton.setAttribute('data-action', '-1');
    previousButton.textContent = '\u003c';
    header.appendChild(previousButton);

    // month and year
    this.monthDiv = document.createElement('div');
    this.monthDiv.classList.add('month');
    header.appendChild(this.monthDiv);

    // next button
    let nextButton = document.createElement('button');
    nextButton.setAttribute('data-action', '1');
    nextButton.textContent = '\u003e';
    header.appendChild(nextButton);

    // buttons back and next functions
    this.domElement.querySelectorAll('button').forEach(element => {
      element.addEventListener('click', () => {
        // On multiplie par 1 les valeurs pour forcer leur convertion en "int"
        this.currentMonth.setMonth(this.currentMonth.getMonth() * 1 + element.getAttribute('data-action') * 1);
        this.loadMonth(this.currentMonth);
      });
    });

    // today's month
    this.loadMonth(this.currentMonth);
  }

  loadMonth(date) {
    // empty div
    this.content.textContent = '';

    // On ajoute le mois/année affiché
    this.monthDiv.textContent = this.monthList[date.getMonth()].toUpperCase() + ' ' + date.getFullYear();

    // days of the week cells
    for (let i = 0; i < this.dayList.length; i++) {
      let cell = document.createElement('span');
      cell.classList.add('cell');
      cell.classList.add('day');
      cell.textContent = this.dayList[i].substring(0, 3).toUpperCase();
      this.content.appendChild(cell);
    }

    // empty cells
    for (let i = 0; i < date.getDay(); i++) {
      let cell = document.createElement('span');
      cell.classList.add('cell');
      cell.classList.add('empty');
      this.content.appendChild(cell);
    }

    // get number of days of the month
    let monthLength = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();

    // days of the month cells
    for (let i = 1; i <= monthLength; i++) {
      let cell = document.createElement('p');
      cell.classList.add('cell');
      cell.textContent = i;
      cell.onclick = function () { getServices(this) };
      this.content.appendChild(cell);

      // Timestamp
      let timestamp = new Date(date.getFullYear(), date.getMonth(), i).getTime();

      // special class for today
      if (timestamp === this.today.getTime()) {
        cell.classList.add('today');
        today = cell;
      }
    }
  }
}

const calendar = new Calendar('#calendar');

// get service from a clicked date
function getServices(d) {
  let space = document.getElementsByClassName('month')[0].innerHTML;
  let month = document.getElementsByClassName('month')[0].innerHTML;
  let day;
  let year = document.getElementsByClassName('month')[0].innerHTML;
  let request = new XMLHttpRequest;
  let json;
  let monthIndex;
  let tbody = document.getElementById('myTable');
  let newDiv = document.createElement('div');
  let rep;

  if (lang == "fr") {
    monthIndex = ['JANVIER', 'FÉVRIER', 'MARS', 'AVRIL', 'MAI', 'JUIN', 'JUILLET', 'AÔUT', 'SEPTEMBRE', 'OCTOBRE', 'NOVEMBRE', 'DÉCEMBRE']
  }
  if (lang == "en") {
    monthIndex = ['JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'];
  }

  tbody.appendChild(newDiv);

  space = space.indexOf(' ');
  month = month.substring(0, space);
  month = monthIndex.indexOf(month) + 1;
  year = year.substring(space + 1);
  year = parseInt(year);

  coloredCell.classList.remove('today');
  d.classList.add('today');
  coloredCell = d;


  for (let i = 0; i < par.length; i++) {
    if (par[i] === d) day = i + 1;
  }

  request.open('POST', "get_reservations.php");
  request.onreadystatechange = function () {
    if (request.readyState === 4) {
      rep = request.responseText;
      tbody.innerHTML = rep;
    }
  }

  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.send("date=" + year + "-" + month + "-" + day + "&id=" + cid);

}

function allocate(id) {
  cid = id;
}

window.onload = function () {
  coloredCell = today;
  today.click();
};
