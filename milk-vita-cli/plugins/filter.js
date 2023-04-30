import Vue from 'vue';

Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1);
});

Vue.filter('en2bn', function (number) {
    var numbers = {
        0:'০',
        1:'১',
        2:'২',
        3:'৩',
        4:'৪',
        5:'৫',
        6:'৬',
        7:'৭',
        8:'৮',
        9:'৯',
    };
    var output = [], number = (number)+'';
    for (var i = 0; i < number.length; ++i) {
        if (numbers.hasOwnProperty(number[i])) {
            output.push(numbers[number[i]]);
        } else {
            output.push(number[i]);
        }
    }
    return output.join('');
});

Vue.filter('en2bnF2', function (number) {
    var numbers = {
        0:'০',
        1:'১',
        2:'২',
        3:'৩',
        4:'৪',
        5:'৫',
        6:'৬',
        7:'৭',
        8:'৮',
        9:'৯',
    };
    var output = [], number = (Number.parseFloat(number).toFixed(2))+'';
    for (var i = 0; i < number.length; ++i) {
        if (numbers.hasOwnProperty(number[i])) {
            output.push(numbers[number[i]]);
        } else {
            output.push(number[i]);
        }
    }
    return output.join('');
});