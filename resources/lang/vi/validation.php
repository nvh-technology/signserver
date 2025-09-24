<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute phải được chấp nhận.',
    'active_url' => ':attribute không phải là một URL hợp lệ.',
    'after' => ':attribute phải là một ngày sau ngày :date.',
    'after_or_equal' => ':attribute phải là một ngày sau hoặc bằng ngày :date.',
    'alpha' => ':attribute chỉ có thể chứa các chữ cái.',
    'alpha_dash' => ':attribute chỉ có thể chứa chữ cái, số, dấu gạch ngang và dấu gạch dưới.',
    'alpha_num' => ':attribute chỉ có thể chứa chữ cái và số.',
    'array' => ':attribute phải là một mảng.',
    'before' => ':attribute phải là một ngày trước ngày :date.',
    'before_or_equal' => ':attribute phải là một ngày trước hoặc bằng ngày :date.',
    'between' => [
        'numeric' => ':attribute phải nằm trong khoảng từ :min đến :max.',
        'file' => ':attribute phải nằm trong khoảng từ :min đến :max kilobytes.',
        'string' => ':attribute phải nằm trong khoảng từ :min đến :max ký tự.',
        'array' => ':attribute phải có từ :min đến :max phần tử.',
    ],
    'boolean' => ':attribute trường phải là true hoặc false.',
    'confirmed' => ':attribute xác nhận không khớp.',
    'date' => ':attribute không phải là một ngày hợp lệ.',
    'date_format' => ':attribute không khớp với định dạng :format.',
    'different' => ':attribute và :other phải khác nhau.',
    'digits' => ':attribute phải có :digits chữ số.',
    'digits_between' => ':attribute phải có từ :min đến :max chữ số.',
    'dimensions' => ':attribute có kích thước hình ảnh không hợp lệ.',
    'distinct' => ':attribute trường có giá trị trùng lặp.',
    'email' => ':attribute phải là một địa chỉ email hợp lệ.',
    'exists' => ':attribute đã chọn không hợp lệ.',
    'file' => ':attribute phải là một tập tin.',
    'filled' => ':attribute trường phải có giá trị.',
    'gt' => [
        'numeric' => ':attribute phải lớn hơn :value.',
        'file' => ':attribute phải lớn hơn :value kilobytes.',
        'string' => ':attribute phải lớn hơn :value ký tự.',
        'array' => ':attribute phải có nhiều hơn :value phần tử.',
    ],
    'gte' => [
        'numeric' => ':attribute phải lớn hơn hoặc bằng :value.',
        'file' => ':attribute phải lớn hơn hoặc bằng :value kilobytes.',
        'string' => ':attribute phải lớn hơn hoặc bằng :value ký tự.',
        'array' => ':attribute phải có :value phần tử trở lên.',
    ],
    'image' => ':attribute phải là một hình ảnh.',
    'in' => ':attribute đã chọn không hợp lệ.',
    'in_array' => ':attribute trường không tồn tại trong :other.',
    'integer' => ':attribute phải là một số nguyên.',
    'ip' => ':attribute phải là một địa chỉ IP hợp lệ.',
    'ipv4' => ':attribute phải là một địa chỉ IPv4 hợp lệ.',
    'ipv6' => ':attribute phải là một địa chỉ IPv6 hợp lệ.',
    'json' => ':attribute phải là một chuỗi JSON hợp lệ.',
    'lt' => [
        'numeric' => ':attribute phải nhỏ hơn :value.',
        'file' => ':attribute phải nhỏ hơn :value kilobytes.',
        'string' => ':attribute phải nhỏ hơn :value ký tự.',
        'array' => ':attribute phải có ít hơn :value phần tử.',
    ],
    'lte' => [
        'numeric' => ':attribute phải nhỏ hơn hoặc bằng :value.',
        'file' => ':attribute phải nhỏ hơn hoặc bằng :value kilobytes.',
        'string' => ':attribute phải nhỏ hơn hoặc bằng :value ký tự.',
        'array' => ':attribute không được có nhiều hơn :value phần tử.',
    ],
    'max' => [
        'numeric' => ':attribute không được lớn hơn :max.',
        'file' => ':attribute không được lớn hơn :max kilobytes.',
        'string' => ':attribute không được lớn hơn :max ký tự.',
        'array' => ':attribute không được có nhiều hơn :max phần tử.',
    ],
    'mimes' => ':attribute phải là một tập tin có kiểu: :values.',
    'mimetypes' => ':attribute phải là một tập tin có kiểu: :values.',
    'min' => [
        'numeric' => ':attribute phải có ít nhất :min.',
        'file' => ':attribute phải có ít nhất :min kilobytes.',
        'string' => ':attribute phải có ít nhất :min ký tự.',
        'array' => ':attribute phải có ít nhất :min phần tử.',
    ],
    'not_in' => ':attribute đã chọn không hợp lệ.',
    'not_regex' => 'Định dạng :attribute không hợp lệ.',
    'numeric' => ':attribute phải là một số.',
    'present' => ':attribute trường phải có mặt.',
    'regex' => 'Định dạng :attribute không hợp lệ.',
    'required' => ':attribute trường là bắt buộc.',
    'required_if' => ':attribute trường là bắt buộc khi :other là :value.',
    'required_unless' => ':attribute trường là bắt buộc trừ khi :other nằm trong :values.',
    'required_with' => ':attribute trường là bắt buộc khi :values có mặt.',
    'required_with_all' => ':attribute trường là bắt buộc khi :values có mặt.',
    'required_without' => ':attribute trường là bắt buộc khi :values không có mặt.',
    'required_without_all' => ':attribute trường là bắt buộc khi không có :values nào có mặt.',
    'same' => ':attribute và :other phải khớp.',
    'size' => [
        'numeric' => ':attribute phải có kích thước :size.',
        'file' => ':attribute phải có kích thước :size kilobytes.',
        'string' => ':attribute phải có :size ký tự.',
        'array' => ':attribute phải chứa :size phần tử.',
    ],
    'starts_with' => ':attribute phải bắt đầu bằng một trong các giá trị sau: :values',
    'string' => ':attribute phải là một chuỗi.',
    'timezone' => ':attribute phải là một múi giờ hợp lệ.',
    'unique' => ':attribute đã được sử dụng.',
    'uploaded' => ':attribute tải lên thất bại.',
    'url' => 'Định dạng :attribute không hợp lệ.',
    'uuid' => ':attribute phải là một UUID hợp lệ.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'owner_id' => [
            'required' => 'ID chủ sở hữu là bắt buộc.',
            'exists' => 'ID chủ sở hữu đã chọn không hợp lệ.',
        ],
        'passcode' => [
            'required' => 'Mã OTP là bắt buộc.',
            'string' => 'Mã OTP phải là một chuỗi.',
        ],
        'file_to_sign' => [
            'required' => 'Tệp cần ký là bắt buộc.',
            'max' => 'Tệp cần ký không được lớn hơn :max kilobytes.',
            'mimes' => 'Tệp cần ký phải là một trong các loại: :values.',
        ],
        'fail' => [
            'invalid_passcode' => 'Mã OTP không hợp lệ.',
            'not_associated_with_owner' => 'Bạn không được liên kết với chủ sở hữu đã chọn.',
        ],
        'passcode_update' => [
            'current_passcode_mismatch' => 'Mã OTP hiện tại được cung cấp không khớp với mã OTP thực tế của bạn.',
            'current_passcode_required' => 'Vui lòng nhập mã OTP hiện tại của bạn.',
            'new_passcode_required' => 'Vui lòng nhập mã OTP mới.',
            'new_passcode_confirmed' => 'Xác nhận mã OTP mới không khớp.',
        ],
        'owner' => [
            'created_success' => 'Chủ sở hữu đã được tạo thành công.',
            'updated_success' => 'Chủ sở hữu đã được cập nhật thành công.',
            'deleted_success' => 'Chủ sở hữu đã được xóa thành công.',
            'file_not_found' => 'Không tìm thấy tệp.',
        ],
        'user' => [
            'owner_credential_missing' => 'Đối với chủ sở hữu ":owner_name", phải cung cấp Tên người dùng hoặc Credential ID.',
            'created_success' => 'Người dùng đã được tạo thành công.',
            'updated_success' => 'Người dùng đã được cập nhật thành công.',
            'deleted_success' => 'Người dùng đã được xóa thành công.',
            'roles_updated_success' => 'Vai trò người dùng đã được cập nhật thành công.',
        ],
        'role' => [
            'created_success' => 'Vai trò đã được tạo thành công.',
            'updated_success' => 'Vai trò đã được cập nhật thành công.',
            'deleted_success' => 'Vai trò đã được xóa thành công.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'owner_id' => 'ID chủ sở hữu',
        'passcode' => 'Mã OTP',
        'file_to_sign' => 'Tệp cần ký',
        'current_passcode' => 'Mã OTP hiện tại',
        'name' => 'Tên',
        'username' => 'Tên người dùng',
        'email' => 'Email',
        'fileConfig' => 'File Config',
        'keystoreFile' => 'Keystore File',
        'password' => 'Mật khẩu',
        'owners' => 'Chủ sở hữu',
        'owners.*' => 'Chủ sở hữu',
        'owner_pivot' => 'Thông tin xoay vòng chủ sở hữu',
        'owner_pivot.*.userName' => 'Tên người dùng chủ sở hữu',
        'owner_pivot.*.passcode' => 'Mã OTP chủ sở hữu',
        'owner_pivot.*.credentialID' => 'Credential ID chủ sở hữu',
        'backgroundSignature' => 'Chữ ký nền',
        'roles' => 'Vai trò',
        'roles.*' => 'Vai trò',
        'permissions' => 'Quyền',
        'permissions.*' => 'Quyền',
    ],
];
