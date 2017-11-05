<% if $Count %>
    <div class="breadcrumbs">
        <% loop $Me %>
            <a class="breadcrumbs__item" href="$Link">$MenuTitle</a> /
        <% end_loop %>
    </div>
<% end_if %>