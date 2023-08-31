<div class="title-wrapper pt-30">
    <div class="row align-items-center">
        @isset($create)
            <div class="col-md-12">
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
            <div class="col-md-6 mb-3">
                <div class="title">
                    <h2>{{$title}}</h2>
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-end mb-3">
                <div class="btn-group" role="group" aria-label="Dropdown">
                    <a href="{{$create['url']}}" class="btn btn-sm btn-primary">
                        <i class="fa-solid fa-plus"></i>
                        {{$create['text']}}
                    </a>
                    @isset($create["dropdown"])
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                            <ul class="dropdown-menu">
                                @foreach ($create["dropdown"] as $k => $v)
                                    <li>
                                        <a class="dropdown-item" href="{{$v}}">{!!$k!!}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endisset
                </div>
            </div>
        @else
            <div class="col-md-6 mb-3">
                <div class="title">
                    <h2>{{$title}}</h2>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="breadcrumb-wrapper">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
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
        @endisset
    </div>
</div>
