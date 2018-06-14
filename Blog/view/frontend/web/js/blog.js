require(['jquery','mage/url'], function($, url){
    //Pub Static path of module
    //var imageModel = require.toUrl('pub/media/kvr/loading.gif');
    //$('.loading').html(imageModel);
    $('#blogSubmit').click(function(e) {
        e.preventDefault();

        //Getting from template
        //console.log(baseUrl);

        //Post Submit
        if($(this).hasClass('Update')) {
            var form = $('#blogPost')[0];
            var formData = new FormData(form);
            formData.append('edit', 1);

            $.ajax({
                type: 'POST',
                url: baseUrl,
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
                    //console.log(msg['edit']);
                    //console.log(msg['postid']);
                }
            });

        }
        else {
            //Post Update
            $.ajax({
                type: 'POST',
                url: baseUrl + 'post/submit',
                data: $('#blogPost').serialize(),
                beforeSend:function()
                {
                    $('#blogPost').hide();
                    $('.loading').show();
                },
                success: function (msg) {
                    console.log(JSON.stringify(msg));
                    //console.log(msg['postid']);
                    $('#blogPost').show();
                    $('.loading').hide();
                    $("#ajaxData").load(baseUrl + 'index/index' + " #ajaxData");
                }
            });
        }
    });
});