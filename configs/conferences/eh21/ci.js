function colorise_svg( svg, color ){
	svg.querySelectorAll( "path" ).forEach( (path) => {
		path.style.transition = 'fill 0.5s ease-in-out';
		path.setAttribute( "fill", color );
	});
}

function colorise( color ){
    if (!(document.querySelector('body.overview > div.container') == null)) {
        document.querySelector('body.overview > div.container').querySelectorAll('h1,h2,h3,a,div.panel-title').forEach( (e) => {
            e.style['color'] = color;
            e.style['transition'] = 'color 0.5s ease-in-out';
        } );
    }
    if (!(document.querySelector('body.room > div.container') == null)) {
        document.querySelector('body.room > div.container').querySelectorAll('h1,h2').forEach( (e) => {
            e.style['color'] = color;
            e.style['transition'] = 'color 0.5s ease-in-out';
        } );
    }
}

if (!(document.querySelector( "body.overview > div.banner > figure:first-of-type img" ) == null)) {
    var $image = document.querySelector( "body.overview > div.banner > figure:first-of-type img" ),
        imgSrc = $image.getAttribute( "src" );

    var $object = document.createElement( "object" );
    $object.setAttribute( "data", imgSrc );
    $object.setAttribute( "type", "image/svg+xml" );
    $object.setAttribute( "id", "logo" ); // Optional, if you want to set an id
    $object.setAttribute( "alt", "rabbid" );

    $image.parentNode.replaceChild( $object, $image );
    $object.addEventListener("load", () => {

        var svg = $object.contentDocument;

        var color = [ Math.floor(Math.random()*361),100,40+Math.floor(Math.random()*21)],
            colorS = `hsl(${color[0]},${color[1]}%,${color[2]}%`;

        colorise( colorS);
        if (!(svg == null)) {
            colorise_svg( svg, colorS);
        }
    });
}


window.onload = function() {
        var color = [ Math.floor(Math.random()*361),100,40+Math.floor(Math.random()*21)],
            colorS = `hsl(${color[0]},${color[1]}%,${color[2]}%`;

        colorise( colorS);
};


document.addEventListener("scroll", () => {

    var color = [ Math.floor(Math.random()*361),100,40+Math.floor(Math.random()*21)],
        colorS = `hsl(${color[0]},${color[1]}%,${color[2]}%`;

    colorise( colorS);

});
