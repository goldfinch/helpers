<%-- TODO: used Link.ss at the moment and needs to be changed to LinkRel --%>
<% if LinkObject %>
  <% with LinkObject %>
      <a
        <% if Top.attrId %> id="{$Top.attrId}"<% end_if %>
        <% if Top.attrClass %> class="{$Top.attrClass}"<% end_if %>
        <% if OpenInNew %> target="_blank"<% end_if %>
        href="{$URL}"
      >$Title</a>
  <% end_with %>
<% end_if %>
