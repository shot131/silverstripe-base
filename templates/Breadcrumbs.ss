<% if $Count %>
    <ol class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
        <% loop $Me %>
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a class="breadcrumbs__item" itemprop="url" href="$Link"><span itemprop="name">$MenuTitle</span></a>
                <meta itemprop="position" content="$Pos" />
            </li> /
        <% end_loop %>
    </ol>
<% end_if %>