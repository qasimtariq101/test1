        <div class="sidebar col-md-3 col-sm-3 col-xs-3">
          <div class="widget woocommerce widget_product_categories">
              <h4 class="widget-title style-06">{{ __('Categories')}}</h4>
              <ul class="product-categories">     
                  <li><a @if(app('request')->get('category') == 'all') class="active" @endif href="{{route('books.index',['category'=>'all'])}}">{{ __('all')}}</a></li>
                            
                  @foreach($categories as $category)
                    @if($category->sub_categories->count() > 0)
                  <li class="cat-parent @if(app('request')->get('category') == $category->slug || in_array(app('request')->get('category'), $category->sub_categories->pluck('slug')->toArray())) open @endif">   
                              <a @if(app('request')->get('category') == $category->slug || in_array(app('request')->get('category'), $category->sub_categories->pluck('slug')->toArray())) class="active" @endif href="{{$category->url}}">{{$category->name}}</a>
                              <ul class="children">
                                @foreach($category->sub_categories as $sub_category)
                                    <li><a @if(app('request')->get('category') == $sub_category->slug) class="active" @endif href="{{$sub_category->url}}"> {{$sub_category->name}} </a></li>
                                  @endforeach
                              </ul>
                          </li>
                    @else
                      <li><a @if(app('request')->get('category') == $category->slug) class="active" @endif href="{{$category->url}}">{{$category->name}}</a></li>
                    @endif
                  @endforeach
              </ul>
              
<!-- Taleem360 Sidebar - 270 x 480px
<div class="taleemsidead" style="position: relative;margin-top:10px;">
<a href="https://www.taleem360.com/t-ads/click.php?id=taleem360app-4" target="_blank"><img src="https://www.taleem360.com/img/ads/taleemsidead.gif" alt="Taleem 360 Android App" style="width:100%;border:1px solid #26a918;padding: 5px;margin-top: 5px;"/></a>
<div class="topright" style="position: absolute;bottom: 6px;right: 15px;font-size: 10px;">Official App</div>
</div>
Taleem360 Sidebar - 270 x 480px -->
              
          </div>
          <!-- widget -->
          
          <div class="widget reading-module-module-ads-4"> @if(config('settings.ad') == 1 && !empty(config('settings.ad3')))
            <div class="col-md-12 text-center ad">@php echo html_entity_decode(config('settings.ad3')) @endphp</div>
            @endif 
          </div>
          <!-- widget --> 
          
        </div>
        <!-- col-md-3 --> 


