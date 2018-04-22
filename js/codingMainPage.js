'use strict';

$(document).ready(function () {
    $.ajax({
        url : 'functions/codingMain/getLanguageDonut.php',
    }).done(function(data){
        Morris.Donut({
            element: 'languageDonut',
            data: JSON.parse(data),
            resize: true,
            colors: ['#d65d00', '#09cd32','#d8cd00', '#4233a2']
        });

    });
});

