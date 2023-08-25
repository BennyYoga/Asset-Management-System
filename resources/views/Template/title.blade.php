<div class="title-wrapper pt-30">
    <div class="row align-items-center">
        <div class="col-md-6 mb-3">
            <div class="title">
                <h2>{{$title}}</h2>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="breadcrumb-wrapper">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @php $i = 1; @endphp
                        @foreach ($breadcrumb as $k => $v)
                            @php
                                $isLast = $i==count($breadcrumb) ? true : false;
                                $class = $isLast ? "active" : "";
                                $aria = $isLast ? "aria-current=page" : "";
                                $i++;
                            @endphp
                            <li class="breadcrumb-item {{$class}}" {{$aria}}>
                                <a href="{{ $v }}">{{ $k }}</a>
                            </li>
                        @endforeach
                    </ol>
                </nav>
            </div>
        </div>
        @isset($create)
            <div class="col-md-12 d-flex justify-content-end mb-3">
                <a href="{{$create['url']}}" class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    {{$create['text']}}
                </a>
            </div>
        @endisset
    </div>
</div>
