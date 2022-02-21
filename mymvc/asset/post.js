function loadlist() {
    // Call ajax to get the data of the posts
    $.ajax({
        url: 'Post/getList',
        method: 'get',
        success: function (data) {
            data = JSON.parse(data);
            if (data.length > 0) {
                data.forEach(function (item) {
                    $('#post-list').append(''
                            + '<tr style="">'
                            + '    <td>' + item.id + '</td>'
                            + '    <td>' + item.m_title + '</td>'
                            + '    <td>'
                            + '        <a href="Post/delete/' + item.id + '">Xóa</a>'
                            + '        <a href="Post/formEdit/' + item.id + '">Sửa</a>'
                            + '    </td>'
                            + '</tr>');
                });
            }
        }
    });
}
//loadlist();