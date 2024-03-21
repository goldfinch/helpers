<% if LinkObject %>
  <% with LinkObject %>
    <a
      href="$URL"
      <% if Top.attrId %> id="{$Top.attrId}"<% end_if %>
      <% if $Top.attrClass %> class="{$Top.attrClass}" <% end_if%>
      <% if $OpenInNew %>target="_blank" rel="noopener noreferrer"<% end_if %>
    >$Title</a>
  <% end_with %>
<% end_if %>



