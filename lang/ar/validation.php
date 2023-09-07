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

    'accepted' => 'يجب قبول :attribute.',
    'active_url' => ':attribute ليست عنوان URL صالحًا.',
    'after' => 'يجب أن يكون هذا الحقل تاريخًا بعد الحقل :attribute.',
    'after_or_equal' => 'يجب أن يكون هذا الحقل تاريخًا بعد :date أو مساويًا له.',
    'alpha' => 'قد يحتوي  هذا الحقل على أحرف فقط.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'يجب أن يكون هذا الحقل مصفوفة.',
    'before' => 'يجب أن يكون هذا الحقل تاريخًا قبل الحقل :attribute.',
    'before_or_equal' => 'يجب أن يكون هذا الحقل تاريخًا يسبق :date أو مساويًا له.',
    'between' => [
        'numeric' => 'يجب أن يكون هذا الحقل بين :min و :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'تأكيد كلمة المرور غير مطابقة.',
    'date' => 'هذا الحقل ليس تاريخًا صالحًا.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'قيمة هذا الحقل غير صالحة',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'يجب أن يكون هذا الحقل مكون من :digits أرقام.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'يجب أن يكون هذا الحقل عنوان بريد إلكتروني صالحًا.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'exists' => 'البيانات المدخلة غير موجودة.',
    'file' => 'يجب أن يكون هذا الحقل ملفًا.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'يجب أن يكون هذا الحقل أكبر من :value.',
        'file' => 'يجب أن يكون هذا الحقل أكبر من :value كيلوبايت.',
        'string' => 'يجب أن يكون هذا الحقل أكبر من :value أحرف .',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'يجب أن  يكون هذا الحقل أكبر من أو تساوي :value.',
        'file' => 'يجب أن يكون هذا الحقل أكبر من أو تساوي :value كيلوبايت.',
        'string' => 'يجب أنيكون هذا الحقل أكبر من أو تساوي :value أحرف .',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'يجب أن  يكون هذا الحقل صورة.',
    'in' => ' هذا الحقل غير صالحة.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'يجب أن  يكون هذا الحقل أقل من :value.',
        'file' => 'يجب أن يكون هذا الحقل أقل من :value كيلوبايت.',
        'string' => 'يجب أن يكون هذا الحقل أقل من :value أحرف .',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'يجب أن يكون هذا الحقل أقل من أو تساوي :value.',
        'file' => 'يجب أن يكون هذا الحقل أقل من أو تساوي :value كيلوبايت.',
        'string' => 'يجب أن يكون هذا الحقل أقل من أو تساوي :value أحرف.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'لا يجوز أن يكون هذا الحقل أكبر من :max.',
        'file' => 'لا يجوز يكون هذا الحقل أكبر من :max كيلوبايت.',
        'string' => 'لا يجوز أن يكون هذا الحقل أكبر من :max أحرف.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'يجب أن يكون هذا الحقل ملفًا من النوع:  :values .',
    'mimetypes' => 'يجب أنيكون هذا الحقل ملفًا من النوع: :values.',
    'min' => [
        'numeric' => 'يجب أن يكون هذا الحقل :min على الاقل .',
        'file' => 'يجب ألا يقل  هذا الحقل عن :min كيلوبايت.',
        'string' => 'يجب ألا يقل هذا الحقل عن :min أحرف.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value',
    'not_in' => 'هذا الحقل المحدد غير صالح.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'يجب أن يكون هذا الحقل رقمًا.',
    'password' => 'كلمة المرور غير صحيحة.',
    'present' => 'يجب أن يكون حقل موجودًا.',
    'regex' => 'The :attribute format is invalid.',
    'required' => ' :attribute  مطلوب.',
    //    'required_if' => 'يكون هذا الحقل  مطلوبًا عندما :other هو :value.',
    'required_if' => 'هذا الحقل مطلوب.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    //    'required_with' => 'حقل السمة مطلوب عندما :values موجودة.',
    'required_with' => 'هذا الحقل مطلوب .',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'يجب أن يكون هذا الحقل :size.',
        'file' => 'يجب أن يكون هذا الحقل :size كيلوبايت.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'يجب أن تبدأ قيمة هذا الحقل بأحد القيم التالية:  :values .',
    'string' => 'يجب أن يكون هذا الحقل نصاً.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => 'تم بالفعل استخدام هذه القيمة.',
    'uploaded' => 'فشل في تحميل الملف .',
    'url' => 'تنسيق URL لهذا الحقل  غير صالح.',
    'uuid' => 'The :attribute must be a valid UUID.',

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
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'id' => 'الرقم التعريفي',
        "name" => 'الاسم',
        "nationality" => 'الجنسية',
        "unit" => 'الوحدة',
        "bransh" => 'الفرع',
        "managment" => 'الادارة',
        "department" => 'القسم',
        "phone_number" => 'رقم الهاتف',
        "sex" => 'الجنس',
        "birth_date" =>     'تاريخ الميلاد',
        "marital_status" => 'الحالة الاجتماعية',
        "employee_number" => 'رقم الموظف',
        "email" => 'البريد الالكتروني',
        "place_of_residence" => 'مكان الاقامة',
        "type_of_identity" => 'نوع الهوية',
        "identity_number" => 'رقم الهوية',
        "identity_export_date" => 'تاريخ انتهاء الهوية',
        "identity_place" => 'مكان الهوية',
        "qualification" => 'المؤهل',
        "qualification_type" => 'نوع المؤهل',
        "qualification_from_date" => "تاريخ بداية المؤهل",
        "qualification_to_date" => "تاريخ نهاية المؤهل",
        "group" => 'المجموعة',
        "group_from" => 'تاريخ المجموعة من',
        "group_to" => 'تاريخ المجموعة الى',
        "career_name" => 'الاسم الوظيفي',
        "career_degree" => 'الدرجة الوظيفية',
        "career_type" => 'نوع الوظيفة',
        "career_category" => 'فئة الوظيفة',
        "date_of_hiring" => 'تاريخ التعيين',
        "work_permit" => 'تصريح العمل',
        "permit_from" => 'بداية التصريح',
        "permit_to" => 'نهاية التصريح',
        "retirement_age" => 'سن التقاعد',
        "service_expirateion_date" => 'تاريخ بداية الخدمة',
        "in_work_date" => 'سنوات الخدمة الداخلية',
        "out_work_date" => 'سنوات الخدمة الخارجية',
        'done' => 'تم',
        'login' => 'دخول',
        'logout' => 'خروج'

    ],

];
