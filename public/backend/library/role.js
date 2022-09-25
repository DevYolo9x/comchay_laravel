
  $(document).on('click', '.p-destroy', function(event) {
        event.preventDefault();
        let _this = $(this);
        let id = _this.attr('data-id');
        let urlRequest = _this.attr('data-url');
        if (id == 0) {
            sweet_error_alert('Có vấn đề xảy ra', 'Bạn phải chọn thành viên để thực hiện thao tác này');
        } else {
            swal({
                    title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
                    text: "Lưu ý: Khi bạn xóa thành viên, người này sẽ không thể truy cập vào hệ thống quản trị được nữa.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Thực hiện!",
                    cancelButtonText: "Hủy bỏ!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: "GET",
                            url:urlRequest,
                            success: function(data) {
                                if(data.code == 200){
                                    _this.parent().parent().parent().remove();
                                    swal("Success!", "Xóa thành viên thành công.", "success");

                                }else if(data.code == 201){
                                    swal("Error!", "Thành viên vẫn tồn tại trong nhóm.", "error");

                                }else{
                                    swal("Error!", "Có vấn đề xảy ra.", "error");
                                }
                            }
                        });

                    } else {
                        swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
                    }
                });
        }
    });
