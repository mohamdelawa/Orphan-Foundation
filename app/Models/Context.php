<?php

namespace App\Models;


class Context
{
   public static function  columnsOrphans(){
       return [
                '#'=>[
                    'name'=>[ 'ar'=> '#',
                        'en'=> '#'],
                    'checked'=> true
                ],
                'orphanNumber'=>[
                    'name'=> [ 'ar' =>'رقم اليتيم',
                        'en' => 'Orphan Number'],
                    'checked'=> true
                ],
                'orphanName'=> [
                    'name'=>['ar' =>'اسم اليتيم',
                        'en'=> 'Orphan Name Arabic'
                    ],
                    'checked'=> true
                ],
                'orphanNameEn'=> [
                    'name'=>['ar'=>'اسم اليتيم (بالانجليزية)',
                        'en'=>'Orphan Name'],
                    'checked'=> true
                ],
                'mothersName'=>[
                    'name'=>['ar'=> 'اسم الام',
                        'en' => 'Mothers Name'],
                    'checked'=> false
                ],
                'mothersIdentity'=>[
                    'name'=>['ar'=>'رقم هوية الام',
                        'en'=>'Mothers Identity'],
                    'checked'=> false
                ],
                'breadwinnerName'=>[
                    'name'=>['ar'=> 'اسم المعيل',
                        'en'=>'Breadwinner Name Arabic'],
                    'checked'=> true
                ],
                'breadwinnerNameEn'=>[
                    'name'=> ['ar'=>'اسم المعيل (بالانجليزية)',
                        'en'=>'BreadWinner Name'],
                    'checked'=> true
                ],
                'relativeRelation'=>[
                    'name'=>[ 'ar'=>'صلة قرابة المعيل',
                        'en'=>'Relative Relation'],
                    'checked'=> false
                ],
                'breadwinnerIdentity'=>[
                    'name'=> ['ar'=>'رقم هوية المعيل',
                        'en'=>'Breadwinner Identity'],
                    'checked'=> true
                ],
                'phoneNumber'=>[
                    'name'=> ['ar'=>'رقم الجوال',
                        'en'=>'Phone Number'],
                    'checked'=> false
                ],
                'accountNumber'=>[
                    'name'=>['ar'=>'رقم الحساب',
                        'en'=>'Account Number'],
                    'checked'=> true
                ],
                'address'=> [
                    'name'=>['ar'=>'العنوان',
                        'en'=>'Address'],
                    'checked'=> false
                ],
                'educationalLevel'=>[
                    'name'=>['ar'=>'المرحلة الدراسية',
                        'en'=>'Educational Level'],
                    'checked'=> false
                ],
                'guarantyType'=>[
                    'name'=>['ar'=>'نوع الكفالة',
                        'en'=>'Guaranty Type'],
                    'checked'=> false
                ],
                'dob'=>[
                    'name'=>['ar'=>'تاريخ الميلاد',
                        'en'=>'Date Of Berth'],
                    'checked'=> false
                ],
                'healthStatus'=>[
                    'name'=>['ar'=>'الحالة الصحية',
                        'en'=>'Health Status'],
                    'checked'=> false
                ],
                'disease'=>[
                    'name'=> ['ar'=>'الامراض أو الاعاقة',
                        'en'=>'Disease'],
                    'checked'=> false
                ],
                'orphanIdentity'=>[
                    'name'=> ['ar'=>'رقم هوية اليتيم',
                        'en'=>'Orphan Identity'],
                    'checked'=> true
                ],
                'educationalAttainmentLevel'=> [
                    'name'=>['ar'=>'مستوى التحصيل العلمي',
                        'en'=>'Educational Attainment Level'],
                    'checked'=> false
                ],
                'gender'=>[
                    'name'=> ['ar'=>'الجنس',
                        'en'=>'Gender'],
                    'checked'=> false
                ],
                'fathersDeathDate'=>[
                    'name'=>['ar'=>'تاريخ وفاة الأب',
                        'en'=>'Fathers Death Date'],
                    'checked'=> false
                ],
                'causeOfDeath'=>[
                    'name'=> ['ar'=>'سبب وفاة الأب',
                        'en'=>'Cause Of Death'],
                    'checked'=> false
                ],
                'marketingDate'=>[
                    'name'=> ['ar'=>'تاريخ التسويق',
                        'en'=>'Marketing Date'],
                    'checked'=> false
                ],
                'guarantyDate'=>[
                    'name'=> ['ar'=>'تاربخ الكفالة',
                        'en'=>'Guaranty Date'],
                    'checked'=> false
                ],
       ];

   }
    public static function  columnsPayments(){
        return [
            '#'=>[
                'name'=>[ 'ar'=> '#',
                          'en'=> '#'],
                'checked'=> true
            ],
            'orphanNumber'=>[
                'name'=> [ 'ar' =>'رقم اليتيم',
                    'en' => 'Orphan Number'],
                'checked'=> true
                ],
            'orphanName'=> [
                'name'=>['ar' =>'اسم اليتيم',
                        'en'=> 'Orphan Name Arabic'
                ],
                'checked'=> true
            ],
            'orphanNameEn'=> [
                'name'=>['ar'=>'اسم اليتيم (بالانجليزية)',
                    'en'=>'Orphan Name'],
                'checked'=> true
            ],
            'mothersName'=>[
                'name'=>['ar'=> 'اسم الام',
                'en' => 'Mothers Name'],
                'checked'=> false
            ],
            'mothersIdentity'=>[
                'name'=>['ar'=>'رقم هوية الام',
                    'en'=>'Mothers Identity'],
                'checked'=> false
            ],
            'breadwinnerName'=>[
                'name'=>['ar'=> 'اسم المعيل',
                    'en'=>'Breadwinner Name Arabic'],
                'checked'=> true
            ],
            'breadwinnerNameEn'=>[
                'name'=> ['ar'=>'اسم المعيل (بالانجليزية)',
                    'en'=>'BreadWinner Name'],
                'checked'=> true
            ],
            'relativeRelation'=>[
                'name'=>[ 'ar'=>'صلة قرابة المعيل',
                    'en'=>'Relative Relation'],
                'checked'=> false
            ],
            'breadwinnerIdentity'=>[
                'name'=> ['ar'=>'رقم هوية المعيل',
                    'en'=>'Breadwinner Identity'],
                'checked'=> true
            ],
            'phoneNumber'=>[
                'name'=> ['ar'=>'رقم الجوال',
                    'en'=>'Phone Number'],
                'checked'=> false
            ],
            'accountNumber'=>[
                'name'=>['ar'=>'رقم الحساب',
                    'en'=>'Account Number'],
                'checked'=> true
            ],
            'address'=> [
                'name'=>['ar'=>'العنوان',
                    'en'=>'Address'],
                'checked'=> false
            ],
            'educationalLevel'=>[
                'name'=>['ar'=>'المرحلة الدراسية',
                    'en'=>'Educational Level'],
                'checked'=> false
            ],
            'guarantyType'=>[
                'name'=>['ar'=>'نوع الكفالة',
                    'en'=>'Guaranty Type'],
                'checked'=> false
            ],
            'dob'=>[
                'name'=>['ar'=>'تاريخ الميلاد',
                    'en'=>'Date Of Berth'],
                'checked'=> false
            ],
            'healthStatus'=>[
                'name'=>['ar'=>'الحالة الصحية',
                    'en'=>'Health Status'],
                'checked'=> false
            ],
            'disease'=>[
                'name'=> ['ar'=>'الامراض أو الاعاقة',
                    'en'=>'Disease'],
                'checked'=> false
            ],
            'orphanIdentity'=>[
                'name'=> ['ar'=>'رقم هوية اليتيم',
                    'en'=>'Orphan Identity'],
                'checked'=> true
            ],
            'educationalAttainmentLevel'=> [
                'name'=>['ar'=>'مستوى التحصيل العلمي',
                    'en'=>'Educational Attainment Level'],
                'checked'=> false
            ],
            'gender'=>[
                'name'=> ['ar'=>'الجنس',
                    'en'=>'Gender'],
                'checked'=> false
            ],
            'fathersDeathDate'=>[
                'name'=>['ar'=>'تاريخ وفاة الأب',
                    'en'=>'Fathers Death Date'],
                'checked'=> false
            ],
            'causeOfDeath'=>[
                'name'=> ['ar'=>'سبب وفاة الأب',
                    'en'=>'Cause Of Death'],
                'checked'=> false
            ],
            'marketingDate'=>[
                'name'=> ['ar'=>'تاريخ التسويق',
                    'en'=>'Marketing Date'],
                'checked'=> false
            ],
            'guarantyDate'=>[
                'name'=> ['ar'=>'تاربخ الكفالة',
                    'en'=>'Guaranty Date'],
                'checked'=> false
            ],
            'warrantyValue'=>[
                'name'=> ['ar'=>'المبلغ',
                    'en'=>'Amount'],
                'checked'=> false
            ],
            'warrantyValueConvert'=>[
                'name'=> ['ar'=>'المبلغ (بالشيكل)',
                    'en'=>'Amount (Shekel)'],
                'checked'=> true
                ],
            'currency'=>[
                'name'=> ['ar'=>'العملة',
                    'en'=> 'Currency'],
                'checked'=> false
            ],
            'paymentDate'=>[
                'name'=> ['ar'=>'تاريخ الصرفية',
                    'en'=> 'Payment Date'],
                'checked'=> false
            ],
            'exchangeRate'=>[
                'name'=> ['ar'=>'سعر الصرف',
                    'en'=> 'Exchange Rate'],
                'checked'=> false
            ],
            'commission'=> [
                'name'=>['ar'=>'عمولة',
                    'en'=> 'Commission'],
                'checked'=> false
            ],
            'namePayment'=>[
                'name'=> ['ar'=>'اسم الصرفية',
                    'en'=> 'Payment Name'],
                'checked'=> false
            ],
            'signature'=>[
                'name' => ['ar'=>'التوقيع',
                    'en'=> 'Signature'],
                'checked' => true
            ]
        ];

    }
}
