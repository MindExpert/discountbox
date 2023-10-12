@props([
    'credits' => $credits ?? []
])
<div class="tab-pane" id="credits-tab">
    <div class="col-lg-12 content">
        <div class="section-title">
            <h4>@lang('user.actual_credit'): {{ $credits->sum('credit') }}</h4>
        </div>
        @foreach($credits as $credit)
            <div class="icon-box aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                <div class="icon"><i class="bi {{$credit->type->icon()}} text-{{$credit->type->color()}}"></i></div>
                <h6 class="title" style="margin-left: 60px"><a href="">{{ $credit->name }}</a></h6>
                <p class="description">
                    {{ "$credit->notes" }} @if($credit->credit > 0) {{ $credit->credit }} @else {{ $credit->debit }} @endif <br/>
                    @lang('transaction.fields.type'): {{ $credit->type->label() }} <br>
                    {{ $credit->type->description($credit->credit) }}
                </p>
            </div>
        @endforeach
    </div>
</div>
