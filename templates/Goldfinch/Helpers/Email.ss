<% if LinkObject %>
  <a
    href="mailto:$LinkObject"
    <% if Top.attrId %> id="{$Top.attrId}"<% end_if %>
    <% if $Top.attrClass %> class="{$Top.attrClass}" <% end_if%>
  ><% if Top.attrTitle %>$Top.attrTitle<% else %>$LinkObject<% end_if %></a>
<% end_if %>
