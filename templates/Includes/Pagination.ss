<% if $MoreThanOnePage %>
    <div class="pagination" data-min="1" data-max="$TotalPages">
        <div class="pagination__main">
            <div class="pagination__arrow pagination__arrow_prev"></div>
            <div class="pagination__pages">
                <div class="pagination__input">
                    <input type="text" value="$CurrentPage">
                </div> из <span data-id="max">$TotalPages</span>
            </div>
            <div class="pagination__arrow pagination__arrow_next"></div>
        </div>
        <% if not $NoMore %>
            <a class="pagination__more button" href="#">Загрузить ещё</a>
        <% end_if %>
    </div>
<% end_if %>