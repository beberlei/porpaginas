# Symfony Integration

Integrating Porpaginas into a Symfony application is fairly easy.  There is (PorpaginasBundle)[https://github.com/fightmaster/PorpaginasBundle], but you can to register some of the services manually also.

```xml
<service id="porpaginas.twig.extension" class="Porpaginas\Twig\PorpaginasExtension">
    <argument type="service" id="porpaginas.twig.rendering_adapter" />
    <tag name="twig.extension" />
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

<service id="porpaginas.twig.subscriber" class="Porpaginas\KnpPager\PorpaginasSubscriber">
    <tag name="knp_paginator.subscriber" />
</service>
```

