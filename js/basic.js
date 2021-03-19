$(document).ready(function(){
    function getCurrentTime() {
        var now = new Date();
        var year    = now.getFullYear();
        var month   = now.getMonth()+1;
        var day     = now.getDate();
        var hour    = now.getHours();
        var minute  = now.getMinutes();
        if(month.toString().length == 1) {
            month = '0'+month;
        }
        if(day.toString().length == 1) {
            day = '0'+day;
        }
        if(hour.toString().length == 1) {
            hour = '0'+hour;
        }
        if(minute.toString().length == 1) {
            minute = '0'+minute;
        }
        return year+'-'+month+'-'+day+' '+hour+':'+minute;
    }

    $('.del_post').click(function () {
        if (confirm("You want to delete this post?")) {
            var id = $(this).attr('id');
            var data = "id=" + id;
            var container = $(this).parent().parent().parent();
            $.ajax({
                type:"POST",
                url:"?r=post/delete",
                data:data,
                success:function() {
                    container.hide();
                }
            });
        }
    });

    $('.like_post').click(function () {
        $(this).hide();
        $('.unlike_post').show();
        var data = "id=" + $(this).attr('id');
        $.ajax({
           type:"POST",
            url:"?r=post/like",
            data:data,
        });
    });

    $('.unlike_post').click(function () {
        $(this).hide();
        $('.like_post').show();
        var data = "id=" + $(this).attr('id');
        $.ajax({
            type:"POST",
            url:"?r=post/unlike",
            data:data,
        });
    });

    $('.edit_profile').click(function () {
        $(".edit_profile_success").show();
    });

    $('.post_comment').keypress(function(e) {
       if (e.keyCode == 13) {
           var data = $(this).attr('id') + "&content=" + $(this).val() + "&create_at=" + getCurrentTime();
           $(this).val("");
           $.ajax({
               type:"POST",
               url:"?r=post/comment",
               data:data,
               success:function(response) {
                  if(response !="NO"){
                      $('#box-comment').append(response);
                  }
               }
           });
       }
    });

    $('#add_friend_btn').click(function() {
        $('#add_friend_group').show();
    });

    $('.add_friend_fellow').click(function() {
        var data = $(this).attr('id') + "&create_at=" + getCurrentTime();
        $.ajax({
            type:"POST",
            url:"?r=relationship/send-friend-request-as-fellow",
            data:data,
            success:function(response) {
                alert("Submit request successfully!");
                $('#add_friend_btn').hide();
                $('#add_friend_group').hide();
                $('#friend_timeline_profile').append(response);
            }
        });
    });

    $('.add_friend_family').click(function() {
        var data = $(this).attr('id') + "&create_at=" + getCurrentTime();
        $.ajax({
            type:"POST",
            url:"?r=relationship/send-friend-request-as-family",
            data:data,
            success:function(response) {
                alert("Submit request successfully!");
                $('#add_friend_btn').hide();
                $('#add_friend_group').hide();
                $('#friend_timeline_profile').append(response);
            }
        });
    });

    $('#accept_friend_btn').click(function() {
        $('#accept_friend_group').show();
    });

    $('.accept_friend_fellow').click(function() {
        var data = $(this).attr('id') + "&update_at=" + getCurrentTime();
        $.ajax({
            type:"POST",
            url:"?r=relationship/accept-friend-request-as-fellow",
            data:data,
            success:function(response) {
                if (response == 'YES') {
                    alert("Accepted the request!");
                    $('#accept_friend_btn').hide();
                    $('#accept_friend_group').hide();
                }
            }
        });
    });

    $('.accept_friend_family').click(function() {
        var data = $(this).attr('id') + "&update_at=" + getCurrentTime();
        $.ajax({
            type:"POST",
            url:"?r=relationship/accept-friend-request-as-family",
            data:data,
            success:function(response) {
                if (response == 'YES') {
                    alert("Accepted the request!");
                    $('#accept_friend_btn').hide();
                    $('#accept_friend_group').hide();
                }
            }
        });
    });

    $('.notify_rel').click(function() {
        $('.rel_notify_count').hide();
        $.ajax({
            type:"POST",
            url:"?r=notification/make-old-relationship-notification",
        });
    });

    $('.notify_msg').click(function() {
        $('.notify_msg_count').hide();
        $.ajax({
            type:"POST",
            url:"?r=notification/make-old-message-notification",
        });
    });

    $('.notify_post').click(function() {
       $('.notify_post_count').hide();
        $.ajax({
            type:"POST",
            url:"?r=notification/make-old-post-notification",
        });
    });

    $('.text-aqua').click(function() {
        $('#add-new-event').css({"background-color":"#00C0EF", "border-color":"#00C0EF"});
        $('#event_color').val("#00C0EF");
    });
    $('.text-blue').click(function() {
        $('#add-new-event').css({"background-color":"#0073B7", "border-color":"#0073B7"});
        $('#event_color').val("#0073B7");
    });
    $('.text-light-blue').click(function() {
        $('#add-new-event').css({"background-color":"#3C8DBC", "border-color":"#3C8DBC"});
        $('#event_color').val("#3C8DBC");
    });
    $('.text-teal').click(function() {
        $('#add-new-event').css({"background-color":"#39CCCC", "border-color":"#39CCCC"});
        $('#event_color').val("#39CCCC");
    });
    $('.text-yellow').click(function() {
        $('#add-new-event').css({"background-color":"#F39C12", "border-color":"#F39C12"});
        $('#event_color').val("#F39C12");
    });
    $('.text-orange').click(function() {
        $('#add-new-event').css({"background-color":"#FF851B", "border-color":"#FF851B"});
        $('#event_color').val("#FF851B");
    });
    $('.text-green').click(function() {
        $('#add-new-event').css({"background-color":"#00A65A", "border-color":"#00A65A"});
        $('#event_color').val("#00A65A");
    });
    $('.text-lime').click(function() {
        $('#add-new-event').css({"background-color":"#01FF70", "border-color":"#01FF70"});
        $('#event_color').val("#01FF70");
    });
    $('.text-red').click(function() {
        $('#add-new-event').css({"background-color":"#DD4B39", "border-color":"#DD4B39"});
        $('#event_color').val("#DD4B39");
    });
    $('.text-purple').click(function() {
        $('#add-new-event').css({"background-color":"#605CA8", "border-color":"#605CA8"});
        $('#event_color').val("#605CA8");
    });
    $('.text-fuchsia').click(function() {
        $('#add-new-event').css({"background-color":"#F012BE", "border-color":"#F012BE"});
        $('#event_color').val("#F012BE");
    });
    $('.text-muted').click(function() {
        $('#add-new-event').css({"background-color":"#777", "border-color":"#777"});
        $('#event_color').val("#777");
    });
    $('.text-navy').click(function() {
        $('#add-new-event').css({"background-color":"#001F3F", "border-color":"#001F3F"});
        $('#event_color').val("#001F3F");
    });

    $('#inputPermit').change(function() {
        var val = $('#inputPermit option:selected').text();
        if (val != 'protected 1') {
            $('.postReader').hide();
        } else {
            $('.postReader').show();
        }
    });
});