 $(document).on('click', '.p-reset', function(event) {
        event.preventDefault();
        let _this = $(this);
        let userID = _this.attr('data-userid');
        let urlRequest = _this.attr('data-url');
        if (userID == 0) {
            sweet_error_alert('Có vấn đề xảy ra', 'Bạn phải chọn thành viên để thực hiện thao tác này');
        } else {
            swal({
                    title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
                    text: "Mật khẩu sẽ được cài về giá trị mặc định là : admin2021! sau thao tác này",
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
                                    swal("Cập nhật thành công!", "Reset mật khẩu thành công.", "success");

								}else{
                                    sweet_error_alert('Có vấn đề xảy ra',json.message);
								}
                            }
                        });

                    } else {
                        swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
                    }
                });
        }
    });
  $(document).on('click', '.p-destroy', function(event) {
        event.preventDefault();
        let _this = $(this);
        let userID = _this.attr('data-userid');
        let urlRequest = _this.attr('data-url');
        if (userID == 0) {
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

                                }else{
                                    sweet_error_alert('Có vấn đề xảy ra',json.message);
                                }
                            }
                        });

                    } else {
                        swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
                    }
                });
        }
    });
