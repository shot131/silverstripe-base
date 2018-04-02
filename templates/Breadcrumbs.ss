<% if $Count %>
    <ol class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
        <% loop $Me %>
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumbs__item">
                <a itemprop="url" href="$Link"><span itemprop="name">$MenuTitle</span></a>
                <meta itemprop="position" content="$Pos" />
            </li> /
        <% end_loop %>
    </ol>
<% end_if %>