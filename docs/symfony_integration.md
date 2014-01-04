# Symfony Integration

Integrating Porpaginas into a Symfony application is fairly easy.  There is no
bundle yet, so you have to register some of the services manually.

```xml
<service id="porpaginas.twig.extension" class="Porpaginas\Twig\PorpaginasExtension">
    <argument type="service" id="porpaginas.twig.rendering_adapter" />
</service>

<!-- When using Pagerfanta for Rendering -->
<service id="porpaginas.twig.rendering_adapter" class="Porpaginas\Twig\PagerfantaRenderingAdapter">
    <argument>viewname</argument>
    <argument type="collection" /><!-- options here -->
</service>

<!-- When using KnpPager for Rendering --> 
<service id="porpaginas.twig.rendering_adapter" class="Porpaginas\Twig\KnpPagerRenderingAdapter">
    <argument type="service" id="knp_paginator" />
</service>
```

