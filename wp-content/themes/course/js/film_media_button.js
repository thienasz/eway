jQuery(function($) {
    $(document).ready(function(){
        $('#insert-sub-film').click(open_media_window);
    });

    function open_media_window() {
        if (this.window === undefined) {
            this.window = wp.media({
                title: 'Insert a media',
                library: {type: 'file'},
                multiple: false,
                button: {text: 'Insert'}
            });

            var self = this; // Needed to retrieve our variable in the anonymous function below
            this.window.on('select', function() {
                var first = self.window.state().get('selection').first().toJSON();
                console.log(first);
                $('#film-sub').val(first.id);
                $('#film-sub-preview').html('<p>Link sub: '+first.url+'</p>');
                //wp.media.editor.insert(first.url);
            });
        }

        this.window.open();
        return false;
    }
    //set link film
    $(document).ready(function(){
        $('#sub-link-film').click(open_insert_link);
    });

    function open_insert_link() {
        var content= $('#link-film').val();
        //content = content.replace('watch?v=','embed/');
        var width= $('#width-film').val();;
        var height= $('#height-film').val();
        content = '<div class="frame-film ">[embed ]'+content+'[/embed]</div><div class="clearfix"></div>'
        //content= '<center><div class= "film-content">' +
        //    '<iframe width="'+width+'" height="'+height+'" src="'+content+'" frameborder="0" allowfullscreen></iframe></div></center>';
        var  url = $('#link-film').val();
        if(url.indexOf('youtube.com') != -1){
            url = url.replace('watch?v=','embed/');
        }else {
            var tail= url.indexOf(".",url.length - 5);
            console.log(tail);
            tail = url.substring(tail+1);
            console.log(tail);
            if(tail == 'mp4'){
                content = url;
            }
        }
        console.log(content);
        jQuery('#film-source').val(content);
        var html= '<iframe src="'+url+'" frameborder="0" scrolling="no"></iframe>';
        $('#film-preview').html(html);
        //wp.media.editor.insert(content);
        $('#myModal').modal('hide');
        return false;
    }
});
