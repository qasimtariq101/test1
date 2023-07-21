@php
echo '<?xml version="1.0" encoding="UTF-8"?>';
@endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    <url>
        <loc>{{url('/')}}</loc>
    </url>
    @foreach($pages as $page)
    <url>
        <loc>{{route('page.show',[$page->slug])}}</loc>
    </url>
    @endforeach       
    <url>
        <loc>{{route('login')}}</loc>
    </url>    
     <url>
        <loc>{{route('register')}}</loc>
    </url>     
    <url>
        <loc>{{route('books.index')}}</loc>
    </url>     

    <url>
        <loc>{{route('upload')}}</loc>
    </url>      
    <url>
        <loc>{{route('contact')}}</loc>
    </url>      

    <url>
        <loc>{{route('publishers.index')}}</loc>
    </url>  

    @foreach($categories as $category)
    <url>
        <loc>{{$category->url}}</loc>
    </url>         
    @endforeach    
    
</urlset>