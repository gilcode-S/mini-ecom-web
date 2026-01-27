// check admin password is correct or not
$('#current_pwd').keyup(function () {

    var current_pwd = $('#current_pwd').val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '/admin/verify-password',
        data: { current_pwd: current_pwd },

        success: function (resp) {
            if (resp === false || resp === 'false') {
                $('#verifyPwd').html("<span class='text-danger'>Current Password is incorrect!</span>");
            } else if (resp === true || resp === 'true') {
                $('#verifyPwd').html("<span class='text-success'>Current Password is correct!</span>");
            }
        },

        error: function () {
            alert("Something went wrong");
        }
    });

});


$(document).on('click', '#deleteProfileImage', function() {
    if(confirm('Are you sure you want to delete this profile image?')) {
        var admin_id = $(this).data('adminId');
        $.ajax(
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                url: 'delete-profile-image',
                data: {admin_id: admin_id},
                success: function (resp) {
                    if(resp['status'] == true) {
                        alert(resp['message']);
                        $('#profileImageBlock').remove();
                    }
                }, error: function () 
                {
                    alert("Error occurred while deleting profile image");
                }
            }
        )
    }
})
