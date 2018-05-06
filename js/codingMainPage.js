'use strict';

$(document).ready(function () {
    $.ajax({
        url : 'functions/codingMain/getLanguageDonut.php',
    }).done(function(data){
        Morris.Donut({
            element: 'languageDonut',
            data: JSON.parse(data),
            resize: true,
            colors: ['#d69700', '#af5500', '#09cd32','#d8cd00', '#4233a2', '#0060A2']
        });

    });
});

