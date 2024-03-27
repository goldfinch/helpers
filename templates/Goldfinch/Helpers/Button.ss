<% if LinkObject %>
  <% with LinkObject %>
    <button
      $Top.attrs
      <% if Top.attrId %> id="{$Top.attrId}"<% end_if %>
      <% if $Top.attrClass %> class="{$Top.attrClass}" <% end_if%>
      <% if $OpenInNew %>target="_blank" rel="noopener noreferrer"<% end_if %>
    >$Title</button>
  <% end_with %>
<% end_if %>
