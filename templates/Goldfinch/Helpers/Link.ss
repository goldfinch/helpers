<% if LinkObject %>
  <% with LinkObject %>
    <% if LinkURL %>
      <a{$IDAttr}{$ClassAttr} class="{$Top.attrClass}" href="{$LinkURL}"{$TargetAttr}>$Title</a>
    <% end_if %>
  <% end_with %>
<% end_if %>
