@php
    end($allLang);
        $key = key($allLang);
@endphp
<ul class="nav navbar-nav">
    <li class="dropdown dropdown-language nav-item">
        <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
            <i class="feather icon-globe" style="font-size: 1.5rem"></i>
            <span class="selected-language">{{$lang}}</span>
            <i class="feather icon-chevron-down"></i>
        </a>
        <ul class="dropdown-menu" aria-labelledby="dropdown-flag">
            @foreach($allLang as $name=>$cnName)
                <li class="dropdown-item {{$selector}}" data-lang="{{$name}}">
                    <a href="javascript:void(0);">{{$cnName}}</a>
                </li>
                @if($key!=$name)
                    <li class="dropdown-divider"></li>
                @endif
            @endforeach
        </ul>
    </li>
</ul>