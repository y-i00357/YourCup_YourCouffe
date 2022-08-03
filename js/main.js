$(function () {
  $('.delete_btn').on('click', function () {
    if (confirm('本当に削除しますか？')) {
      return true;
    } else {
      return false;
    }
  });

  $('.edit_confirm').on('click', function () {
    if (confirm('こちらの内容で更新しますか？')) {
      return true;
    } else {
      return false;
    }
  });

  $('.btn').on('click', function () {
    if (confirm('テスト')) {
      return true;
    } else {
      return false;
    }
  });

});

