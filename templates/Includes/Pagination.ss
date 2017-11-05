<% if $MoreThanOnePage %>
    <div class="pagination" data-current="$CurrentPage" data-total="$TotalPages">
        <div class="container">
            <ul class="pagination__list">
                <% if $NotFirstPage %>
                    <li class="pagination__item h-xs">
                        <a href="/$FirstLink">1</a>
                    </li>
                    <li class="pagination__item pagination__item_prev h-xs">
                        <a href="/$PrevLink"></a>
                    </li>
                <% end_if %>
                <% loop $Pages(5) %>
                    <% if $CurrentBool %>
                        <li class="pagination__item pagination__item_active">
                            <span>$PageNum</span>
                        </li>
                    <% else %>
                        <li class="pagination__item">
                            <a href="/$Link">$PageNum</a>
                        </li>
                    <% end_if %>
                <% end_loop %>
                <% if $NotLastPage %>
                    <li class="pagination__item pagination__item_next h-xs">
                        <a href="/$NextLink"></a>
                    </li>
                    <li class="pagination__item h-xs">
                        <a href="/$LastLink">$TotalPages</a>
                    </li>
                <% end_if %>
            </ul>
            <% if $More && $NotLastPage %>
                <a class="pagination__more" href="/$NextLink" data-id="more">Показать еще</a>
            <% end_if %>
        </div>
    </div>
<% end_if %>