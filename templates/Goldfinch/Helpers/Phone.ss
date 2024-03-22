<% if LinkObject %>
  <% with LinkObject %>
    <a
      href="tel:{$International}"
      <% if Top.attrId %> id="{$Top.attrId}"<% end_if %>
      <% if $Top.attrClass %> class="{$Top.attrClass}" <% end_if%>
    >$National</a>
  <% end_with %>
<% end_if %>



