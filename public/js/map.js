function paintMap(code = '') {
    if (code == '') {
        code = $('#country').val();
    }
    if (code == '') {
        code = $('#country').val();
    }
    var data = {
        [code]: "#1A2F40"
    };

    $('#map').empty();

    var map = $('#map').vectorMap({
        map: 'world_mill', // el mapa del mundo
        backgroundColor: 'white',
        regionStyle: {
            initial: {
                fill: "#65BAFF"
            }
        },
        series: {
            regions: [{
                values: data, // los valores
                attribute: 'fill',
                normalizeFunction: 'polynomial' // la formula de normalizacion de datos
            }]
        },
        onRegionTipShow: function(e, el, code){ // al seleccionar una region se muestra el valor que tengan en el array
            el.html(el.html());
        }
    });
}

$(document).ready(function() {
    paintMap($('#map').attr("country-code"));

    $("#country").on("input", function () {
        paintMap();
    });
});