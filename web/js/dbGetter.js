// script d'accès à la base de données à distance
// Côté client

var dbGetter = {};
dbGetter.results = {};

/**
 * Recover data from the database
 * @param {string} m    the name of the map currently used -> so we only recover useful data
 * @param {string} d    the detail of the map: does the map represent the regions, department or arrondissements
 * @param {string} crit the criteria applied
 * @param {int}    y    the year for the criteria (optionnal)
 */
dbGetter.getData = function ( m, d, crit, y ){
    // CAUTION this script is setted for a local server currently
    var posting = $.post("/projet_transversal/web/php/dbGetter.php", {
        map: m,
        detail: d,
        criteria: crit,
        year: y
    });
    
    posting.done(function(json){
        // we store the collected data in a array
        var data = JSON.parse(json);
        dbGetter.results = {};
        for( var i in data ){
            dbGetter.results[i] = data[i];
        }
    });
    
    posting.fail(function(){
       alert("failed !"); 
    });
}

dbGetter.stripAccents = function(str) {
    var php = require('phpjs');
    return php.strtr(php.utf8_decode(str), php.utf8_decode("àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ '()"), "aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY____");
}

/*
 * 
 * example of how to call the function dbGetter.getData();
 * 
 * $(document).ready(function(){
 *     dbGetter.getData(map, niveau de detail, critère, année);
 * });
 * 
 */
