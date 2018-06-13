require(['jquery','mage/url'], function($, url){
    var customurl = url.build('../../blog/post/submit');
    console.log(customurl);
    //Pub Static path of module
    //var imageUrl = require.toUrl('Kvr_Blog/images/loading.gif');
    //var imageModel = require.toUrl('pub/media/kvr/loading.gif');
    //$('.loading').html(imageUrl);
    $('#blogSubmit').click(function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: customurl,
            data: $('#blogPost').serialize(),
            beforeSend:function()
            {
                $('#blogPost').hide();
                $('.loading').show();
            },
            success: function (msg) {
                console.log(JSON.stringify(msg));
                $('#blogPost').show();
                $('.loading').hide();
                $( "#ajaxData" ).load( url.build('../../blog/index/index') + " #ajaxData" );
            }
        });

    });
});