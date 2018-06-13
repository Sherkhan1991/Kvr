require(['jquery','mage/url'], function($, url){
    //Pub Static path of module
    //var imageUrl = require.toUrl('Kvr_Blog/images/loading.gif');
    //var imageModel = require.toUrl('pub/media/kvr/loading.gif');
    //$('.loading').html(imageUrl);
    $('#blogSubmit').click(function(e) {
        e.preventDefault();
        var customurl;
        var formData;

        //Use For View Template
        if($(this).hasClass('Update')) {
            console.log('View');
            var form = $('#blogPost')[0];
            formData = new FormData(form);
            formData.append('edit', 1);
            customurl = url.build('blog/post/view');
            console.log(formData);
        } else {
            console.log('Submit');
            formData = $('#blogPost');
            customurl = url.build('blog/post/submit');
        }
        $.ajax({
            type: 'POST',
            url: customurl,
            data: formData,
            processData: false,
            contentType: false,
            beforeSend:function()
            {
                $('#blogPost').hide();
                $('.loading').show();
            },
            success: function (msg) {
                console.log(JSON.stringify(msg));
                $('#blogPost').show();
                $('.loading').hide();

                if($(this).hasClass('Update'))
                {
                    $("#ajaxData").load(customurl + " #ajaxData");
                    console.log('Success');
                } else {
                    console.log('Edit Success');
                    console.log(msg['edit']);
                    console.log(msg['postid']);
                }

            }
        });

    });
});