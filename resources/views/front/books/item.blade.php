 @php $rn = rand(1,8); @endphp
<li class="col-md-4 col-sm-4 col-xs-4">
  <article class="entry-item ct-item-4 style-0{{$rn}}">
    <div class="entry-thumb">  <a href="{{$b->url}}"> <img class="lazyload" src="{{ url('images/default.png') }}" data-src="{{$b->thumbnail_f}}" alt="{{$b->title_f}}"> </a>
      <div class="entry-content">
        <header>
          <h3 class="entry-title"><i class="fa {{book_icon($b->file)}} ct-alert-1 style-06"></i> @if(!empty($b->password))<i class="fa fa-lock ct-alert-1 style-03 small"></i>@endif <a href="{{$b->url}}">{{$b->title_f}}</a></h3>
          @if(config('settings.allow_ratings') == 1)
          <div class="kopa-rating">
            <div class="star-rating" title="{{ __('Average Rating')}}"> @php
              $p = ($b->average_rating * 100) / 5;
              @endphp <span style="width: {{$p}}%;"> </span> 
            </div>
          </div>
          @endif
        </header>
        <p>{{$b->short_overview}}</p>
        <p class="ct-space-1"></p>
        <div class="ct-icon-1" style="background: url({{(isset($b->user))?$b->user->avatar:'/img/default-avatar.png'}});background-size: 100%;"> </div>
        <footer>
          <div class="ft-wrap style-01">
            <ul>
              <li> <a href="@if(isset($b->user)){{$b->user->url}}@else{{'#'}}@endif"> <i class="fa fa-user"></i> {{ __('by')}} @if(!empty($b->author_name)){{ $b->author_name }}@else @if(isset($b->user)){{$b->user->name}}@else {{__('Guest')}}@endif @endif </a> </li>
              <li> <a href="{{$b->category->url}}"> <i class="fa fa-folder-o"></i> {{$b->category->name}} </a> </li>
            </ul>
          </div>
          <div class="ft-wrap style-02">
            <ul>
              <li>
                <div class="add-to-wishlist">
                  <div> <a class="add_to_favorite" data-pid="{{$b->id}}" data-action="add" title="{{ __('Add to favorite')}}"> <i class="fa  @if(in_array($b->id,$favorites))  fa-heart @else   fa-heart-o @endif"></i> <span>{{ __('Add to favorite')}}</span> </a> </div>
                </div>
              </li>
              <li> <a href="{{$b->url}}"> <i class="ti-new-window"></i> <span>{{ __('Details')}}</span> </a> </li>
            </ul>
          </div>
        </footer>
      </div>
    </div>
  </article>
  @if(!empty($b->label))
  <div class="badge-icon-1 style-0{{$rn}}"> {{$b->label}} <span></span> </div>
  @endif </li>
<!-- product-item -->