# مخطط قاعدة البيانات (ERD)

## نظرة عامة

قاعدة بيانات نظام إدارة العيادات تتكون من 6 جداول رئيسية مع علاقات محددة بينها.

## الجداول

### 1. users (المستخدمين)
جدول المستخدمين ومعلومات المصادقة

| الحقل | النوع | الوصف |
|-------|-------|--------|
| id | bigint | المعرف الفريد |
| name | varchar(255) | اسم المستخدم |
| email | varchar(255) | البريد الإلكتروني (فريد) |
| password | varchar(255) | كلمة المرور المشفرة |
| role | enum | الدور (مدير، موظف) |
| created_at | timestamp | تاريخ الإنشاء |
| updated_at | timestamp | تاريخ آخر تحديث |

---

### 2. patients (المرضى)
جدول بيانات المرضى

| الحقل | النوع | الوصف |
|-------|-------|--------|
| id | bigint | المعرف الفريد |
| name | varchar(255) | الاسم الكامل |
| phone | varchar(20) | رقم الهاتف |
| address | text | العنوان (اختياري) |
| gender | enum | الجنس (ذكر، أنثى) |
| birth_date | date | تاريخ الميلاد |
| blood_type | varchar(10) | فصيلة الدم (اختياري) |
| medical_history | text | التاريخ الطبي (اختياري) |
| created_at | timestamp | تاريخ الإنشاء |
| updated_at | timestamp | تاريخ آخر تحديث |

**العلاقات:**
- `hasMany` → appointments
- `hasMany` → invoices
- `hasMany` → medical_records

---

### 3. doctors (الأطباء)
جدول بيانات الأطباء

| الحقل | النوع | الوصف |
|-------|-------|--------|
| id | bigint | المعرف الفريد |
| name | varchar(255) | اسم الطبيب |
| phone | varchar(20) | رقم الهاتف |
| specialization | varchar(255) | التخصص |
| duty_schedule | json | جدول أوقات العمل (JSON) |
| created_at | timestamp | تاريخ الإنشاء |
| updated_at | timestamp | تاريخ آخر تحديث |

**العلاقات:**
- `hasMany` → appointments
- `hasMany` → medical_records

**ملاحظة:** duty_schedule يخزن جدول العمل الأسبوعي بصيغة JSON:
```json
{
    "الأحد": "09:00-17:00",
    "الاثنين": "09:00-17:00",
    "الثلاثاء": "09:00-17:00"
}
```

---

### 4. appointments (المواعيد)
جدول المواعيد الطبية

| الحقل | النوع | الوصف |
|-------|-------|--------|
| id | bigint | المعرف الفريد |
| patient_id | bigint | معرف المريض (مفتاح أجنبي) |
| doctor_id | bigint | معرف الطبيب (مفتاح أجنبي) |
| appointment_date | date | تاريخ الموعد |
| appointment_time | time | وقت الموعد |
| status | enum | الحالة (محجوز، مكتمل، ملغي) |
| notes | text | ملاحظات (اختياري) |
| created_at | timestamp | تاريخ الإنشاء |
| updated_at | timestamp | تاريخ آخر تحديث |

**العلاقات:**
- `belongsTo` → patient
- `belongsTo` → doctor
- `hasOne` → invoice
- `hasOne` → medical_record

**المفاتيح الأجنبية:**
- patient_id → patients.id (cascade on delete)
- doctor_id → doctors.id (cascade on delete)

**القيود:**
- النظام يمنع تعارض المواعيد للطبيب الواحد

---

### 5. invoices (الفواتير)
جدول الفواتير والمدفوعات

| الحقل | النوع | الوصف |
|-------|-------|--------|
| id | bigint | المعرف الفريد |
| patient_id | bigint | معرف المريض (مفتاح أجنبي) |
| appointment_id | bigint | معرف الموعد (اختياري، مفتاح أجنبي) |
| amount | decimal(10,2) | المبلغ |
| payment_status | enum | حالة الدفع (غير مدفوع، مدفوع، مدفوع جزئياً) |
| payment_date | date | تاريخ الدفع (اختياري) |
| items | json | بنود الفاتورة (JSON اختياري) |
| created_at | timestamp | تاريخ الإنشاء |
| updated_at | timestamp | تاريخ آخر تحديث |

**العلاقات:**
- `belongsTo` → patient
- `belongsTo` → appointment

**المفاتيح الأجنبية:**
- patient_id → patients.id (cascade on delete)
- appointment_id → appointments.id (set null on delete)

---

### 6. medical_records (السجلات الطبية)
جدول السجلات الطبية للمرضى

| الحقل | النوع | الوصف |
|-------|-------|--------|
| id | bigint | المعرف الفريد |
| patient_id | bigint | معرف المريض (مفتاح أجنبي) |
| doctor_id | bigint | معرف الطبيب (مفتاح أجنبي) |
| appointment_id | bigint | معرف الموعد (اختياري، مفتاح أجنبي) |
| diagnosis | text | التشخيص |
| prescription | text | الوصفة الطبية (اختياري) |
| notes | text | ملاحظات إضافية (اختياري) |
| created_at | timestamp | تاريخ الإنشاء |
| updated_at | timestamp | تاريخ آخر تحديث |

**العلاقات:**
- `belongsTo` → patient
- `belongsTo` → doctor
- `belongsTo` → appointment

**المفاتيح الأجنبية:**
- patient_id → patients.id (cascade on delete)
- doctor_id → doctors.id (cascade on delete)
- appointment_id → appointments.id (set null on delete)

---

## مخطط العلاقات (ERD Diagram)

```
┌─────────────┐
│   users     │
│ (المستخدمون) │
└─────────────┘
      

┌─────────────┐         ┌──────────────┐         ┌─────────────┐
│  patients   │         │ appointments │         │   doctors   │
│  (المرضى)   │1───────*│  (المواعيد)  │*───────1│  (الأطباء)  │
└─────────────┘         └──────────────┘         └─────────────┘
      │1                      │1│1                      │1
      │                       │ │                       │
      │                       │ │                       │
      │*                      │*│*                      │*
┌─────────────┐         ┌──────┴──────┐         ┌─────────────┐
│  invoices   │         │   medical   │         
│  (الفواتير) │         │   records   │         
└─────────────┘         │ (السجلات)   │         
                        └─────────────┘         
```

## ملاحظات مهمة

### الفهارس (Indexes)
- جميع المفاتيح الأجنبية مفهرسة تلقائياً
- البريد الإلكتروني في جدول users فريد ومفهرس

### الحذف التسلسلي (Cascade Delete)
- حذف مريض → حذف جميع مواعيده، فواتيره، وسجلاته الطبية
- حذف طبيب → حذف جميع مواعيده وسجلاته الطبية
- حذف موعد → تعيين null للفواتير والسجلات المرتبطة

### منع التعارض
يحتوي نموذج Appointment على دالة `hasConflict()` التي تمنع:
- حجز موعدين لنفس الطبيب في نفس الوقت
- يستثنى الموعد عند التعديل

### تخزين JSON
- **duty_schedule**: جدول أوقات عمل الطبيب
- **items**: بنود الفاتورة التفصيلية

---

**آخر تحديث:** ديسمبر 2025  
**النسخة:** 1.0.0
