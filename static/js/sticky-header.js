var $ = jQuery

$( document ).ready(()=>{
    // Hide Header on on scroll down
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;

    var navbarHeight = $('#masthead').outerHeight();
    margin()
    
    $(window).scroll(function(event){
        didScroll = true;
    });
    
    setInterval(function() {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }, 250);
    
    function hasScrolled() {
        var st = $(this).scrollTop();
        if(Math.abs(lastScrollTop - st) <= delta)
        return;
        
        // If they scrolled down and are past the navbar, add class .nav-up.
        // This is necessary so you never see what is "behind" the navbar.
        console.log('conta resultado- ', st > lastScrollTop && st > navbarHeight)
        if (st > lastScrollTop && st > navbarHeight){
            // Scroll Down
            $('#masthead').removeClass('nav-down').addClass('nav-up');
        } else {
            // Scroll Up
            if(st + $(window).height() < $(document).height()) {
                $('#masthead').removeClass('nav-up').addClass('nav-down');
            }
        }
        
        lastScrollTop = st;
    }
})

$( window ).resize(function() {
    console.log('resize')
    margin()
});

function margin (){
    console.log($('#masthead').outerHeight())
    $('body')[0].style['padding-top'] = $('#masthead').outerHeight()+'px'
    $('#masthead')[0].style.top = $('body').position().top + 'px'
}
