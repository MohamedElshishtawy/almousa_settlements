<div class="img" style="text-align: center;
        margin: 30px;
        position: relative;">

    @php( $img = \App\Models\Student::student_image(Auth::user()->id) ?? null )

    <img style="width: 120px;
        height: 120px;
        border-radius: 10px;
        border: 1px dashed black;
        padding: 5px;" id="imgShow"
         src="{{ $img ? asset('storage/'.\App\Models\Student::student_image(Auth::user()->id) ) . '?'.time()  :  asset('images/icon/student.png')}}"
         alt="">
</div>
