<div class="side-bar">
    <ul>
        <li class="title"><a href="{{ url('admin') }}"><i class="fa-solid fa-chart-line"></i><div>Dashboard</div></a></li>
        <li><a href="{{route('admin.products.index')}}"><i class="fa-solid fa-store"></i><div>Tutti i Prodotti</div></a></li>
        <li><a href="{{route('admin.types.index')}}"><i class="fa-solid fa-atom"></i><div>Tutti i Tipi</div></a></li>
        <li><a href="{{route('admin.brands.index')}}"><i class="fa-brands fa-shopify"></i><div>Tutti i Brand</div></a></li>
        <li><a href="{{route('admin.categories.index')}}"><i class="fa-solid fa-diagram-project"></i><div>Tutte le Categorie</div></a></li>
        <li><a href="{{route('admin.tags.index')}}"><i class="fa-solid fa-tag"></i><div>Tutti i Tags</div></a></li>
    </ul>
</div>