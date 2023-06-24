let searchBtn = document.querySelector('#search-btn');
let searchBar = document.querySelector('.search-bar-container');
let formBtn = document.querySelector('#login-btn');
let loginForm = document.querySelector('.login-form-container');
let formClose = document.querySelector('#form-close');
let signUpForm = document.querySelector('.signup-form-container');
let formClose2 = document.querySelector('#form-close2');
let menu = document.querySelector('#menu-bar');
let navBar = document.querySelector('.navbar');
let videoBtn = document.querySelectorAll('.vid-btn');
let signUpFormOpen = document.getElementById("sign_up_form_open");
let loginFormOpen = document.getElementById("login_form_open");
let discoverBtn = document.getElementById("discover_login_form_open");
let bookForm = document.querySelector('.bookFormContainer');
let formClose3 = document.querySelector('#form-close3');
let bookFormOpen1 =document.getElementById("bookNow1");
let bookFormOpen2 =document.getElementById("bookNow2");
let bookFormOpen3 =document.getElementById("bookNow3");
let bookFormOpen4 =document.getElementById("bookNow4");
let bookFormOpen5 =document.getElementById("bookNow5");
let bookFormOpen6 =document.getElementById("bookNow6");
let bookFormOpen7 =document.getElementById("bookNow7");
let bookFormOpen8 =document.getElementById("bookNow8");
let bookFormOpen9 =document.getElementById("bookNow9");
let bookFormOpen10 =document.getElementById("bookNow10");
let bookFormOpen11 =document.getElementById("bookNow11");
let bookFormOpen12 =document.getElementById("bookNow12");
let bookFormOpen13 =document.getElementById("bookNow13");
let bookFormOpen14 =document.getElementById("bookNow14");
let bookFormOpen15 =document.getElementById("bookNow15");
let bookFormOpen16 =document.getElementById("bookNow16");
let bookFormOpen17 =document.getElementById("bookNow17");
let bookFormOpen18 =document.getElementById("bookNow18");


window.onscroll = () => {
    searchBtn.classList.remove('fa-times');
    searchBar.classList.remove('active');
    menu.classList.remove('fa-times');
    navBar.classList.remove('active');
}
menu.addEventListener('click', () => {
    menu.classList.toggle('fa-times');
    navBar.classList.toggle('active');
});
signUpFormOpen.addEventListener('click', () => {
    loginForm.classList.remove('active');
    signUpForm.classList.add('active');
});
loginFormOpen.addEventListener('click', () => {
    signUpForm.classList.remove('active');
    loginForm.classList.add('active');
});
discoverBtn.addEventListener('click', () => {
    loginForm.classList.add('active');
});
searchBtn.addEventListener('click', () => {
    searchBtn.classList.toggle('fa-times');
    searchBar.classList.toggle('active');
});
formBtn.addEventListener('click', () => {
    loginForm.classList.add('active');
});
bookFormOpen1.addEventListener('click', () => {
    bookForm.classList.add('active');
});
bookFormOpen2.addEventListener('click', () => {
    bookForm.classList.add('active');
});
bookFormOpen3.addEventListener('click', () => {
    bookForm.classList.add('active');
});
bookFormOpen4.addEventListener('click', () => {
    bookForm.classList.add('active');
});
bookFormOpen5.addEventListener('click', () => {
    bookForm.classList.add('active');
});
bookFormOpen6.addEventListener('click', () => {
    bookForm.classList.add('active');
});
bookFormOpen7.addEventListener('click', () => {
    bookForm.classList.add('active');
});
bookFormOpen8.addEventListener('click', () => {
    bookForm.classList.add('active');
});
bookFormOpen9.addEventListener('click', () => {
    bookForm.classList.add('active');
});
bookFormOpen10.addEventListener('click', () => {
    bookForm.classList.add('active');
});
bookFormOpen11.addEventListener('click', () => {
    bookForm.classList.add('active');
});
bookFormOpen12.addEventListener('click', () => {
    bookForm.classList.add('active');
});
bookFormOpen13.addEventListener('click', () => {
    bookForm.classList.add('active');
});
bookFormOpen14.addEventListener('click', () => {
    bookForm.classList.add('active');
});
bookFormOpen15.addEventListener('click', () => {
    bookForm.classList.add('active');
});
bookFormOpen16.addEventListener('click', () => {
    bookForm.classList.add('active');
});
bookFormOpen17.addEventListener('click', () => {
    bookForm.classList.add('active');
});
bookFormOpen18.addEventListener('click', () => {
    bookForm.classList.add('active');
});
formClose.addEventListener('click', () => {
    loginForm.classList.remove('active');
});
formClose2.addEventListener('click', () => {
    signUpForm.classList.remove('active');
});
formClose3.addEventListener('click', () => {
    bookForm.classList.remove('active');
});
videoBtn.forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelector('.controls .active').classList.remove('active');
        btn.classList.add('active');
        let src = btn.getAttribute('data-src');
        document.querySelector('#video-slider').src = src;

    });
});