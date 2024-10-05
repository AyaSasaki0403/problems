$.ajax({
    url: 'get_user_info.php', // ユーザー情報を取得するPHPファイル
    type: 'GET',
    dataType: 'json',
    success: function(response) {
        if (response.status === 'success') {
            $('#username-link').text(response.username);
        } else {
            $('#username-link').text('ゲスト');
        }
    },
    error: function() {
        $('#username-link').text('ゲスト');
    }
});