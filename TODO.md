Comes with

DataObject
- required fields
- field descriptions
- ShortcodeVarchar

# env vars
`APP_DEV_EMAIL`
`APP_ERROR_LOG`
`APP_FORCE_SSL`
`APP_FORCE_WWW`

Sluggable extension

```
App\Models\SomeModel...:
  extensions:
    - Goldfinch\Helpers\Extensions\DataObjectSluggable

-----

class SomeModel extends DataObject

    private static $urlsegment_source = 'Title';

}
```

```html
<% include Goldfinch/Helpers/Link LinkObject=$Icon1Link, attrClass='btn btn-link' %>
<% include Goldfinch/Helpers/InlineLink LinkObject=$CustomLink, attrClass='btn btn-link' %>

<% loop List.EOL %>
$Line
<% end_loop %>
```
