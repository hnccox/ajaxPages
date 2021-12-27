'use strict';

(function () {

    document.addEventListener('DOMContentLoaded', () => {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const cbgroup = urlParams.get('cbgroup');

        if(document.getElementById(cbgroup)) { document.getElementById(cbgroup).classList.remove("hidden") }

    });

})();