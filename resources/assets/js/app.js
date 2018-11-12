// app.js
console.log('app');


// /**
//  * First we will load all of this project's JavaScript dependencies which
//  * includes Vue and other libraries. It is a great starting point when
//  * building robust, powerful web applications using Vue and Laravel.
//  */

// require('./bootstrap');

// window.Vue = require('vue');

// // window.Laravel = { csrfToken: '{{ csrf_token() }}' };

// // Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");
// // // somewhere in your Vue app.js file
// // Vue.http.options.emulateJSON = true;

// /**
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */

// Vue.component('example', require('./components/Example.vue'));
// Vue.component('index-grid', require('./components/IndexGrid.vue'));

// const app = new Vue({
//     el: '#app'
// });
$(document).ready(function(){
    var table = $('.table');
    for(i=0; i<table.length; ++i){
        var lucky = table[i].getElementsByClassName('lucky');
        var lucky_time = table[i].getElementsByClassName('lucky_time');
        var edited = $('#input_edit');
        var is_edited = edited.children().length;
        for(j=0; j<lucky.length; ++j){
            var lucky_name = lucky[j].textContent;
            var shift = lucky_time[j].textContent.split('-');
            var set_array = table[i].getElementsByClassName(lucky_name)[0];
            for(k=shift[0]; k<shift[1]; ++k){
                set_array.getElementsByClassName(k)[0].classList.add('active');
            }
            if((is_edited != '0') && (i == '0')){
                var edit_lucky = edited[0].getElementsByClassName(`edit_${lucky_name}`)[0];
                edit_lucky.getElementsByClassName('start')[0].value = shift[0];
                edit_lucky.getElementsByClassName('end')[0].value = shift[1];
            }
        }
    }
    $('.expand_list').on('click', function(){
        $(this).find('.expand_item').toggleClass('hidden');
        var delayInMilliseconds = 3000; //1000 = 1 second
        var this_i = $(this);
        delay_time(this_i, delayInMilliseconds);
    });

    function delay_time(this_i, delayInMilliseconds){
        setTimeout(function() {
            this_i.find('.expand_item').toggleClass('hidden');
        }, delayInMilliseconds);
    };
    $('.set_10_15').change(function(){
        if($(this).prop('checked')){
            $(this).parent().find('.start').val(10);
            $(this).parent().find('.end').val(15);
        }else{
            $(this).parent().find('.start').val('');
            $(this).parent().find('.end').val('');
        }
    });
    $('.set_10_18').change(function(){
        if($(this).prop('checked')){
            $(this).parent().find('.start').val(10);
            $(this).parent().find('.end').val(18);
        }else{
            $(this).parent().find('.start').val('');
            $(this).parent().find('.end').val('');
        }
    });
    $('.set_10_22').change(function(){
        if($(this).prop('checked')){
            $(this).parent().find('.start').val(10);
            $(this).parent().find('.end').val(22);
        }else{
            $(this).parent().find('.start').val('');
            $(this).parent().find('.end').val('');
        }
    });
    $('.set_18_24').change(function(){
        if($(this).prop('checked')){
            $(this).parent().find('.start').val(18);
            $(this).parent().find('.end').val(24);
        }else{
            $(this).parent().find('.start').val('');
            $(this).parent().find('.end').val('');
        }
    });
    $('.set_10_24').change(function(){
        if($(this).prop('checked')){
            $(this).parent().find('.start').val(10);
            $(this).parent().find('.end').val(24);
        }else{
            $(this).parent().find('.start').val('');
            $(this).parent().find('.end').val('');
        }
    });
});
