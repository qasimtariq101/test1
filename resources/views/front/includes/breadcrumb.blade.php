<div class="breadcrumb-content" itemscope itemtype="https://schema.org/BreadcrumbList">
  <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
    <a itemprop="item" href="{{url('/')}}" class="active">
      <span itemprop="name">{{ __('Home')}}</span>
    </a>
    <meta itemprop="position" content="1">
  </span>
  <span>&nbsp;&nbsp; / &nbsp;&nbsp;</span>
  <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
    <a itemprop="item" class="current-page">
      <span itemprop="name">{{$page_title}}</span>
    </a>
    <meta itemprop="position" content="2">
  </span>
</div>
