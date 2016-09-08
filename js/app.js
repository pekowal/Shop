$(function () {

    var products = $('.product');

    products.hide();

    var left = $('.left');
    var right = $('.right');
    var index = 0;
    products.eq(index).show();
    left.click(function () {
        products.eq(index).hide('fast');
        index--;
        if(index < 0){
            index = products.length -1;

        }

        products.eq(index).show('fast');

    });

    right.click(function () {
        products.eq(index).hide('fast');
        index++;
        if(index > products.length -1){
            index = 0;
        }
        products.eq(index).show('fast');
        console.log(index);
    });

    setInterval(function () {
        products.eq(index).hide('fast');
        index++;
        if(index >= products.length){
            index = 0;
        }
        products.eq(index).show('fast');
    },5000);
    console.log(products);
});