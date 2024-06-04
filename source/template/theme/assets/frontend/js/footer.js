var theToggle = document.getElementById('toggle');

function hasClass(elem, className) {
    return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
}

function addClass(elem, className) {
    if (!hasClass(elem, className)) {
        elem.className += ' ' + className;
    }
}

function removeClass(elem, className) {
    var newClass = ' ' + elem.className.replace(/[\t\r\n]/g, ' ') + ' ';
    if (hasClass(elem, className)) {
        while (newClass.indexOf(' ' + className + ' ') >= 0) {
            newClass = newClass.replace(' ' + className + ' ', ' ');
        }
        elem.className = newClass.replace(/^\s+|\s+$/g, '');
    }
}

function toggleClass(elem, className) {
    var newClass = ' ' + elem.className.replace(/[\t\r\n]/g, " ") + ' ';
    if (hasClass(elem, className)) {
        while (newClass.indexOf(" " + className + " ") >= 0) {
            newClass = newClass.replace(" " + className + " ", " ");
        }
        elem.className = newClass.replace(/^\s+|\s+$/g, '');
    } else {
        elem.className += ' ' + className;
    }
}

theToggle.onclick = function () {
    toggleClass(document.getElementById('menu-toggle'), 'hidden');
    return false;
}

var dropdownMenu = document.getElementById('dropdown-menu');
var menuToggle = document.getElementById('menu-toggle-dropdown');

menuToggle.addEventListener('mouseenter', function () {
    dropdownMenu.classList.remove('hidden');
});


menuToggle.addEventListener('mouseleave', function () {
    dropdownMenu.classList.add('hidden');
});


dropdownMenu.addEventListener('mouseenter', function () {
    dropdownMenu.classList.remove('hidden');
});


dropdownMenu.addEventListener('mouseleave', function () {
    dropdownMenu.classList.add('hidden');
});

var dropdownMenu1 = document.getElementById('dropdown-menu1');
var menuToggle1 = document.getElementById('menu-toggle1');


menuToggle1.addEventListener('mouseenter', function () {
    dropdownMenu1.classList.remove('hidden');
});

menuToggle1.addEventListener('mouseleave', function () {
    dropdownMenu1.classList.add('hidden');
});
dropdownMenu1.addEventListener('mouseenter', function () {
    dropdownMenu1.classList.remove('hidden');
});
dropdownMenu1.addEventListener('mouseleave', function () {
    dropdownMenu1.classList.add('hidden');
});

var dropdownMenu2 = document.getElementById('dropdown-menu2');
var menuToggle1 = document.getElementById('menu-toggle2');
menuToggle1.addEventListener('mouseenter', function () {
    dropdownMenu2.classList.remove('hidden');
});
menuToggle1.addEventListener('mouseleave', function () {
    dropdownMenu2.classList.add('hidden');
});
dropdownMenu2.addEventListener('mouseenter', function () {
    dropdownMenu2.classList.remove('hidden');
});
dropdownMenu2.addEventListener('mouseleave', function () {
    dropdownMenu2.classList.add('hidden');
});