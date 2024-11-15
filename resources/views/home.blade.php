@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('الرئيسية') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(auth()->user()->isAdmin())
                        <h1>السلام عليكم يا استا محمد</h1>
{{--                        <p>هذه رسالة منى مهمة <br>--}}
{{--                        فى خالة حدوث خطأ فى الموقع وقت العمل ستحتاج ان ترسل لى رسالة على مستقل وبسبب ظروف الدراسة و العمل هناك اوقات محدده التى افتح فيها رسائل مستقل--}}
{{--                            <br>--}}
{{--                            لذلك إذا حدثت مشكلة فى الموقع مفاجئة أو كان هناك طلب ضرورى جدا كلمنى على رقم هاتفى وسأرد فورا إن شاء الله--}}
{{--                            <br>--}}
{{--                            +201093033115--}}
{{--                            <br>--}}
{{--                            وفى حالة العمل أو اى شئ يمكنك التواصل على مستقل--}}
{{--                            <br>--}}
{{--                            إذا قرأت الرسالة قول لى فى مستقل (تمام!!!)--}}
{{--                        </p>--}}
                        @else
                        <h2>السلام عليكم يا {{auth()->user()->name}}</h2>
                            <article class="mt-3">
                                <strong>إليك بعض التعليمات التى قد تساعدك</strong>
                                <ul class="mt-2">
                                    <li>أولا <span class="text-success">  صل على الحبيب وإستعن بالله</span>  فالأمر بسيط إن شاء الله</li>
                                    <li>انت حاليا مسؤل عن مقر
                                        <strong>{{\App\Models\Employee::find(auth()->id())->employeeOffice->office->name}}</strong>
                                        , وفى حالة وجود خطأ فى المقر إرجع لأدمن الموقع
                                    </li>
                                    <li>يمكنك الدخول الى صفحة المحاضر لتملأ محضر التوريد أو الوفر</li>
                                    <li>ستظهر كل المحاضر المتاحة <span class="text-danger">مع بداية اول يوم</span> للعمل فى المقر إن شاء الله وستخنفى المحاضر بعد إنتهاء الفترة</li>
                                    <li>سوف يتمكن الأدمن الخاص بالموقع الإطلاع على التعديدلات والمدخلات التى قد أدخلتها</li>
                                </ul>
                            </article>

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
