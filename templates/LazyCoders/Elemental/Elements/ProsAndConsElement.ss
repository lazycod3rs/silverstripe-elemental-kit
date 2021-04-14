<div class="grid-container">
    <% if ShowTitle %>
        <h2>$Title</h2>
    <% end_if %>
    <div class="grid-x grid-margin-x">
        <div class="cell medium-auto">
            <ul>
                <% loop $Pros.Items %>
                    <li>$Value</li>
                <% end_loop %>
            </ul>
        </div>
        <div class="cell medium-auto">
            <ul>
                <% loop $Cons.Items %>
                    <li>$Value</li>
                <% end_loop %>
            </ul>
        </div>
    </div>
</div>
