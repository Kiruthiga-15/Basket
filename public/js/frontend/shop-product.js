/* add inside @section('page-js') or shop.js */

document.addEventListener('DOMContentLoaded', function () {


    console.log("js loaded from shop page ")
    const gridBtn = document.getElementById('gridViewBtn');
    const listBtn = document.getElementById('listViewBtn');

    const gridWrap = document.getElementById('gridViewWrap');
    const listWrap = document.getElementById('listViewWrap');

    if (gridBtn && listBtn) {

        gridBtn.addEventListener('click', function () {

            gridWrap.style.display = 'block';
            listWrap.style.display = 'none';

            gridBtn.classList.add('active');
            listBtn.classList.remove('active');

        });

        listBtn.addEventListener('click', function () {

            gridWrap.style.display = 'none';
            listWrap.style.display = 'block';

            listBtn.classList.add('active');
            gridBtn.classList.remove('active');

        });

    }

});