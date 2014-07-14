jQuery(document).ready(function(){
    jQuery('#layerslider').layerSlider({
        skinsPath : 'skins/',
        skin : 'light',
        thumbnailNavigation : 'hover',
        navPrevNext : false,
        navButtons : false,
        navStartStop : false,
        responsive : false,
        responsiveUnder : 940,
        sublayerContainer : 900
    });
    jQuery('a.ls-nav-prev').click(function() { jQuery('#layerslider').layerSlider('prev')})
    jQuery('a.ls-nav-next').click(function() { jQuery('#layerslider').layerSlider('next')})
});